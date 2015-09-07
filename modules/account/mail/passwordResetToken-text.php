<?php

/* @var $this yii\web\View */
/* @var $model app\modules\account\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/account/auth/passwordreset', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->email ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
