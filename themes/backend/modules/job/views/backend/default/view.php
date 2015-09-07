<?php
use yii\bootstrap\Html;
use app\components\DetailView;
use app\helpers\ArrayHelper;
use app\modules\job\models\Job;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <div class="btn-group pull-right">
                <?php echo Html::a(Yii::t(Yii::$app->controller->module->id, 'Update Status'), ['default/update-status', 'id' => $model->_id], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Yii::t(Yii::$app->controller->module->id, 'Detail Information') ?></h5>
                </div>
                <div class="ibox-content">
                    <?php
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'code',
                            'title',
                            [
                                'attribute'=>'country_id',
                                'value' => ArrayHelper::getValue(\app\modules\job\models\JobLocation::getOptions(), ArrayHelper::getValue($model, 'country_id'))
                            ],
                            [
                                'attribute'=>'category_ids',
                                'value' => $model->getCategoryNames(),
                                'format' => 'raw'
                            ],
                            'city_name',
                            [
                                'attribute'=>'annual_salary_from',
                                'value' => ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_from'))
                            ],
                            [
                                'attribute'=>'annual_salary_to',
                                'value' => ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_to'))
                            ],
                            [
                                'attribute'=>'functions',
                                'value' => $model->getFunctionNames(),
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'work_type',
                                'value' => ArrayHelper::getValue(app\modules\job\models\JobWorkType::getOptions(), ArrayHelper::getValue($model, 'work_type'))
                            ],
                            [
                                'attribute'=>'industry',
                                'value' => $model->getIndustryNames(),
                                'format' => 'raw'
                            ],
                            'company_name',
                            'company_description:html',
                            'description:html',
                            'seo_url',
                            'seo_title',
                            'seo_desc',
                            [
                                'attribute' => 'created_time',
                                'format' => ['datetime', 'php:m/d/Y H:i:s'],
                                'value' => $model->created_time->sec
                            ],
                            [
                                'attribute' => 'updated_time',
                                'format' => ['datetime', 'php:m/d/Y H:i:s'],
                                'value' => $model->updated_time->sec
                            ],
                            [
                                'attribute' => 'satus',
                                'value' => ArrayHelper::getValue(Job::getStatusOptions(), ArrayHelper::getValue($model, 'status'))
                            ]
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>