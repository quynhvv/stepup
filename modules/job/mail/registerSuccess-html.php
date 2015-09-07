<?php
/* @var $this yii\web\View */
/* @var $model app\modules\job\models\User */
?>
<div class="register-success">
    <h2>You’re now registered at <?= \Yii::$app->name ?></h2>

    <p>Dear,</p>

    <p>Thank you for creating an account with us! You may now login.</p>

    <p>Account Infomation:</p>

    <p>Member ID: <?= $model->email ?></p>

    <p>Password: (Hidden for security reasons)</p>
</div>
