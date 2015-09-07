<?php

use yii\bootstrap\Html;

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
                    <?php echo $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>


