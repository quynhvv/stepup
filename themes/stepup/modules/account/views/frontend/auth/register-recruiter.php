<?php
use app\components\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;


Yii::$app->view->title = Yii::t(Yii::$app->controller->module->id, 'Recruiter Registration');
Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-title section-title-style-1">
                <?= app\modules\account\widgets\frontend\Login::widget(); ?>
                <h2 class="title">Recruiter Registration Form (it only takes a minute)</h2>
                <h5 class="subtitle">
                    This page is for Recruiters only.<br>
                    For jobseekers wishing to login. <a href="<?= \yii\helpers\Url::to(['/account/auth/loginjob']) ?>" title="Login">Login</a>
                </h5>
            </div>

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
                                'hint' => '',
                            ],
                        ],
                    ]);
                    ?>

                        <?php $jobModel->recruiter_type = 1 ?>
                        <?= $form->field($jobModel, 'recruiter_type')->inline(true)->radioList([
                            '1' => Yii::t('account', 'Recruiter'),
                            '2' => Yii::t('account', 'Hiring Manager '),
                        ]) ?>
                        <?= $form->field($model, 'first_name')->textInput() ?>
                        <?= $form->field($model, 'last_name')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_company_name')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_position')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_office_location')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => '---']) ?>
                        <?= $form->field($jobModel, 'recruiter_city_name')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_website')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'phone')->passwordInput() ?>
                        <?= $form->field($jobModel, 'recruiter_jobs_industry')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_summary')->textarea() ?>
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
                            $imageConfig['pluginOptions']['initialPreview'] = [Html::img(LetHelper::getFileUploaded($model->image), ['class' => 'file-preview-image'])];
                        }
                        echo $form->field($model, 'image')->widget(FileInput::classname(), $imageConfig);
                        ?>

                        <div class="checkbox policy_check">
                            <label>
                                <input type="checkbox" name="accept_policy_checkbox">
                                I have read, understand, and I accept the <a href="#" target="_blank">terms of use</a> and <a href="#" target="_blank">privacy policy</a>.
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="button button-primary">Sign up</button>
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