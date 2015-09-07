<?php
use app\components\ActiveForm;
use kartik\widgets\FileInput;
//use yii\helpers\Html;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8">
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
                                        'hint' => 'col-sm-9',
                                    ],
                                ],
                            ]);
                            ?>

                            <?= $form->field($model, 'first_name')->textInput(['placeholder' => Yii::t('account', 'First Name')]) ?>
                            <?= $form->field($model, 'last_name')->textInput(['placeholder' => Yii::t('account', 'Last Name')]) ?>
                            <?= $form->field($jobModel, 'agent_company_name')->textInput(['placeholder' => Yii::t('account', 'Company Name')]) ?>
                            <?= $form->field($jobModel, 'agent_position')->textInput(['placeholder' => Yii::t('account', 'Position')]) ?>
                            <?= $form->field($jobModel, 'agent_office_location')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => '---']) ?>
                            <?= $form->field($jobModel, 'agent_city_name')->textInput(['placeholder' => Yii::t('account', 'City Name')]) ?>
                            <?= $form->field($jobModel, 'agent_website')->textInput(['placeholder' => Yii::t('account', 'Corporate Site')]) ?>
                            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('account', 'Email')]) ?>
                            <?= $form->field($model, 'phone')->textInput(['placeholder' => Yii::t('account', '(Ex: 65-6666-7777) with country code, please.')]) ?>
                            <?= $form->field($jobModel, 'agent_job_industry')->listBox(\app\modules\job\models\Job::getCategoryOptions(), ['multiple'=> true])->hint(Yii::t('job', 'Please Use CTR to select multiple options. (Select up to 3)')) ?>
                            <?php if ($jobModel->role === 'recruiter'): ?>
                            <?= $form->field($jobModel, 'agent_job_function')->listBox(\app\modules\job\models\JobFunction::getOptions(), ['multiple'=> true])->hint(Yii::t('job', 'Please Use CTR to select multiple options. (Select up to 3)')) ?>
                            <?php endif; ?>
                            <?= $form->field($jobModel, 'agent_summary')->textarea() ?>
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
                            if (!empty($model->image)) {
                                $imageConfig['pluginOptions']['initialPreview'] = [Html::img(\app\helpers\LetHelper::getFileUploaded($model->image), ['class' => 'file-preview-image'])];
                            }
                            echo $form->field($model, 'image')->widget(FileInput::classname(), $imageConfig);
                            ?>

                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <?= Html::submitButton(Yii::t('account', 'Save'), ['class' => 'button button-primary']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->