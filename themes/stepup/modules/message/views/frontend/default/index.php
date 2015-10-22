<?php

use yii\helpers\Html;
use yii\helpers\Url;

use app\components\GridView;
//use yii\grid\GridView;
use app\helpers\LetHelper;
use app\helpers\StringHelper;

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
                                    <h3>Message list filtering by: <?= ($paramCategory != 0) ? Message::getCategoryText($paramCategory) : Message::getTypeText($paramType); ?></h3>

                                    <form method="GET">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="keyword" class="form-control full-width" placeholder="Enter message subject, email, name etc." value="<?= Yii::$app->request->get('keyword') ?>">
                                                        </td>
                                                        <td class="text-center" style="width:200px">
                                                            <input type="submit" value="Search" class="button button-lg button-primary btn-block">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <?php
                                        echo GridView::widget([
                                            'id' => 'message-grid',
                                            'dataProvider' => $dataProvider,
                                            'layout' => "{items}\n{pager}",
                                            'pjax' => true,
                                            'hover' => true,
                                            'responsive' => true,
                                            'columns' => [
                                                ['class' => 'kartik\grid\CheckboxColumn'],
                                                [
                                                    'attribute' => 'message.subject',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        $subject = ($model->is_read) ? Html::encode($model->message->subject) : Html::tag('strong', Html::encode($model->message->subject));
                                                        return Html::a($subject, ['view', 'id' => $model->message->primaryKey], ['data-pjax' => 0]);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'message.created_by',
                                                    'headerOptions' => ['style' => 'width:180px'],
                                                    'value' => function ($data) {
                                                        return ($data->message->user->display_name) ? $data->message->user->display_name : $data->message->user->email;
                                                    },
                                                ],
                                                [
                                                    'attribute' => 'message.created_at',
                                                    'format' => 'raw',
                                                    'headerOptions' => ['style' => 'width:180px'],
                                                    'value' => function ($data) {
                                                        return Yii::$app->formatter->asDatetime($data->updated_at->sec);
                                                    }
                                                ],
//                                                [
//                                                    'class' => '\yii\grid\ActionColumn',
//                                                    'template' => '{view}',
//                                                    'contentOptions' => ['style' => 'width:110px; text-align:center'],
//                                                    'buttons' => [
//                                                        'view' => function ($url, $model, $key) {
//                                                            return Html::a(Yii::t('messsage', 'View details'), Url::to(['view', 'id' => $model->message->primaryKey]), [
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

                                    <?= Html::a(Yii::t('common', 'Delete'), ['/message/frontend/default/bulk-delete'], ['id' => 'message-bulk-delete', 'class' => 'button']) ?>
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

<?php
Yii::$app->view->registerJs("
    $('#message-bulk-delete').on('click', function(e){
        e.preventDefault();
        url = $(this).attr('href');
        bootbox.confirm('Are you sure you want to delete?', function(result) {
            if (result) {
                var keys = $('#message-grid').yiiGridView('getSelectedRows');
                if (keys.length > 0) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {keys: keys},
                        success: function (data) {
                            if (data.status === 1) {
                                $.pjax.reload({container: '#message-grid-pjax', timeout: false});
                            }
                        }
                    });
                }
            }
        });
    });
");
