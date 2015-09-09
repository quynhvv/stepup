<?php
use app\components\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!--
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
-->

<div class="employment-history">
    <div class="row">
        <div class="col-sm-12">
            <strong class="pull-left"><?= Yii::t('job', 'Employment Info') ?></strong>
            <a class="pull-right" href="<?= Url::to(['employment-remove', 'id' => $employment->_id]) ?>" onclick="js:delEmploymentInfo($(this)); return false"><?= Yii::t('job', '- Delete Employment Info') ?></a>
        </div>
    </div>

    <?= $form->field($employment, "[$index]_id")->hiddenInput(['class' => "employment-history-id"])->label(false); ?>
    <?= $form->field($employment, "[$index]company_name"); ?>
    <?= $form->field($employment, "[$index]position"); ?>

    <div class="form-group">
        <?= Html::label(Yii::t('job', 'Period of Employment'), null, ['class' => 'control-label col-sm-3']) ?>
        <div class="col-sm-2">
            <?= $form->field($employment, "[$index]belong_month_from", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationMonthOptions(), ['prompt' => Yii::t('job', 'Month:')])->label(false) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($employment, "[$index]belong_year_from", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationYearOptions(), ['prompt' => Yii::t('job', 'Year:')])->label(false) ?>
        </div>
        <div class="col-sm-1" style="text-align:center">-</div>
        <div class="col-sm-2">
            <?= $form->field($employment, "[$index]belong_month_to", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationMonthOptions(), ['prompt' => Yii::t('job', 'Month:')])->label(false) ?>                                                                
        </div>
        <div class="col-sm-2">
            <?= $form->field($employment, "[$index]belong_year_to", ['template' => '{label}<div class="col-sm-12">{input}{error}{hint}</div>'])->dropDownList($model->getEducationYearOptions(), ['prompt' => Yii::t('job', 'Year:')])->label(false) ?>
        </div>
    </div>

    <?= $form->field($employment, "[$index]description")->textarea(['style' => 'height:100px']); ?>
</div>
<!--
</form>
-->
