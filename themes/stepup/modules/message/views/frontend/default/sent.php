<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\StringHelper;

use app\components\GridView;
//use yii\grid\GridView;
use app\helpers\LetHelper;


use app\modules\message\models\Message;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-2cols-left">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-sm-push-3 col-main section-gap">
                            <div class="tab-content">
                                <div role="tabpanel">
                                    <h3>Message list filtering by: <?= Yii::t('message', 'Sent') ?></h3>
                                    <div class="table-responsive">
                                        <?php
                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $modelSearch,
                                            'layout' => "{items}\n{pager}",
                                            'pjax' => true,
                                            'hover' => true,
                                            'responsive' => true,
                                            'columns' => [
                                                ['class' => 'kartik\grid\CheckboxColumn'],
//                                                [
//                                                    'attribute' => 'created_by',
//                                                    'headerOptions' => ['style' => 'width:180px'],
//                                                    'value' => function ($data) {
//                                                        return $data->user->email;
//                                                        //return ($data->user->display_name) ? $data->user->display_name : $data->user->email;
//                                                    }
//                                                ],
                                                [
                                                    'attribute' => 'subject',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        $messageSubject = (empty($model->message_id)) ? Html::encode($model->subject) : '[RE] ' . $model->message->subject;
                                                        $messageId = (empty($model->message_id)) ? $model->primaryKey : $model->message->primaryKey;
                                                        return Html::a($messageSubject, ['view', 'id' => $messageId], ['data-pjax' => 0]);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'content',
                                                    'format' => 'raw',
                                                    'value' => function ($data) {
                                                        return StringHelper::truncateWords($data->content, 20);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'created_at',
                                                    'format' => 'raw',
                                                    'filter' => false,
                                                    'headerOptions' => ['style' => 'width:180px'],
                                                    'value' => function ($data) {
                                                        return Yii::$app->formatter->asDatetime($data->created_at->sec);
                                                    }
                                                ],
//                                                [
//                                                    'class' => '\yii\grid\ActionColumn',
//                                                    'template' => '{view}',
//                                                    'contentOptions' => ['style' => 'width:110px; text-align:center'],
//                                                    'buttons' => [
//                                                        'view' => function ($url, $model, $key) {
//                                                            return Html::a(Yii::t('messsage', 'View details'), Url::to(['view', 'id' => ((empty($model->message_id) ? $model->primaryKey : $model->message->primaryKey))]), [
//                                                                'title' => Yii::t('yii', 'Update'),
//                                                                'data-pjax' => '0',
//                                                            ]);
//                                                        },
//                                                    ]
//                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sm-pull-9 col-sidebar">
                            <?= $this->render('_sidebar'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->
