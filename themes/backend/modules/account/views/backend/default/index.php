<?php
use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\GridView;
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<ul class="nav nav-tabs m-b-md">
		<li role="presentation" class="active"><a href="<?= Url::to(['/account/default'])?>"><?= Yii::t('account', 'User') ?></a></li>
		<li role="presentation"><a href="<?= Url::to(['/account/rbac/role'])?>"><?= Yii::t('account', 'Role') ?></a></li>
		<li role="presentation"><a href="<?= Url::to(['/account/rbac/permission']) ?>"><?= Yii::t('account', 'Permission') ?></a></li>
		<li role="presentation"><a href="<?= Url::to(['/account/rbac/actionlist']) ?>"><?= Yii::t('account', 'Action list') ?></a></li>
	</ul>
	<div class="row m-b-md">
		<div class="col-lg-12">
			<div class="btn-group">
                <?php
                echo Html::a(Yii::t('yii', 'Create'), ['default/create'], [
                    'class' => 'btn btn-success',
                    'onclick' => '$("#formDefault").submit();',
                ]);
                ?>
	        </div>
        </div>
	</div>
	<div class="row">
		<div class="col-lg-12">
            <?php
            echo GridView::widget([
                'panel' => [
                    'heading' => Yii::t(Yii::$app->controller->module->id, 'Product'),
                    // 'after' => '{export}',
                    'tableOptions' => [
                        'id' => 'listDefault',
                    ],
                ],
                'pjax' => TRUE,
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\CheckboxColumn'],
                    [
                        'attribute' => '_id',
                        'mergeHeader' => TRUE,
                        'hAlign' => 'center',
                    ],
                    'email',
                    [
                        'header' => 'Vai trò',
                        'mergeHeader' => TRUE,
                        'hAlign' => 'center',
                        'vAlign' => 'middle',
                        'value' => function ($model, $index, $widget) {
                            return Html::a('Quản lý vai trò', ['rbac/assign', 'user_id' => $model->_id], [
                                'class' => 'btn btn-xs btn-primary'
                            ]);
                        },
                        'format'=>'raw',
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



