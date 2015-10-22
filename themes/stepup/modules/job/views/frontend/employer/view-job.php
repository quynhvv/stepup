<?php
use yii\bootstrap\Html;
use app\components\DetailView;
use app\helpers\ArrayHelper;
use app\modules\job\models\Job;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="row jobs-posted">
                <div class="section-title section-title-style-2">
                    <h2 class="title"> <?= Yii::t('job', "Job Informations")?> </h2>
                </div>
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'code',
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
                        ],
                        'hits'
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->
