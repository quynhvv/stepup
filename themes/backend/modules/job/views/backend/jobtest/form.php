<?php

use app\components\ActiveForm;
use app\components\SwitchInput;
use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\job\models\Job */
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
					echo $form->field($model, 'annual_salary_from');
					echo $form->field($model, 'annual_salary_to');
					echo $form->field($model, 'category_ids');
					echo $form->field($model, 'city_name');
					echo $form->field($model, 'code');
					echo $form->field($model, 'company_description');
					echo $form->field($model, 'company_name');
					echo $form->field($model, 'country_id');
					echo $form->field($model, 'created_by');
					echo $form->field($model, 'created_time');
					echo $form->field($model, 'description');
					echo $form->field($model, 'email_cc');
					echo $form->field($model, 'function2');
					echo $form->field($model, 'function3');
					echo $form->field($model, 'functions');
					echo $form->field($model, 'hits');
					echo $form->field($model, 'industry');
					echo $form->field($model, 'industry2');
					echo $form->field($model, 'is_filtering');
					echo $form->field($model, 'updated_time');
					echo $form->field($model, 'work_type');
					echo $form->field($model, 'seo_url');
					echo $form->field($model, 'seo_title');
					echo $form->field($model, 'seo_desc');
                    
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
