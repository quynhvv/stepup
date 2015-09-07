<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use app\components\ActiveForm;
use app\components\SwitchInput;
use app\components\FieldRange;
use kartik\widgets\FileInput;
use yii\helpers\Url;
$buttons = Html::button(Yii::t('common', 'Import'), [
            'class' => 'btn btn-warning',
            'onclick' => '$("input[name=save_type]").val("import"); $("#formDefault").submit();',
        ]);
$buttons .= Html::button(Yii::t('common', 'Apply'), [
            'class' => 'btn btn-success',
            'onclick' => '$("input[name=save_type]").val("apply"); $("#formDefault").submit();',
        ]);
$buttons .= Html::button(Yii::t('common', 'Save'), [
            'class' => 'btn btn-success',
            'onclick' => '$("#formDefault").submit();',
        ]);

$fileConfig = [];
if (!empty($model->file_path))
    $fileConfig['pluginOptions']['initialPreview'] = [Html::img(LetHelper::getFileUploaded($model->file_path), ['class' => 'file-preview-image'])];
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
                                        'offset' => ''
                                    ],
                                ],
                    ]);
                    echo $form->field($model, 'map')->widget(app\modules\common\components\FieldMap::className())->label(false);
                    echo Html::hiddenInput('save_type');
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


