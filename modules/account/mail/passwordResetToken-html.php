<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\account\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/account/frontend/recovery/reset', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->email) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
