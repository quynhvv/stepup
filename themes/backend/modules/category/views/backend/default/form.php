<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use app\components\ActiveForm;
use app\components\SwitchInput;
use app\components\FieldRange;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$buttons = Html::button(Yii::t('common', 'Apply'), [
    'class' => 'btn btn-success',
    'onclick' => '$("input[name=save_type]").val("apply"); $("#formDefault").submit();',
]);
$buttons .= Html::button(Yii::t('common', 'Save'), [
    'class' => 'btn btn-success',
    'onclick' => '$("#formDefault").submit();',
]);

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <div class="btn-group pull-right">
                <?= $buttons; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Yii::t('common', 'Information') ?></h5>
                </div>
                <div class="ibox-content">
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
                    
                    // Image
                    $imageConfig = [
                        'options' => ['accept' => 'uploads/*'],
                        'pluginOptions' => [
                            'previewFileType' => 'image',
                            'showCaption' => FALSE,
                            'showRemove' => FALSE,
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
                    // END Image

                    $tabs = [
                        [
                            'label' => Yii::t('common', 'General information'),
                            'content' =>
                                $form->field($model, 'name')->textInput() .
                                $form->field($model, 'class')->textInput() .
                                $form->field($model, 'skin')->textInput() .
                                $form->field($model, 'image')->widget(FileInput::classname(), $imageConfig) .
                                $form->field($model, 'description')->textarea () .
                                $form->field($model, 'promotion')->widget(SwitchInput::className([
                                    'type' => SwitchInput::RADIO,
                                ])) .
                                $form->field($model, 'status')->widget(SwitchInput::className([
                                    'type' => SwitchInput::RADIO,
                                ])),
                            'active' => true
                        ],
                        [
                            'label' => 'Seo',
                            'content' =>
                            $form->field($model, 'seo_url')->textInput() .
                            $form->field($model, 'seo_title')->textInput() .
                            $form->field($model, 'seo_desc')->textInput(),
                            $form->field($model, 'seo_keyword')->textInput(),
                        ],
                    ];
                    echo Html::hiddenInput('save_type', 'save');
                    echo yii\bootstrap\Tabs::widget([
                        'items' => $tabs,
                    ]);
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


