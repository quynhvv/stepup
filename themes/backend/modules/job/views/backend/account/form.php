<?php

use app\components\ActiveForm;

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;

use app\components\SwitchInput;
use app\components\FieldRange;
use kartik\widgets\FileInput;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\job\models\UserJob */
/* @var $form yii\widgets\ActiveForm */

if ($modelUserJob->birthday != null) {
    $modelUserJob->birthday = date('Y-m-d', $modelUserJob->birthday->sec);
}
if ($modelUserJob->vip_from != null) {
    $modelUserJob->vip_from = date('Y-m-d', $modelUserJob->vip_from->sec);
}
if ($modelUserJob->vip_to != null) {
    $modelUserJob->vip_to = date('Y-m-d', $modelUserJob->vip_to->sec);
}

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
                    $tabs = [
                        [
                            'label' => Yii::t('common', 'General information'),
                            'content' =>
                                $form->field($modelUser, 'display_name')->textInput() .
                                $form->field($modelUser, 'email')->textInput() .
                                $form->field($modelUser, 'password')->passwordInput() .
                                $form->field($modelUser, 'phone')->textInput() .
                                $form->field($modelUser, 'status')->widget(SwitchInput::classname(), [
                                    'containerOptions' => [],
                                ]),
                            'active' => true
                        ],
                    ];

                    if ($modelUserJob->role == 'seeker') {
                        $tabs[] = [
                            'label' => Yii::t('common', 'Extra information'),
                            'content' =>
                                $form->field($modelUserJob, 'sex')->radioList($modelUserJob::getSexOptions()) .
                                $form->field($modelUserJob, 'birthday')->widget(DateControl::classname(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'pluginOptions' => [
                                            'startDate' => '01/01/1980', // -35y
                                            'endDate' => '0d',
                                            'autoclose' => true
                                        ]
                                    ]
                                ]) .
                                $form->field($modelUserJob, 'seeker_nationality')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => '---']) .
                                $form->field($modelUserJob, 'seeker_salary')->dropDownList(\app\modules\job\models\JobSalary::getOptions(), ['prompt' => 'In US Dollars']),
                        ];
                    } else {
                        $tabs[] = [
                            'label' => Yii::t('common', 'Extra information'),
                            'content' =>
                                $form->field($modelUserJob, 'recruiter_type')->dropDownList(\app\modules\job\models\UserJob::getAgentTypeOptions()) .
                                $form->field($modelUserJob, 'recruiter_company_name') .
                                $form->field($modelUserJob, 'recruiter_position') .
                                $form->field($modelUserJob, 'recruiter_office_location')->dropDownList(\app\modules\job\models\JobLocation::getOptions(), ['prompt' => '---']) .
                                $form->field($modelUserJob, 'recruiter_city_name') .
                                $form->field($modelUserJob, 'recruiter_website') .
                                $form->field($modelUserJob, 'recruiter_jobs_industry')->listBox(\app\modules\job\models\JobIndustry::getOptions()) .
                                $form->field($modelUserJob, 'recruiter_summary'),
                        ];
                    }

                    $tabs[] = [
                        'label' => Yii::t('common', 'VIP information'),
                        'content' =>
                            $form->field($modelUserJob, 'vip') .
                            $form->field($modelUserJob, 'vip_from')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]) .
                            $form->field($modelUserJob, 'vip_to')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]),
                    ];
                    echo Html::hiddenInput('save_type', 'save');
                    echo yii\bootstrap\Tabs::widget([
                        'items' => $tabs,
                    ]);
                    ActiveForm::end();
                    ?>




                    <?php
                    /*
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

                    
                    

                    
                    ActiveForm::end();
                    */
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
