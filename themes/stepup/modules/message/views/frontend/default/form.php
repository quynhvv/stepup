<?php

use yii\bootstrap\ActiveForm;
use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\modules\message\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-2cols-left">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-sm-push-3 col-main section-gap">
                            <div class="reg-area">
                                <h1 class="text-center h2">Create New Message</h1>

                                <?php
                                $form = ActiveForm::begin([
                                    'id' => 'formDefault',
                                    'layout' => 'horizontal',
                                    'options' => ['enctype' => 'multipart/form-data'],
                                    'fieldConfig' => [
                                        'horizontalCssClasses' => [
                                            'label' => 'col-sm-2',
                                            'wrapper' => 'col-sm-10',
                                            'error' => 'help-block m-b-none',
                                            'hint' => '',
                                        ],
                                    ],
                                ]);
                                ?>
                                <?= $form->field($model, 'subject'); ?>
                                <?= $form->field($model, 'users')->widget(\kartik\select2\Select2::classname(), [
                                    'data' => $model->getUserOptions(),
                                    'options' => ['placeholder' => Yii::t('message', 'Select Users'), 'multiple' => 'multiple'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 2,
                                        'ajax' => [
                                            'url' => Url::to(['user-list']),
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                        ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(users) { return users.text; }'),
                                        'templateSelection' => new JsExpression('function (users) { return users.text; }'),
                                    ],
                                ]) ?>
                                <?= $form->field($model, 'category_id')->dropDownList(\app\modules\message\models\Message::getCategoryOptions()) ?>
                                <?= $form->field($model, 'content')->widget(letyii\tinymce\Tinymce::className(), [
                                    'options' => [
                                        'style' => 'height: 400px;',
                                    ],
                                    'configs' => [
                                        'setup' => new \yii\web\JsExpression('function(editor) { editor.on("change", function() { tinymce.triggerSave(); }); }'),
                                        'plugins' => 'moxiemanager advlist autolink lists link image charmap print preview hr anchor pagebreak '
                                            . 'searchreplace wordcount visualblocks visualchars code fullscreen '
                                            . 'insertdatetime media nonbreaking save table contextmenu directionality '
                                            . 'emoticons template paste textcolor colorpicker textpattern',
                                        'toolbar1' => 'insertfile undo redo | styleselect | fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                                        'toolbar2' => 'print preview media | forecolor backcolor emoticons',
                                        'moxiemanager_image_settings' => [
                                            'moxiemanager_title' => 'Images',
                                            'moxiemanager_extensions' => 'jpg,png,gif',
                                            'moxiemanager_rootpath' => '/uploads/files',
                                            'moxiemanager_view' => 'thumbs',
                                        ],
                                        'external_plugins' => [
                                            'moxiemanager' => Url::base() . '/plugins/moxiemanager/plugin.min.js'
                                        ],
                                    ],
                                ]); ?>

                                <div class="text-center">
                                    <button type="submit" class="button button-primary button-lg">Send</button>
                                </div>

                                <?php ActiveForm::end(); ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sm-pull-9 col-sidebar">
                            <?= $this->render('_sidebar'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->
