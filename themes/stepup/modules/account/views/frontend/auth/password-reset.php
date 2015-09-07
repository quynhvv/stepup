<?php
use app\components\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;

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
                        <h2 class="title"><?= Html::encode($this->title) ?></h2>
                        <h5 class="subtitle">Please choose your new password:</h5>
                    </div>

                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'button button-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->
