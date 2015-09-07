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
            <li><a href="<?= Url::to(['/job/default/post']) ?>"><?= Yii::t('job', 'Post New Jobs')?></a></li>
            <li><a href="<?= Url::to(['/job/default']) ?>"><?= Yii::t('job', 'Manage Jobs')?></a></li>
        </ul>
    </li>
    
    <li>Updating...</li>
</ul>
