<?php
use app\components\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <div class="btn-group pull-right">
                <?= Html::button(Yii::t('common', 'Save'), [
                    'class' => 'btn btn-primary',
                    'onclick' => '$("#formDefault").submit();',
                ]); ?>
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
                        echo $form->field($model, 'status')->dropDownList(\app\modules\job\models\Job::getStatusOptions(), ['prompt' => Yii::t('job', '--- Select a Status ---')]);
                        ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
