<?php
use Yii;
use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;
?>

<?php
if (!Yii::$app->user->isGuest) {
    echo Yii::$app->user->identity->email . ' :: ' . Html::a('Logout', ['/account/auth/logout']);
} else {
    echo AuthChoice::widget([
        'baseAuthUrl' => ['auth/oauthtest']
    ]);
}
?>
