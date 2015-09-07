<?php

use app\components\DetailView;
use app\helpers\ArrayHelper;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\job\models\Job */

//$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('job', 'Jobs'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <p>
                <?= Html::a(Yii::t(Yii::$app->controller->module->id, 'Update'), ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t(Yii::$app->controller->module->id, 'Delete'), ['delete', 'id' => (string) $model->_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t(Yii::$app->controller->module->id, 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Yii::t(Yii::$app->controller->module->id, 'Infomation') ?></h5>
                </div>
                <div class="ibox-content">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [

							'_id',
							'annual_salary_from',
							'annual_salary_to',
							'category_ids',
							'city_name',
							'code',
							'company_description',
							'company_name',
							'country_id',
							'created_by',
							'created_time',
							'description',
							'email_cc',
							'function2',
							'function3',
							'functions',
							'hits',
							'industry',
							'industry2',
							'is_filtering',
							'seo_desc',
							'seo_title',
							'seo_url',
							'status',
							'title',
							'updated_time',
							'work_type',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
