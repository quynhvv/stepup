<?php
/* @var $this yii\web\View */
/* @var $model app\modules\message\models\Message */
/* @var $modelMessageUser app\modules\message\models\MessageUser */
?>
<div class="register-success">
    <p>Hi <?= (!empty($modelMessageUser->user->display_name)) ? $modelMessageUser->user->display_name : $modelMessageUser->user->email ?>,</p>
    <p>You have received a message from <?= (!empty(Yii::$app->user->identity->display_name)) ? Yii::$app->user->identity->display_name : Yii::$app->user->identity->email ?></p>
    <p>To view this message, let's click <?= \yii\helpers\Html::a('HERE', \Yii::$app->urlManager->createAbsoluteUrl(['/message/frontend/default/view', 'id' => $model->primaryKey])) ?>.</p>
    <p>Regards,</p>
    <p>StepupCarreers</p>
</div>
