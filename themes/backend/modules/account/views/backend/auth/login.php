<?php
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Adminstrator Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">BB+</h1>
        </div>
        <h3>Welcome to BB+</h3>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'm-t', 'role' => 'form']]); ?>
        <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Email'])->label(false); ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
        <?php // $form->field($model, 'rememberMe')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
<!--        <a href="#"><small>Forgot password?</small></a>
        <p class="text-muted text-center"><small>Do not have an account?</small></p>
        <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
        <p class="m-t"> <small>Power by Letyii 1.0. Based on Yii Framework 2.0 &copy; <?= date('Y') ?></small> </p>
    </div>
</div>
