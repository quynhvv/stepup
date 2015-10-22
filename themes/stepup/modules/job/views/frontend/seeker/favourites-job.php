<?php
//use app\components\ActiveForm;
//use yii\helpers\Html;
//use app\helpers\ArrayHelper;
use yii\helpers\Url;
 ?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-2cols-right">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-main section-gap">
                            <ul class="nav nav-tabs nav-justified" id="nav-job">
                                <li role="presentation">
                                    <a role="button" href="<?= Url::to(['job-search']) ?>">Job Search</a>
                                </li>
                                <li role="presentation" class="active">
                                    <a role="button" href="<?= Url::to(['favourites-job']) ?>">My Favourites</a>
                                </li>
                                <li role="presentation">
                                    <a role="button" href="#">My History</a>
                                </li>
                                <li role="presentation">
                                    <a role="button" href="#">Job Ranking</a>
                                </li>
                            </ul>
                            <div class="box-job-search">
                                <div class="box-content">
                                    <?= $this->render('_job-gridview', ['dataProvider' => $dataProvider]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sidebar">
                            <?= $this->render('_sidebar') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->