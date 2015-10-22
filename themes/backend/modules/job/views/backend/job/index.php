<?php
use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\helpers\ArrayHelper;
use app\components\GridView;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <div class="btn-group">
                <?php
//                if (Yii::$app->user->can(Yii::$app->controller->module->id . '/default/create')) {
//                    echo Html::a(Yii::t('common', 'Create'), ['default/create'], [
//                        'class' => 'btn btn-success',
//                        'onclick' => '$("#formDefault").submit();',
//                    ]);
//                }
//                if (Yii::$app->user->can(Yii::$app->controller->module->id . ':delete')) {
//                    echo Html::button(Yii::t('yii', 'Delete'), [
//                        'class' => 'btn btn-danger',
//                        'onclick' => "deleteSelectedRows('" . Url::to(['/common/crud/deleteselectedrows']) . "', '" . Job::tableName() . "')",
//                    ]);
//                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo GridView::widget([
                'panel' => [
                    'heading' => Yii::t(Yii::$app->controller->module->id, 'Jobs List'),
                    'tableOptions' => [
                        'id' => 'listDefault',
                    ],
                ],
                'pjax' => TRUE,
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'toolbar' =>  [
                    ['content'=>
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
                    ],
                    '{export}',
                    '{toggleData}'
                ],
                'columns' => [
                    ['class' => 'kartik\grid\CheckboxColumn'],
                    //'_id',
                    [
                        'attribute' => 'code',
                    ],
                    [
                        'attribute' => 'title',
                        'label' => Yii::t('job', 'Position'),
                    ],
                    [
                        'attribute' => 'company_name',
                        'label' => Yii::t('job', 'Company'),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model, $key, $index, $widget){
                            return ArrayHelper::getValue(\app\modules\job\models\Job::getStatusOptions(), ArrayHelper::getValue($model, 'status'));
                        },
                        'contentOptions'=>['style'=>'min-width: 150px;'],
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \app\modules\job\models\Job::getStatusOptions(true),
                    ],
                    [
                        'attribute' => 'created_time',
                        'label' => Yii::t('job', 'Posted'),
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'format' => 'raw',
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
                            return date('Y-m-d h:i:s', $model->created_time->sec);
                        },
                    ],
                    [
                        'attribute' => 'updated_time',
                        'label' => Yii::t('job', 'Updated'),
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'format' => 'raw',
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
                            return date('Y-m-d h:i:s', $model->updated_time->sec);
                        },
                    ],
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        //'class' => '\app\components\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
                'responsive' => true,
                'hover' => true,
            ]);
            ?>
        </div>
    </div>
</div>
