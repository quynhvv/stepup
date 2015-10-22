<?php
/* @var $this yii\web\View */
/* @var $model app\modules\message\models\Message */
/* @var $modelMessageUser app\modules\message\models\MessageUser */
?>

Hi <?= (!empty($modelMessageUser->user->display_name)) ? $modelMessageUser->user->display_name : $modelMessageUser->user->email ?>,

You have received a message from <?= (!empty(Yii::$app->user->identity->display_name)) ? Yii::$app->user->identity->display_name : Yii::$app->user->identity->email ?>

To view this message, let's click LINK:
<?= \Yii::$app->urlManager->createAbsoluteUrl(['/message/frontend/default/view', 'id' => $model->primaryKey]) ?>

Regards,
StepupCarreers
