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
</ul>
