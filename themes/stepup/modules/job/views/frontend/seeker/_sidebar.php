<?php

use yii\helpers\Html;

?>
<div class="block block-upgrade">
    <div class="block-content">
        <?= Html::a(Yii::t('job', 'Upgrade to Premium'), ['/job/account/upgrade'], ['class' => 'button button-long button-lg button-secondary button-upgrade']) ?>
    </div>
</div>
<?php echo app\modules\job\widgets\frontend\TrendingJob::widget([]); ?>