<?php
use app\components\ActiveForm;
use yii\helpers\Html;
?>

<?php
$form = ActiveForm::begin([
    'id' => 'formDefault',
    'method' => 'post',
    'layout' => 'horizontal',
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

<p><a target="_blank" href="#">Job posting requirements</a></p>

<?= $form->field($model, 'code')->textInput(['placeholder' => Yii::t('job', 'Enter a name for your reference only')]) ?>
<?= $form->field($model, 'title')->textInput(['placeholder' => Yii::t('job', 'What type of position is this?')]) ?>
<?= $form->field($model, 'category_ids')->listBox(\app\modules\job\models\Job::getCategoryOptions(), ['multiple' => true]) ?>
<?= $form->field($model, 'country_id')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => Yii::t('job', '--- Select a location ---')]) ?>
<?= $form->field($model, 'city_name')->textInput() ?>

<div class="form-group field-job-annual_salary_from">
    <label for="job-annual_salary_from" class="control-label col-sm-3"><?= '<em class="required">*</em> '.Yii::t('job', 'Annual Salary') ?></label>
    <div class="col-sm-9">
        <div class="row">
            <?php $annualSalary = \app\modules\job\models\JobSalary::getOptions(); ?>
            <div class="col-xs-6">
                <?php echo Html::activeDropDownList($model, 'annual_salary_from', $annualSalary, ['prompt' => Yii::t('job', '--- From ---')]); ?>
            </div>
            <div class="col-xs-6">
                <?php echo Html::activeDropDownList($model, 'annual_salary_to', $annualSalary, ['prompt' => Yii::t('job', '--- To ---')]); ?>
            </div>
        </div>
    </div>
</div>

<?php $jobFunctions = \app\modules\job\models\JobFunction::getOptions() ?>
<?= $form->field($model, 'functions')->dropDownList($jobFunctions, ['prompt' => Yii::t('job', '--- Select at least one ---')]) ?>
<div class="form-group">
    <label class="control-label col-sm-3"></label>
    <div class="col-sm-9">
        <?php echo Html::activeDropDownList($model, 'function2', $jobFunctions, ['prompt' => Yii::t('job', '---')]); ?>
        <?php echo Html::activeDropDownList($model, 'function3', $jobFunctions, ['prompt' => Yii::t('job', '---')]); ?>
    </div>
</div>

<?= $form->field($model, 'work_type')->dropDownList(\app\modules\job\models\JobWorkType::getOptions(), ['prompt' => Yii::t('job', '---')]) ?>

<?php $industry = \app\modules\job\models\JobIndustry::getOptions(); ?>
<?= $form->field($model, 'industry')->dropDownList($industry, ['prompt' => Yii::t('job', '--- Select at least one ---')]) ?>
<div class="form-group">
    <label class="control-label col-sm-3"></label>
    <div class="col-sm-9">
        <?php echo Html::activeDropDownList($model, 'industry2', $industry, ['prompt' => Yii::t('job', '---')]); ?>
    </div>
</div>

<?= $form->field($model, 'company_name')->textArea(['rows' => '3', 'class' => 'form-control css-auto-height', 'placeholder' => Yii::t('job', 'Ex: A fortune 500 company, Leading IT & Software Development Company')]) ?>
<?= $form->field($model, 'company_description')->textArea(['rows' => '3', 'class' => 'form-control css-auto-height', 'placeholder' => Yii::t('job', 'Ex: A leading IT & software development company in the Asia Pacific region with over 30 branches in Asia is now expanding and looking for dedicated individuals to join their prestigious company.')]) ?>
<?= $form->field($model, 'description')->textArea(['rows' => '3', 'class' => 'form-control css-auto-height', 'placeholder' => Yii::t('job', 'Provide a description of the job responsibilities and candidate requirements for the role.')]) ?>

<div class="form-group">
    <div class="col-sm-12">
        <button type="submit" class="button button-primary"><?= Yii::t('app', 'Save') ?></button>
    </div>
</div>
<?php ActiveForm::end(); ?>