<?php

use app\components\DetailView;
use app\helpers\ArrayHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\job\models\UserJob */

//$this->title = $model->_id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('account', 'User Jobs'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <p>
                <?= Html::a(Yii::t(Yii::$app->controller->module->id, 'Update'), ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t(Yii::$app->controller->module->id, 'Delete'), ['delete', 'id' => (string) $model->_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t(Yii::$app->controller->module->id, 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Yii::t(Yii::$app->controller->module->id, 'Infomation') ?></h5>
                </div>
                <div class="ibox-content">

                    <?php
                    $attributes = [
                        '_id',
                        'email',
                        'user.phone',
                    ];
                    $seekerAttributes = [
                        [
                            'attribute' => 'sex',
                            'value' => $model->getSexText()
                        ],
                        [
                            'attribute' => 'birthday',
                            'value' => Yii::$app->formatter->asDate($model->birthday->sec)
                        ],
                        [
                            'attribute' => 'seeker_nationality',
                            'value' => $model->seekerNationality->title
                        ],
                        [
                            'attribute' => 'seeker_salary',
                            'value' => $model->seekerSalary->title
                        ],
                    ];
                    $recruiterAttributes = [
                        [
                            'attribute' => 'recruiter_type',
                            'value' => $model->getRecruiterTypeText()
                        ],
                        'recruiter_company_name',
                        'recruiter_position',
                        [
                            'attribute' => 'recruiter_office_location',
                            'value' => $model->recruiterOfficeLocation->title
                        ],
                        'recruiter_city_name',
                        'recruiter_website',
                        [
                            'attribute' => 'recruiter_jobs_industry',
                            'value' => $model->recruiterIndustry->title
                        ],
                        'recruiter_summary',
                    ];
                    $vipAttributes = [
                        'vip',
                        [
                            'attribute' => 'vip_from',
                            'value' => ($model->vip_from != null) ? Yii::$app->formatter->asDate($model->vip_from->sec) : ''
                        ],
                        [
                            'attribute' => 'vip_to',
                            'value' => ($model->vip_to != null) ? Yii::$app->formatter->asDate($model->vip_to->sec) : ''
                        ],
                    ];

                    if ($model->role == 'seeker') {
                        $attributes = array_merge($attributes, $seekerAttributes, $vipAttributes);
                    } else {
                        $attributes = array_merge($attributes, $recruiterAttributes, $vipAttributes);
                    }

                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => $attributes,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
