<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
use app\components\GridView;
?>

<style type="text/css">
    /*.ibox-title, .kv-panel-before{display: none;}*/
</style>

<?php

echo GridView::widget([
    'panel' => [
        //'heading' => Yii::t(Yii::$app->controller->module->id, 'List Candidates').': ',
        'tableOptions' => [
            'id' => 'listCandidate',
        ],
    ],
    'pjax' => true,
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'toolbar' => [
        ['content' =>
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')])
        ],
    //'{export}',
    //'{toggleData}'
    ],
    'columns' => [
        [
            'attribute' => 'candidate_id',
            'format' => 'raw',
            'value' => function($model, $key, $index, $widget) {
                if (\app\modules\job\models\UserFavourite::isFavourite($model->_id, 'seeker', Yii::$app->user->id)){
                    $class = "favourites";
                    $title = Yii::t('job', 'Remove from favourites list?');
                }
                else {
                    $class = "un-favourites";
                    $title = Yii::t('job', 'Add to favourites list?');
                }
                return Html::a('<i class="fa fa-star"></i>', ['account/favourite'], ['title' => $title, 'class' => $class, 'onclick'=> 'js:favourite($(this)); return false', 'data-id' => $model->_id, 'data-type' => 'seeker']) . ' ' . Html::a($model->candidate_id, ['/job/account/public-profile', 'display_name' => $model->user->display_name], ['title' => Yii::t('job', 'View detail'), 'class' => 'view-detail']);
            },
                ],
                [
                    'attribute' => 'latest_company',
                ],
                [
                    'attribute' => 'latest_position',
                ],
                [
                    'attribute' => 'location',
                    'value' => function($model, $key, $index, $widget) {
                        return ArrayHelper::getValue(\app\modules\job\models\JobLocation::getOptions(), ArrayHelper::getValue($model, 'location'));
                    },
                ],
            ],
            'responsive' => true,
            'hover' => true,
        ]);
        ?>