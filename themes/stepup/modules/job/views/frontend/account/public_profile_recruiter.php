<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="media avatar">
                        <div class="media-left">
                            <a href="<?= Url::to(['/account/public-profile'], ['display_name' => $user->display_name]) ?>">
                                <?= Html::img(\app\helpers\LetHelper::getFileUploaded($user->image), ['class' => 'media-object', 'width' => '80', 'height' => '80']) ?>
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Html::encode($user->userJob->getDisplayName()) ?></h4>
                        </div>
                    </div>
                    <dl class="row information">
                        <dt class="col-xs-12 col-sm-4">Company Name:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= ($user->userJob->agent_company_name) ? Html::encode($user->userJob->agent_company_name) : Yii::t('common', 'Not set') ?></dd>
                        <dt class="col-xs-12 col-sm-4">Position:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= ($user->userJob->agent_position) ? Html::encode($user->userJob->agent_position) : Yii::t('common', 'Not set') ?></dd>
                        <dt class="col-xs-12 col-sm-4">Office Location:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= ($user->userJob->agent_office_location) ? Html::encode(app\modules\job\models\JobLocation::findOne(['_id' => $user->userJob->agent_office_location])->title) : Yii::t('common', 'Not set') ?></dd>
                        <dt class="col-xs-12 col-sm-4">City Name:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= ($user->userJob->agent_city_name) ? Html::encode($user->userJob->agent_city_name) : Yii::t('common', 'Not set') ?></dd>
                        <dt class="col-xs-12 col-sm-4">Corporate Site:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= ($user->userJob->agent_website) ? Html::encode($user->userJob->agent_website) : Yii::t('common', 'Not set') ?></dd>
                        <dt class="col-xs-12 col-sm-4">Email:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= Yii::$app->user->identity->email; ?></dd>
                        <dt class="col-xs-12 col-sm-4">Telephone:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= (Yii::$app->user->identity->phone) ? Yii::$app->user->identity->phone : Yii::t('common', 'Not set'); ?></dd>
                        <dt class="col-xs-12 col-sm-4">Industry Coverage:</dt>
                        <dd class="col-xs-12 col-sm-8"><?= Html::encode($user->userJob->getJobIndustryCoverageTitle()); ?></dd>
                        <dt class="col-xs-12 col-sm-4">Jobs Functions :</dt>
                        <dd class="col-xs-12 col-sm-8"><dd class="col-xs-12 col-sm-8"><?= Html::encode($user->userJob->getJobFunctionTitle()); ?></dd></dd>
                        <dt class="col-xs-12 col-sm-4">Professional Summary :</dt>
                        <dd class="col-xs-12 col-sm-8"><?= ($user->userJob->agent_summary) ? Html::encode($user->userJob->agent_summary) : Yii::t('common', 'Not set') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->