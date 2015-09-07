<?php
use yii\bootstrap\Html;
use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;

?>
<div class="row m-b-sm">
    <div class="col-lg-12">
        <?php
        $form = ActiveForm::begin([
            'id' => 'chart-form',
            'method' => 'get'
        ]);
        echo $form->field($model, 'datetime_range')->widget(DateRangePicker::className(), [
            'name' => 'UserJobStats[datetime_range]',
            'value' => '1',
            'presetDropdown' => true,
            'hideInput' => true,
            'pluginOptions' => [
                'format' => 'Y-m-d',
                'separator' => '/',
                'opens' => 'center',
            ],
            'convertFormat' => true,
        ]);
        echo Html::button(Yii::t('job', 'Statistics'), [
            'class' => 'btn btn-success',
            'onclick' => '$("#chart-form").submit();',
        ]);
        ActiveForm::end();
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Yii::t('job', 'Chart') ?></h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div id="morris-line-chart"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Yii::t('job', 'Overall statistics') ?></h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div id="overall-statistics">
                    <table class="table table-condensed">
                        <?php foreach ($overall_statistics as $statistics) { ?>
                            <tr>
                                <td><?= $statistics; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Yii::t('job', 'Detailed statistics') ?></h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div id="overall-statistics">
                    <?= $gridview; ?>
                </div>
            </div>
        </div>
    </div>
</div>
