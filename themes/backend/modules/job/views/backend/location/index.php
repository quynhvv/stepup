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
                if (Yii::$app->user->can(Yii::$app->controller->module->id . '/location/create')) {
                    echo Html::a(Yii::t('common', 'Create'), ['location/create'], [
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
                    'heading' => Yii::t(Yii::$app->controller->module->id, 'JobLocation'),
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
                        'attribute' => 'create_time',
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'format' => 'raw',
                        'width' => '270px',
                        'filterWidgetOptions' => [
                            'pluginOptions' => [
                                'format' => 'Y-m-d',
                                'separator' => ' to ',
                                'opens' => 'left'
                            ],
                            'presetDropdown' => true,
                            'hideInput' => true,
                            'convertFormat' => true,
                        ],
                        'value' => function ($model, $key, $index, $widget) {
                            return Yii::$app->formatter->asDatetime($model->create_time->sec);
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'class' => '\app\components\AjaxBooleanColumn',
                    ],
					// 'creator',
					// 'editor',
					// 'sort',
					// 'update_time',
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
