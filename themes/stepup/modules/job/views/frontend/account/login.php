<?php
use app\components\ActiveForm;
use yii\helpers\Html;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                    <div class="section-title section-title-style-2">
                        <?= Html::a(Yii::t('account', 'Sign up'), ['/job/account/register', 'role' => $role]) ?>
                        <h2 class="title"><?= Html::encode($this->title) ?></h2>
                    </div>
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'formDefault',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'label' => 'col-sm-3',
                                'wrapper' => 'col-sm-9',
                                'error' => 'help-block m-b-none',
                                'hint' => '',
                            ],
                        ],
                    ]);
                    ?>
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <?= Html::submitButton(Yii::t('account', 'Sign in'), ['class' => 'button button-primary']) ?>
                            <?= Html::a(Yii::t('account', 'Forgot your password?'), ['/account/auth/passwordrequest'], ['class' => 'btn btn-link']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                    <?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['oauth', 'role' => $role]]) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->