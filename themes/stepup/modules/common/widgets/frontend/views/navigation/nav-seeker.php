<?php
use yii\helpers\Url;
?>
<ul class="menu-main hidden-sm hidden-xs">
    <li class="active">
        <a href="<?= Url::to(['/job/seeker/index']) ?>"><?= Yii::t('account', 'My page') ?></a>
    </li>
    <li class="menu-item-has-children">
        <a href="<?= Url::to(['/job/seeker/resume']) ?>"><?= Yii::t('account', 'My resume') ?></a>
        <ul class="sub-menu">
            <li><a href="<?= Url::to(['/job/seeker/information']) ?>"><?= Yii::t('account', 'Basic Information') ?></a></li>
            <li><a href="#">Free Format Resume</a></li>
            <!--<li><a href="#">Job Prefrence</a></li>-->
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
        <a href="<?= Url::to(['/job/seeker/profile-views']) ?>">My profile views</a>
    </li>
    <li class="menu-item-has-children">
        <a href="#">Jobs</a>
        <ul class="sub-menu">
            <li><a href="<?= Url::to(['/job/seeker/job-search']) ?>">Job Search</a></li>
            <li><a href="<?= Url::to(['/job/seeker/favourites-job']) ?>">Favorite jobs</a></li>
            <li><a href="#">Job Rankings</a></li>
            <li><a href="#">Job view history</a></li>
            <!--<li><a href="#">Application history</a></li>-->
        </ul>
    </li>
    <li>
        <a href="#">Recruiters</a>
    </li>
    <!--    <li>
            <a href="#">Executive Resume Service</a>
        </li>-->
</ul>
