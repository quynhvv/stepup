<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\GridView;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <ul class="nav nav-tabs m-b-lg">
        <li role="presentation"><a href="<?= Url::to(['/account/default']) ?>"><?= Yii::t('account', 'User') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/role']) ?>"><?= Yii::t('account', 'Role') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/permission']) ?>"><?= Yii::t('account', 'Permission') ?></a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['/account/rbac/actionlist']) ?>"><?= Yii::t('account', 'Action list') ?></a></li>
    </ul>
    <div id="message"></div>
    <div class="row m-b-md">
        <div class="col-lg-12">
            <div class="btn-group">
                <?php
                echo Html::button(Yii::t('yii', 'Create Permissions'), [
                    'class' => 'btn btn-success',
                    'onclick' => 'addPermissionFromActionList();',
                ]);
                ?>
                <?php
                echo Html::a(Yii::t('yii', 'Get Permissions'), ['rbac/actionlist', 'generation' => 1], [
                    'class' => 'btn btn-info',
                ]);
                ?>
            </div>
        </div>
    </div>

    <?php
    echo GridView::widget([
        'panel' => [
            'heading' => Yii::t(Yii::$app->controller->module->id, 'Account'),
            // 'after' => '{export}',
            'tableOptions' => [
                'id' => 'listDefault',
            ],
        ],
        'pjax' => TRUE,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'app\modules\account\components\SelectActionForItemColumn',],
            '_id',
            'module',
            'app',
            'controller',
            'action',
            [
                'attribute' => 'is_permission',
                'class' => '\app\components\BooleanColumn',
//                'trueLabel' => 'Yes',
//                'falseLabel' => 'No'
            ],
        ],
        'responsive' => true,
        'hover' => true,
    ]);
    ?>


</div>