<?php
use yii\helpers\Html;
use yii\web\View;
?>

<div class="block block-recent-job">
    <div class="block-title">
        <h3 class="title">Today's trending jobs</h3>
    </div>
    <div class="block-content">
        <ul>
            <?php foreach ($dataProvider->getModels() as $model) : ?>
            <li>
                <!--will have to update this later-->
                <!--<span class="ranking">1st</span>-->
                <?= Html::a(Html::encode($model->title), ['job-detail', 'id' => (string) $model->_id]) ?>
                <span class="salary-range">
                    <?= Html::encode(app\modules\job\models\JobSalary::findOne(['_id' => $model->annual_salary_from])->title  . ' to ' . app\modules\job\models\JobSalary::findOne(['_id' => $model->annual_salary_to])->title) ?>
                </span>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="actions">
            <?= Html::a(Yii::t('job', 'View Full List'), ['/job/seeker/job-search'], ['class' => 'button button-long button-lg button-secondary']) ?>
        </div>
    </div>
</div>

