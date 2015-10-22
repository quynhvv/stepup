<?php

use app\components\ActiveForm;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
?>

<?php
$form = ActiveForm::begin([
            'method' => 'GET',
            'action' => ['search-seeker'],
            'options' => [
                'id' => 'frm-search-seeker',
                'name' => 'frm-search-seeker'
            ]
        ])
?>
<?= $form->field($searchModel, 'keyword')->textInput(['class' => 'form-control', 'placeholder' => 'keyword search']) ?>

<?= $form->field($searchModel, 'search_mode')->radioList($searchModel::getSearchModeOptions()) ?>

<?= $form->field($searchModel, 'location')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['class' => 'form-control', 'prompt' => '---']) ?>
<?= $form->field($searchModel, 'functions')->dropDownList(\app\modules\job\models\JobFunction::getOptions(), ['class' => 'form-control', 'prompt' => '---']) ?>
<?= $form->field($searchModel, 'industries')->dropDownList(\app\modules\job\models\JobIndustry::getOptions(), ['class' => 'form-control', 'prompt' => '---']) ?>
<br>
<input class="button button-primary" type="submit" name="agent-search-seeker" />

<?php ActiveForm::end(); ?>