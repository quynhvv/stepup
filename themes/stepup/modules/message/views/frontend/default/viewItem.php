<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\job\helpers\ImageHelper;
?>

<div class="media">
    <a href="<?= Url::to(['/job/frontend/account/public-profile', 'display_name' => $model->user->display_name]) ?>" class="pull-left">
        <?= ImageHelper::getAvatar($model->user->primaryKey, ImageHelper::IMAGE, false, 48, ['class' => 'media-object']) ?>
    </a>
    <div class="media-body">
        <h5 class="media-heading">
            <?= Html::a($model->user->display_name, ['/job/frontend/account/public-profile', 'display_name' => $model->user->display_name]) ?> <small><?= Yii::$app->formatter->asDatetime($model->created_at->sec) ?></small>
        </h5>
        <p><?= $model->content ?></p>
    </div>
</div>
