<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\GridView;

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <ul class="nav nav-tabs m-b-lg">
        <li role="presentation" class="active"><a href="<?= Url::to(['/account/default']) ?>"><?= Yii::t('account', 'User') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/role']) ?>"><?= Yii::t('account', 'Role') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/permission']) ?>"><?= Yii::t('account', 'Permission') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/actionlist']) ?>"><?= Yii::t('account', 'Action list') ?></a></li>
    </ul>

    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Nestable custom theme list</h5>
                    </div>
                    <div class="ibox-content">
                        <?= Html::hiddenInput('user_id', Yii::$app->request->get('user_id', '')); ?>
                        <div class="dd" id="nestable2">
                            <?= $treeHtml ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
