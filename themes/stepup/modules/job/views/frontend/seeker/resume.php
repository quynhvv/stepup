<?php
use app\components\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-1col">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-main section-gap section-resume">
                            <ul class="nav nav-tabs nav-justified" id="nav-resume">
                                <li>
                                    <span>Resume</span>
                                </li>
                                <li role="presentation" class="active">
                                    <a role="button" href="#">1: Basic Information</a>
                                </li>
                                <li role="presentation">
                                    <a role="button" href="#">2: Free Format Resume</a>
                                </li>
                                <li role="presentation">
                                    <a role="button" href="#">3: Job preferences</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active">
                                    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                                        <?php
                                        $form = ActiveForm::begin([
                                            'id' => 'formDefault',
                                            'layout' => 'horizontal',
                                            'options' => ['enctype' => 'multipart/form-data'],
                                            'fieldConfig' => [
                                                'horizontalCssClasses' => [
                                                    'label' => 'col-sm-3',
                                                    'wrapper' => 'col-sm-9',
                                                    'error' => 'help-block m-b-none',
                                                    'hint' => '',
                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <fieldset>
                                            <legend><?= Yii::t('job', 'Personal Info.') ?></legend>
                                            <?= $form->field($model, 'nationality')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => Yii::t('job', 'Nationality')]) ?>
                                            <?= $form->field($model, 'location')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => Yii::t('job', 'Current Location')]) ?>

                                            <div class="form-group">
                                                <?= Html::label(Yii::t('job', 'Contact number'), null, ['class' => 'control-label col-sm-3']) ?>
                                                <div class="col-sm-5">
                                                    <?= Html::activeDropDownList($model, 'phone_country', $model->getCountryCodeOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Country Code')]) ?>
                                                    <?= Html::error($model, 'phone_country') ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= Html::activeTextInput($model, 'phone_number', ['class' => 'form-control', 'placeholder' => Yii::t('job', '999-999-999')]) ?>
                                                    <?= Html::error($model, 'phone_number') ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <?= Html::label(Yii::t('job', 'Social Media'), null, ['class' => 'control-label col-sm-3']) ?>
                                                <div class="col-sm-9">
                                                    <?= Html::activeTextInput($model, 'social_linkedin', ['class' => 'form-control', 'placeholder' => Yii::t('job', 'Please input your LinkedIn Profile URL')]) ?>
                                                    <?= Html::error($model, 'social_linkedin') ?>

                                                    <?= Html::activeTextInput($model, 'social_facebook', ['class' => 'form-control', 'placeholder' => Yii::t('job', 'Please input your Facebook Profile URL')]) ?>
                                                    <?= Html::error($model, 'social_facebook') ?>

                                                    <?= Html::activeTextInput($model, 'social_twitter', ['class' => 'form-control', 'placeholder' => Yii::t('job', 'Please input your Twitter Profile URL')]) ?>
                                                    <?= Html::error($model, 'social_twitter') ?>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <legend><?= Yii::t('job', 'Basic Career Overview') ?></legend>
                                            <?= $form->field($model, 'experience')->dropDownList($model->getExperienceOptions(), ['prompt' => Yii::t('job', 'Total Years of Work Experience')]) ?>
                                            <?= $form->field($model, 'functions')->widget(Select2::classname(), [
                                                'data' => \app\modules\job\models\JobFunction::getOptions(),
                                                'options' => ['placeholder' => Yii::t('job', 'Select Functions')],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]) ?>
                                            <?= $form->field($model, 'industries')->widget(Select2::classname(), [
                                                'data' => \app\modules\job\models\Job::getCategoryOptions(),
                                                'options' => ['placeholder' => Yii::t('job', 'Select Industries'), 'multiple' => 'multiple'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]) ?>
                                        </fieldset>

                                        <fieldset>
                                            <legend><?= Yii::t('job', 'Employment History') ?></legend>

                                            <?= $form->field($model, 'salary')->dropDownList(\app\modules\job\models\JobSalary::getOptions(), ['prompt' => 'In US Dollars']) ?>

                                            <div class="employment-history-wrapper">
                                            <?php if (is_array($employments)) : ?>
                                                <?php $count = 0; ?>
                                                <?php foreach($employments as $index => $employment): ?>
                                                    <?php $count++; ?>
                                                    <div class="employment-history">
                                                        <?php if ($count == 1) : ?>
                                                            <div><strong><?= Yii::t('job', 'Latest Employment Info.') ?></strong></div>
                                                        <?php else : ?>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <strong class="pull-left"><?= Yii::t('job', 'Employment Info') . " ({$count})" ?></strong>
                                                                    <a class="pull-right" href="<?= Url::to(['employment-remove', 'id' => $employment->_id]) ?>" onclick="js:delEmploymentInfo($(this)); return false"><?= Yii::t('job', '- Delete Employment Info') ?></a>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?= $form->field($employment, "[$index]_id")->hiddenInput(['class' => "employment-history-id"])->label(false); ?>
                                                        <?= $form->field($employment, "[$index]company_name"); ?>
                                                        <?= $form->field($employment, "[$index]position"); ?>
                                                        <div class="form-group">
                                                            <?= Html::label(Yii::t('job', 'Period of Employment'), null, ['class' => 'control-label col-sm-3']) ?>
                                                            <div class="col-sm-2">
                                                                <?= Html::activeDropDownList($employment, "[$index]belong_month_from", $model->getEducationMonthOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Month:')]) ?>
                                                                <?= Html::error($employment, "[$index]belong_month_from") ?>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <?= Html::activeDropDownList($employment, "[$index]belong_year_from", $model->getEducationYearOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Year:')]) ?>
                                                                <?= Html::error($employment, "[$index]belong_year_from") ?>
                                                            </div>
                                                            <div class="col-sm-1" style="text-align:center">-</div>
                                                            <div class="col-sm-2">
                                                                <?= Html::activeDropDownList($employment, "[$index]belong_month_to", $model->getEducationMonthOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Month:')]) ?>
                                                                <?= Html::error($employment, "[$index]belong_month_to") ?>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <?= Html::activeDropDownList($employment, "[$index]belong_year_to", $model->getEducationYearOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Year:')]) ?>
                                                                <?= Html::error($employment, "[$index]belong_year_to") ?>
                                                            </div>
                                                        </div>
                                                        <?= $form->field($employment, "[$index]description")->textarea(['style' => 'height:100px']); ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="employment-history">
                                                    <?= $form->field($employments, "_id")->hiddenInput(['class' => "employment-history-id"])->label(false); ?>
                                                    <?= $form->field($employments, "company_name"); ?>
                                                    <?= $form->field($employments, "position"); ?>

                                                    <div class="form-group">
                                                        <?= Html::label(Yii::t('job', 'Period of Employment'), null, ['class' => 'control-label col-sm-3']) ?>
                                                        <div class="col-sm-2">
                                                            <?= Html::activeDropDownList($employments, "belong_month_from", $model->getEducationMonthOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Month:')]) ?>
                                                            <?= Html::error($employments, "belong_month_from") ?>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?= Html::activeDropDownList($employments, "belong_year_from", $model->getEducationYearOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Year:')]) ?>
                                                            <?= Html::error($employments, "belong_year_from") ?>
                                                        </div>
                                                        <div class="col-sm-1" style="text-align:center">-</div>
                                                        <div class="col-sm-2">
                                                            <?= Html::activeDropDownList($employments, "belong_month_to", $model->getEducationMonthOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Month:')]) ?>
                                                            <?= Html::error($employments, "belong_month_to") ?>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?= Html::activeDropDownList($employments, "belong_year_to", $model->getEducationYearOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Year:')]) ?>
                                                            <?= Html::error($employments, "belong_year_to") ?>
                                                        </div>
                                                    </div>

                                                    <?= $form->field($employments, "description")->textarea(['style' => 'height:100px']); ?>
                                                </div>
                                            <?php endif; ?>
                                            </div>

                                            <?php if (!$model->isNewRecord) : ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a class="pull-right" href="<?= Url::to(['resume-employment-form', 'id' => $model->_id]) ?>" onclick="js:addEmploymentInfo($(this)); return false">+ Add Employment Info </a>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </fieldset>

                                        <fieldset>
                                            <legend><?= Yii::t('job', 'Basic Education Overview') ?></legend>
                                            <?= $form->field($model, 'education_name')->textInput(['placeholder' => Yii::t('job', 'School Name')]) ?>
                                            <?= $form->field($model, 'education_degree')->dropDownList($model->getDegreeEarnedOptions(), ['prompt' => Yii::t('job', 'Degree Earned')]) ?>
                                            <?= $form->field($model, 'education_study')->textInput(['placeholder' => Yii::t('job', 'Field of Study')]) ?>

                                            <div class="form-group">
                                                <?= Html::label(Yii::t('job', 'Graduation Date'), null, ['class' => 'control-label col-sm-3']) ?>
                                                <div class="col-sm-3">
                                                    <?= Html::activeDropDownList($model, 'education_month', $model->getEducationMonthOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Month:')]) ?>
                                                    <?= Html::error($model, 'education_month') ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= Html::activeDropDownList($model, 'education_year', $model->getEducationYearOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Year:')]) ?>
                                                    <?= Html::error($model, 'education_year') ?>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <legend><?= Yii::t('job', 'Optional Info.') ?></legend>
                                            <!-- language_ability:getLanguageLevelOptions() -->
<!--                                            UserJobSeekerResume[social_linkedin]-->

                                            <div class="form-group">
                                                <?= Html::label(Yii::t('job', 'Language Ability'), null, ['class' => 'control-label col-sm-3']) ?>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <?= Html::activeDropDownList($model, 'language_ability[0][language]', $model->getLanguageOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Language')]) ?>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <?= Html::activeDropDownList($model, 'language_ability[0][level]', $model->getLanguageLevelOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Level')]) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <?= Html::activeDropDownList($model, 'language_ability[1][language]', $model->getLanguageOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Language')]) ?>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <?= Html::activeDropDownList($model, 'language_ability[1][level]', $model->getLanguageLevelOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Level')]) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <?= Html::activeDropDownList($model, 'language_ability[2][language]', $model->getLanguageOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Language')]) ?>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <?= Html::activeDropDownList($model, 'language_ability[2][level]', $model->getLanguageLevelOptions(), ['class' => 'form-control', 'prompt' => Yii::t('job', 'Level')]) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <?= Html::submitButton(Yii::t('common', 'Update'), ['class' => 'button button-primary']) ?>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->
