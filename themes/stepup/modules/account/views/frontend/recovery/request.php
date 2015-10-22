<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('account', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                    <div class="section-title section-title-style-2">
                        <h2 class="title"><?= Html::encode($this->title) ?></h2>
                        <h5 class="subtitle">Please fill out your email. A link to reset password will be sent there.</h5>
                    </div>

                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'email') ?>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'button button-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->

