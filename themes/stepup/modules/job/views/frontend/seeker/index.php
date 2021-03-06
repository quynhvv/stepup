<?php
use app\components\ActiveForm;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
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
                            <div class="box-job-search">
                                <div class="box-title">
                                    <h2 class="title">Job search</h2>
                                </div>
                                <div class="box-content">
                                    
                                    <?= $this->render('_form-search-job', ['searchModel' => $searchModel]) ?>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <tbody>
                                            <tr>
                                                <td>LATEST JOBS</td>
                                                <td align="right" colspan="4"><?= Html::a(Yii::t('job', 'View All'), ['job-search'], ['class' => 'button button-primary button-long button-lg']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Position</th>
                                                <th>Salary</th>
                                                <th>Company</th>
                                                <th>Last Update</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php foreach ($dataProvider->getModels() as $model) : ?>
                                            <tr>
                                                <td><?= Html::a(Html::encode($model->title), ['job-detail', 'id' => (string) $model->_id]) ?></td>
                                                <td><?= Html::encode(ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_from')). ' to ' . ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_to'))) ?></td>
                                                <td><?= Html::encode($model->company_name) ?></td>
                                                <td><?= Yii::$app->formatter->asDate($model->updated_time->sec) ?></td>
                                                <td><?= Html::a(Yii::t('job', 'View'), ['job-detail', 'id' => (string) $model->_id]) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
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