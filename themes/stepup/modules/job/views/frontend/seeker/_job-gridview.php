<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
use app\components\GridView;
?>

<?php
echo GridView::widget([
    'panel' => [
        //'heading' => Yii::t(Yii::$app->controller->module->id, 'List Jobs').': ',
        'tableOptions' => [
            'id' => 'listJobs',
        ],
    ],
    'pjax' => true,
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'toolbar' => [
        [
            'content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')])
        ],
    ],
    'columns' => [
        'title',
        [
            'attribute' => 'annual_salary_from',
            'value' => function($model, $key, $index, $widget) {
                return Html::encode(ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_from')). ' to ' . ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_to')));
            },
        ],
        [
            'attribute' => 'company_name',
            'value' => function($model, $key, $index, $widget) {
                return Html::encode($model->company_name) ;
            },
        ],
        [
            'attribute' => 'updated_time',
            'value' => function($model, $key, $index, $widget) {
                return Yii::$app->formatter->asDate($model->updated_time->sec);
            },
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view}',
            'buttons'=>[
                'view' => function ($url, $model) {
                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['job-detail', 'id' => $model->_id], [
                          'data-pjax' => '0',
                          'title' => Yii::t('yii', 'View'),
                  ]);                                
                }
            ]  
        ]
    ],
    'responsive' => true,
    'hover' => true,
]);
?>