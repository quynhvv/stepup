<?php
use app\components\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                    <div class="section-title section-title-style-2">
                        <!--<h2 class="title"> <?= Yii::t('job', "Job Informations")?> </h2>-->
                    </div>
                    <?php echo $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->