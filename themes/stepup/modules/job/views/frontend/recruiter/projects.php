<?php
use app\components\ActiveForm;
//use kartik\datecontrol\DateControl;
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
            <div class="section-inner">
                <div class="section-content layout-2cols-left">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-sm-push-3 col-main section-gap">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="add-new-project">
                                    <h1>Create A New Project</h1>
                                        <?php
                                        $form = ActiveForm::begin([
                                            'id' => 'formDefault',
                                            'method' => 'post',
                                            'layout' => 'horizontal',
                                            'fieldConfig' => [
                                                'horizontalCssClasses' => [
                                                    'label' => 'col-sm-3',
                                                    'wrapper' => 'col-sm-9',
                                                    'error' => 'help-block m-b-none',
                                                    'hint' => '',
                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <p>After you have given your new project a name and description click Save and start adding Candidates</p>
                                        <?= $form->field($model, 'name')->textInput(['placeholder' => Yii::t('job', 'Project Name')]) ?>
                                        <?= $form->field($model, 'description')->textArea(['rows' => '3', 'class' => 'form-control css-auto-height', 'placeholder' => Yii::t('job', 'Project Description')]) ?>
                                        <?= $form->field($model, 'candidates')->listBox($model::getCandidatesOptions(), ['multiple' => true]) ?>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="reset" id="btn-reset" value="Reset" class="button">
                                                <input type="submit" id="bnt-save" value="Save" class="button button-primary" name="btn_create">
                                            </div>
                                        </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="all-project">
                                    <div class="table-responsive">
                                        <?php
                                        echo GridView::widget([
                                            'panel' => [
                                                //'heading' => Yii::t('job', 'Projects').': ',
                                                'tableOptions' => [
                                                    'id' => 'listDefault',
                                                ],
                                            ],
                                            'pjax' => true,
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'toolbar' =>  [
                                                ['content'=>
                                                    //Html::a('<i class="glyphicon glyphicon-plus"></i>', ['projects'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>Yii::t('job', 'Create Project')]) .' '.
                                                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['projects'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
                                                ],
                                                //'{export}',
                                                '{toggleData}'
                                            ],
                                            'columns' => [
                                                ['class' => 'kartik\grid\CheckboxColumn'],
                                                ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'attribute' => 'status',
                                                    'label' => Yii::t('job', 'Satus'),
                                                    'value' => function($model, $key, $index, $widget){
                                                        return ArrayHelper::getValue(\app\modules\job\models\Project::getStatusOptions(), ArrayHelper::getValue($model, 'status'));
                                                    },
                                                    'contentOptions'=>['style'=>'min-width: 150px;'],
                                                    'filterType' => GridView::FILTER_SELECT2,
                                                    'filter' => \app\modules\job\models\Project::getStatusOptions(true),
                                                ],
                                                [
                                                    'attribute' => 'name',
                                                    'label' => Yii::t('job', 'Name'),
                                                ],
                                                [
                                                    'attribute' => 'description',
                                                    'label' => Yii::t('job', 'Description'),
                                                    'format' => 'raw',
                                                ],
//                                                [
//                                                    'attribute' => 'candidates',
//                                                ],
                                                [
                                                    'attribute' => 'created_time',
                                                    'label' => Yii::t('job', 'Date'),
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
                                                        //return date('Y-m-d h:i:s', $model->created_time->sec);
                                                        return Yii::$app->formatter->asDate(date('Y-m-d h:i:s', $model->created_time->sec), 'long');
                                                    },
                                                ],
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
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sm-pull-9 col-sidebar">
                            <ul class="nav nav-pills nav-stacked" role="tablist">
                                <li role="presentation">
                                    <a href="#add-new-project" aria-controls="add-new-project" role="tab" data-toggle="tab">Create A New Project</a>
                                </li>
                                <li role="presentation" class="active">
                                    <a href="<?= Url::to(['projects']) ?>#all-project" aria-controls="all-project" role="tab" data-toggle="tab">All Projects</a>
                                </li>
<!--                                <li role="presentation">
                                    <a href="#all-project" aria-controls="active-project" role="tab" data-toggle="tab">Active Projects</a>
                                </li>
                                <li role="presentation">
                                    <a href="#all-project" aria-controls="inactive-project" role="tab" data-toggle="tab">Inactive Projects</a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->