<?php
use app\components\ActiveForm;
use app\helpers\LetHelper;
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
<!--                                <li role="presentation">
                                    <a role="button" href="#">3: Job preferences</a>
                                </li>-->
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
                                                    <?= $form->field($model, 'phone_country', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getCountryCodeOptions(), ['prompt' => Yii::t('job', 'Country Code')])->label(false) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'phone_number', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->textInput(['placeholder' => Yii::t('job', '999-999-999')])->label(false) ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <?= Html::label(Yii::t('job', 'Social Media'), null, ['class' => 'control-label col-sm-3']) ?>
                                                <div class="col-sm-9">
                                                    <?= $form->field($model, 'social_linkedin', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->textInput(['placeholder' => Yii::t('job', 'Please input your LinkedIn Profile URL')])->label(false) ?>
                                                    
                                                    <?= $form->field($model, 'social_facebook', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->textInput(['placeholder' => Yii::t('job', 'Please input your Facebook Profile URL')])->label(false) ?>
                                                    
                                                    <?= $form->field($model, 'social_twitter', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->textInput(['placeholder' => Yii::t('job', 'Please input your Twitter Profile URL')])->label(false) ?>
                                                </div>
                                            </div>

                                            <?php
                                            $imageConfig = [
                                                'options' => ['accept' => 'uploads/*'],
                                                'pluginOptions' => [
                                                    'previewFileType' => 'image',
                                                    'showCaption' => FALSE,
                                                    'showRemove' => TRUE,
                                                    'showUpload' => FALSE,
                                                    'browseClass' => 'btn btn-primary btn-block',
                                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                                    'browseLabel' => 'Select Photo',
                                                    'removeClass' => 'btn btn-danger',
                                                    'removeLabel' => "Delete",
                                                    'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>',
                                                    'allowedFileExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
                                                ],
                                            ];
                                            if (!empty($modelUser->image))
                                                $imageConfig['pluginOptions']['initialPreview'] = [Html::img(LetHelper::getFileUploaded($modelUser->image), ['class' => 'file-preview-image'])];

                                            echo $form->field($modelUser, 'image')->widget(\kartik\widgets\FileInput::classname(), $imageConfig);
                                            ?>
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
                                                                <?= $form->field($employment, "[$index]belong_month_from", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationMonthOptions(), ['prompt' => Yii::t('job', 'Month:')])->label(false) ?>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <?= $form->field($employment, "[$index]belong_year_from", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationYearOptions(), ['prompt' => Yii::t('job', 'Year:')])->label(false) ?>
                                                            </div>
                                                            <div class="col-sm-1" style="text-align:center">-</div>
                                                            <div class="col-sm-2">
                                                                <?= $form->field($employment, "[$index]belong_month_to", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationMonthOptions(), ['prompt' => Yii::t('job', 'Month:')])->label(false) ?>                                                                
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <?= $form->field($employment, "[$index]belong_year_to", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationYearOptions(), ['prompt' => Yii::t('job', 'Year:')])->label(false) ?>
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
                                                            <?= $form->field($employments, 'belong_month_from', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationMonthOptions(), ['prompt' => Yii::t('job', 'Month:')])->label(false) ?>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?= $form->field($employments, 'belong_year_from', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationYearOptions(), ['prompt' => Yii::t('job', 'Year:')])->label(false) ?>
                                                        </div>
                                                        <div class="col-sm-1" style="text-align:center">-</div>
                                                        <div class="col-sm-2">
                                                            <?= $form->field($employments, 'belong_month_to', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationMonthOptions(), ['prompt' => Yii::t('job', 'Month:')])->label(false) ?>                                                            
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?= $form->field($employments, 'belong_year_to', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationYearOptions(), ['prompt' => Yii::t('job', 'Year:')])->label(false) ?>
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
                                                    <?= $form->field($model, 'education_month', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationMonthOptions(), ['prompt' => Yii::t('job', 'Month:')])->label(false) ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'education_year', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationYearOptions(), ['prompt' => Yii::t('job', 'Year:')])->label(false) ?>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <legend><?= Yii::t('job', 'Optional Info.') ?></legend>
                                            <div class="form-group">
                                                <?= Html::label(Yii::t('job', 'Language Ability'), null, ['class' => 'control-label col-sm-3']) ?>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <?= $form->field($model, 'language_ability[0][language]', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getLanguageOptions(), ['prompt' => Yii::t('job', 'Language')])->label(false) ?>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <?= $form->field($model, 'language_ability[0][level]', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getLanguageLevelOptions(), ['prompt' => Yii::t('job', 'Level')])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <?= $form->field($model, 'language_ability[1][language]', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getLanguageOptions(), ['prompt' => Yii::t('job', 'Language')])->label(false) ?>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <?= $form->field($model, 'language_ability[1][level]', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getLanguageLevelOptions(), ['prompt' => Yii::t('job', 'Level')])->label(false) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <?= $form->field($model, 'language_ability[2][language]', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getLanguageOptions(), ['prompt' => Yii::t('job', 'Language')])->label(false) ?>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <?= $form->field($model, 'language_ability[2][level]', ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getLanguageLevelOptions(), ['prompt' => Yii::t('job', 'Level')])->label(false) ?>
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
