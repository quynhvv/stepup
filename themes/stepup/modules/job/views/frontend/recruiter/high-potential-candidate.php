<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
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
                        <div class="col-xs-12 col-sm-9 col-main">
                            <div class="section-gap">
<!--                                <span>
                                    <strong>High Potential Candidate </strong>
                                    <span title="Mid-Level Plus (ML+) candidates are members which are just underour US $70,000 minimum salary requirement to qualify for StepupCareers membership. These are high potential candidates who typically have less experience,but are ready to level up their career" class="question">?</span>
                                </span>-->
                                <div class="table-responsive">
                                <?php 
                                    echo GridView::widget([
                                        'panel' => [
                                            //'heading' => Yii::t(Yii::$app->controller->module->id, 'High Potential Candidate').': ',
                                            'tableOptions' => [
                                                'id' => 'listCandidate',
                                            ],
                                        ],
                                        'pjax' => true,
                                        'dataProvider' => $dataProvider,
                                        //'filterModel' => $searchModel,
                                        'toolbar' =>  [
                                            ['content'=>
                                                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['high-potential-candidate'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
                                            ],
                                            //'{export}',
                                            //'{toggleData}'
                                        ],
                                        'columns' => [
                                            [
                                                'attribute' => 'candidate_id',
                                            ],
                                            [
                                                'attribute' => 'latest_company',
                                            ],
                                            [
                                                'attribute' => 'latest_position',
                                            ],
                                            [
                                                'attribute' => 'location',
                                                'value' => function($model, $key, $index, $widget){
                                                    return ArrayHelper::getValue(\app\modules\job\models\JobLocation::getOptions(), ArrayHelper::getValue($model, 'location'));
                                                },
                                            ],
                                        ],
                                        'responsive' => true,
                                        'hover' => true,
                                    ]);
                                ?>
                                </div>
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