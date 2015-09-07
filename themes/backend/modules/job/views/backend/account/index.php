<?php

use yii\bootstrap\Html;

use app\components\GridView;
use app\helpers\LetHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo GridView::widget([
                'panel' => [
                    'heading' => Yii::t(Yii::$app->controller->module->id, 'UserJob'),
                    'tableOptions' => [
                        'id' => 'listDefault',
                    ],
                ],
                'pjax' => TRUE,
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\CheckboxColumn'],
                    '_id',
                    'email',
                    [
                        'attribute' => 'role',
                        'filter' => \app\modules\job\models\UserJob::getRoleOptions()
                    ],
					// 'birthday',
					// 'recruiter_city_name',
					// 'recruiter_company_name',
					// 'recruiter_jobs_industry',
					// 'recruiter_office_location',
					// 'recruiter_position',
					// 'recruiter_summary',
					// 'recruiter_type',
					// 'recruiter_website',
					// 'seeker_nationality',
					// 'seeker_salary',
					// 'sex',
					// 'vip',
					// 'vip_from',
					// 'vip_to',
                    [
                        'class' => '\kartik\grid\ActionColumn',
                    ],
                ],
                'responsive' => true,
                'hover' => true,
            ]);
            ?>
        </div>
    </div>
</div>
