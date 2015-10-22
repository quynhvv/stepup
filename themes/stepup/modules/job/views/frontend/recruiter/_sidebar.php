<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\job\models\UserJob;
?>

<div class="block block-upgrade">
    <div class="block-content">
        <a href="<?= UserJob::getUpgradeUrl() ?>" class="button button-long button-lg button-primary">Upgrade Your Account</a>
    </div>
</div>
<div class="block">
    <div class="block-content">
        <a class="button button-long button-lg button-primary" href="<?= UserJob::getPostJobUrl() ?>"><?= Yii::t('job', 'Post Jobs') ?></a>
    </div>
</div>
<div class="block">
    <div class="block-content">
        <a href="#" class="special-hover-link-1">Make a Placement ?</a>
    </div>
</div>
<div class="block block-spotlight">
    <div class="block-title">
        <h3 class="title">Weekly Spotlight</h3>
    </div>
    <div class="block-content">
        <div class="media">
            <div class="media-left">
                <a href="#">
                    <!--<img class="media-object" src="images/spotlight-avatar.png" alt="spotlight avatar">-->
                </a>
            </div>
            <div class="media-body">
                <p>Each week we showcase the most active recruiters and their jobs to candidates. <a href="#">learn more</a></p>
                <div class="text-right">
                    <span class="i-bg icn-ranking-top10"></span>
                    <span class="i-bg icn-ranking-top50"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block block-search">
    <h2> Saved Searches
        <span title="Your saved searches are listed here. To edit a search, click on the name." class="question"> ?</span>
    </h2>
    <div class="block-content">
        <h4>Search Title</h4>
        <ul>
            <li><a href="#">Manvendra serach</a></li>
            <li><a href="#">Business</a></li>
            <li><a href="#">lokesh</a></li>
        </ul>
        <br>
        <strong>Basic Search</strong>
        
        <?= $this->render('_form-search-seeker') ?>
        
        <br>
        <a href="<?= Url::to(['search-seeker']) ?>"> Advance Search</a>
    </div>
</div>