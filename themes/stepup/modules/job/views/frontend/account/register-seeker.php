<?php
use app\components\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use yii\helpers\Html;

Yii::$app->view->title = Yii::t(Yii::$app->controller->module->id, 'Sign up');
Yii::$app->view->params['breadcrumbs'][] = Yii::t(Yii::$app->controller->module->id, 'Seekers');
Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                    <div class="section-title section-title-style-2">
                        <a href="<?= \yii\helpers\Url::to(['/job/account/login', 'role' => $jobModel->role]) ?>">Sign in</a>
                        <h2 class="title">SIGN UP (Free)</h2>
                        <h5 class="subtitle">STEPUP Requires User Membership - Sign Up Now! (Free)</h5>
                    </div>
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

                        <?= $form->field($jobModel, 'role')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('account', 'Email')]) ?>
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('account', 'Your password must be between 6-20 alphanumeric characters')]) ?>
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
                        if (!empty($model->image))
                            $imageConfig['pluginOptions']['initialPreview'] = [Html::img(LetHelper::getFileUploaded($model->image), ['class' => 'file-preview-image'])];

                        echo $form->field($model, 'image')->widget(FileInput::classname(), $imageConfig);
                        ?>
                        <?= $form->field($jobModel, 'sex')->radioList($jobModel::getSexOptions()) ?>
                        <?= $form->field($jobModel, 'birthday')->widget(DateControl::classname(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'startDate' => '01/01/1980', // -35y
                                    'endDate' => '0d',
                                    'autoclose' => true
                                ]
                            ]
                        ]); ?>
                        <?= $form->field($jobModel, 'seeker_nationality')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => '---']) ?>
                        <?= $form->field($jobModel, 'seeker_salary')->dropDownList(\app\modules\job\models\JobSalary::getOptions(), ['prompt' => 'In US Dollars']) ?>

                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <?= Html::submitButton(Yii::t('account', 'Sign up'), ['class' => 'button button-primary']) ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->