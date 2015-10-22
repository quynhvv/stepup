<?php
use app\components\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\ArrayHelper;
use app\components\GridView;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="row jobs-posted">
                <?php
                //Make custom heading
                $heading = Yii::t(Yii::$app->controller->module->id, 'Manage Jobs').': ';
                
                echo GridView::widget([
                    'panel' => [
                        'heading' => $heading,
                        'tableOptions' => [
                            'id' => 'listDefault',
                        ],
                    ],
                    'pjax' => true,
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'toolbar' =>  [
                        ['content'=>
                            Html::a('<i class="glyphicon glyphicon-plus"></i>', ['post-job'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>Yii::t('job', 'Post New Job')]) .' '.
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
                        ],
                        //'{export}',
                        //'{toggleData}'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
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
                            'buttons'=>[
                                'view' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view-job', 'id' => $model->_id], [
                                          'data-pjax' => '0',
                                          'title' => Yii::t('yii', 'View'),
                                  ]);                                
                                },
                                'update' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-job', 'id' => $model->_id], [
                                          'data-pjax' => '0',
                                          'title' => Yii::t('yii', 'Update'),
                                  ]);                                
                                },
                               'delete' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-job', 'id' => $model->_id], [
                                          'data-pjax' => '0',
                                          'title' => Yii::t('yii', 'Delete'),
                                  ]);                                
                                }
                            ]  
                        ],
                    ],
                    'responsive' => true,
                    'hover' => true,
                ]);
                ?>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->