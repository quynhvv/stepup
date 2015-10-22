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

<?php
$searchModel = new app\modules\job\models\UserJobSeekerResume();
$searchModel->scenario = 'search';
$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), 20);
?>
<?= $form->field($searchModel, 'keyword')->textInput(['class' => 'form-control', 'placeholder' => 'keyword search'])->label(false) ?>

<?= $form->field($searchModel, 'search_mode')->radioList($searchModel::getSearchModeOptions())->label(false) ?>

<?= $form->field($searchModel, 'location')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['class' => 'form-control', 'prompt' => '---'])->label(false) ?>
<?= $form->field($searchModel, 'functions')->dropDownList(\app\modules\job\models\JobFunction::getOptions(), ['class' => 'form-control', 'prompt' => '---'])->label(false) ?>
<?= $form->field($searchModel, 'industries')->dropDownList(\app\modules\job\models\JobIndustry::getOptions(), ['class' => 'form-control', 'prompt' => '---'])->label(false) ?>
<br>
<input class="button button-primary" type="submit" name="agent-home-search" />

<?php ActiveForm::end(); ?>