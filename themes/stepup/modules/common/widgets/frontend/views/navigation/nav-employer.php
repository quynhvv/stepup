<?php
use yii\helpers\Url;
?>
<ul class="menu-main hidden-sm hidden-xs">
    <li class="active">
        <a href="<?=Yii::$app->homeUrl ?>"><?=Yii::t('account', 'Home')?></a>
    </li>
    <li>
        <a href="#"><?=Yii::t('account', 'About')?></a>
    </li>
    <li>
        <a href="#"><?=Yii::t('account', 'Blog')?></a>
    </li>
    <li>
        <a href="#"><?=Yii::t('account', 'Contact')?></a>
    </li>
    <li class="menu-item-has-children active">
        <a href="#"><?= Yii::t('job', 'Jobs')?></a>
        <ul class="sub-menu">
            <li><a href="<?= Url::to(['/job/employer/post-job']) ?>"><?= Yii::t('job', 'Post New Jobs')?></a></li>
            <li><a href="<?= Url::to(['/job/employer/list-job']) ?>"><?= Yii::t('job', 'Manage Jobs')?></a></li>
        </ul>
    </li>
    <li class="menu-item-has-children">
        <a href="<?= Url::to(['/message/frontend/default/index']) ?>">My messages <span class="label label-danger"><?= \app\modules\message\models\Message::countMessageUnread() ?></span></a>
        <ul class="sub-menu">
            <li><a href="<?= Url::to(['/message/frontend/default/index', 'type' => \app\modules\message\models\Message::TYPE_INBOX]) ?>">Inbox</a></li>
            <li><a href="<?= Url::to(['/message/frontend/default/index', 'type' => \app\modules\message\models\Message::TYPE_SENT]) ?>">Outbox</a></li>
        </ul>
    </li>
</ul>
