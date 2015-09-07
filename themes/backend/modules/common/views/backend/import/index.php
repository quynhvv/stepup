<?php
use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\GridView;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <div class="btn-group">
                <?php
                if (Yii::$app->user->can(Yii::$app->controller->module->id . '/import/create')) {
                    echo Html::a(Yii::t('common', 'Import'), ['import/create'], [
                        'class' => 'btn btn-success',
                        'onclick' => '$("#formDefault").submit();',
                    ]);
                }
//                if (Yii::$app->user->can(Yii::$app->controller->module->id . ':delete')) {
//                    echo Html::button(Yii::t('yii', 'Delete'), [
//                        'class' => 'btn btn-danger',
//                        'onclick' => "deleteSelectedRows('" . Url::to(['/common/crud/deleteselectedrows']) . "', '" . MongoProduct::tableName() . "')",
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
                    'heading' => Yii::t(Yii::$app->controller->module->id, 'Import'),
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
                    'file_path',
                    'model_namespace',
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
