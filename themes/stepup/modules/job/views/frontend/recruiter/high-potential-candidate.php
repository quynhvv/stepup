<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
use app\components\GridView;
?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-2cols-right">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-main">
                            <div class="section-gap">
<!--                                <span>
                                    <strong>High Potential Candidate </strong>
                                    <span title="Mid-Level Plus (ML+) candidates are members which are just underour US $70,000 minimum salary requirement to qualify for StepupCareers membership. These are high potential candidates who typically have less experience,but are ready to level up their career" class="question">?</span>
                                </span>-->
                                <div class="table-responsive">
                                <?= $this->render('_seeker-gridview', ['dataProvider' => $dataProvider]) ?>
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