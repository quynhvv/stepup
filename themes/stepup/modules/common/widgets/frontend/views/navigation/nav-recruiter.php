<?php
use yii\helpers\Url;
?>

<ul class="menu-main hidden-sm hidden-xs">
    <li class="active">
        <a href="<?= Url::to(['/job/recruiter/index']) ?>"><?= Yii::t('account', 'My page') ?></a>
    </li>
    <li class="menu-item-has-children">
        <a href="#"><?= Yii::t('job', 'Jobs') ?></a>
        <ul class="sub-menu">
            <li><a href="<?= Url::to(['/job/recruiter/post-job']) ?>"><?= Yii::t('job', 'Post New Jobs') ?></a></li>
            <li><a href="<?= Url::to(['/job/recruiter/list-job']) ?>"><?= Yii::t('job', 'Manage Jobs') ?></a></li>
        </ul>
    </li>
    <li class="menu-item-has-children">
        <a href="#">Candidates</a>
        <ul class="sub-menu">
            <li><a href="<?= Url::to(['/job/recruiter/search-seeker']) ?>">Advance Search</a></li>
            <li><a href="#">Saved Search</a></li>
            <li><a href="<?= Url::to(['/job/recruiter/high-potential-candidate']) ?>">High Potentials</a></li>
            <li><a href="<?= Url::to(['/job/recruiter/new-candidate']) ?>">New Candidates</a></li>
            <li><a href="<?= Url::to(['/job/recruiter/favourites-candidate']) ?>">Favorites List</a></li>
        </ul>
    </li>
    <li class="menu-item-has-children">
        <a href="<?= Url::to(['/message/frontend/default/index']) ?>">My messages <span class="label label-danger"><?= \app\modules\message\models\Message::countMessageUnread() ?></span></a>
        <ul class="sub-menu">
            <li><a href="<?= Url::to(['/message/default', 'type' => 1]) ?>">Inbox</a></li>
            <li><a href="<?= Url::to(['/message/default', 'type' => 2]) ?>">Outbox</a></li>
        </ul>
    </li>
    <li>
        <a href="<?= Url::to(['/job/recruiter/projects']) ?>"><?= Yii::t('account', 'Projects'); ?></a>
    </li>
    <li>
        <a href="<?= Url::to(['/job/recruiter/view-profile']) ?>"><?= Yii::t('account', 'My Profile'); ?></a>
    </li>
</ul>
