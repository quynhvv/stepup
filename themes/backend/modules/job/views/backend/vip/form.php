<?php

use app\components\ActiveForm;
use app\components\SwitchInput;
use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\job\models\UserVipPackage */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
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

                    
                    echo Html::hiddenInput('save_type', 'save');

                    
                    
					echo $form->field($model, 'title');
					echo 
                                    $form->field($model, 'status')->widget(SwitchInput::className([
                                        'type' => SwitchInput::RADIO
                                    ]));
					echo $form->field($model, 'days');
					echo $form->field($model, 'price');
					echo $form->field($model, 'sort');
                    
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
