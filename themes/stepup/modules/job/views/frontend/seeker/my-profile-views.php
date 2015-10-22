<?php
use app\components\ActiveForm;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
use yii\helpers\Url;
use app\components\GridView;
 ?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-2cols-right">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-main section-gap">
                            <div class="table-responsive">
                                <?php
                                echo GridView::widget([
                                    'panel' => [
                                        'heading' => '<h3 class="h4 text-uppercase text-left">'.Yii::t(Yii::$app->controller->module->id, 'Who viewed me?').'</h3>',
                                        'tableOptions' => [
                                            'id' => 'listCandidate',
                                        ],
                                        //'footer' => false
                                    ],
                                    'pjax' => true,
                                    'dataProvider' => $dataProvider,
                                    //'filterModel' => $searchModel,
                                    'toolbar' => [
                                        [
                                            'content' => ''
                                        ],
                                    //'{export}',
                                    //'{toggleData}'
                                    ],
                                    'columns' => [
                                            [
                                                'attribute' => 'name',
                                                'format' => 'raw',
                                                'value' => function($model, $key, $index, $widget) {
                                                    $display_name = app\modules\job\models\User::findOne(['_id' => $model->view_by_user_id])->display_name; 
                                                    return Html::a($display_name, ['/job/account/public-profile', 'display_name' => $display_name], ['title' => Yii::t('job', 'View detail'), 'class' => 'view-detail']);
                                                },
                                            ],
                                            [
                                                'attribute' => 'company_name',
                                                'value' => function($model, $key, $index, $widget) {
                                                    return app\modules\job\models\UserJob::findOne(['_id' => $model->view_by_user_id])->agent_company_name;
                                                },
                                            ],
                                            [
                                                'attribute' => 'last_view_date',
                                                'value' => function($model, $key, $index, $widget) {
                                                    return Yii::$app->formatter->asDate($model->last_view_date->sec);
                                                },
                                            ],
                                        ],
                                        'responsive' => true,
                                        'hover' => true,
                                    ]);
                                    ?>
<!--                                <table class="table table-bordered table-striped table-hovered text-center">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                <h3 class="h4 text-uppercase text-left">Who viewed me ?</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Last Viewed Date</th>
                                        </tr>
                                        <tr>
                                            <td>Jeri Chartier</td>
                                            <td>Brunswick Corporation</td>
                                            <td>2014-07-13</td>
                                        </tr>
                                        <tr>
                                            <td>Jaimee Wotring</td>
                                            <td>Campbell Soup Company</td>
                                            <td>2013-09-21</td>
                                        </tr>
                                        <tr>
                                            <td>Mazie Backlund</td>
                                            <td>Cartoon Network Studios</td>
                                            <td>2012-07-03</td>
                                        </tr>
                                    </tbody>
                                </table>-->
                            </div>
                            
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sidebar">
                            <?= $this->render('_sidebar') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->