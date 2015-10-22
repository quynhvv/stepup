<?php

/* @var $this yii\web\View */
/* @var $model app\modules\account\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/account/frontend/recovery/reset', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->email ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
