<?php

use yii\bootstrap\Html;

use app\components\GridView;
use app\helpers\LetHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <div class="btn-group">
                <?php
                if (Yii::$app->user->can(Yii::$app->controller->module->id . '/jobtest/create')) {
                    echo Html::a(Yii::t('common', 'Create'), ['jobtest/create'], [
                        'class' => 'btn btn-success',
                        'onclick' => '$("#formDefault").submit();',
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo GridView::widget([
                'panel' => [
                    'heading' => Yii::t(Yii::$app->controller->module->id, 'Job'),
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
                    'title',
                    [
                        'attribute' => 'status',
                        'class' => '\app\components\BooleanColumn',
                    ],
					// 'annual_salary_from',
					// 'annual_salary_to',
					// 'category_ids',
					// 'city_name',
					// 'code',
					// 'company_description',
					// 'company_name',
					// 'country_id',
					// 'created_by',
					// 'created_time',
					// 'description',
					// 'email_cc',
					// 'function2',
					// 'function3',
					// 'functions',
					// 'hits',
					// 'industry',
					// 'industry2',
					// 'is_filtering',
					// 'seo_desc',
					// 'seo_title',
					// 'seo_url',
					// 'updated_time',
					// 'work_type',
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
