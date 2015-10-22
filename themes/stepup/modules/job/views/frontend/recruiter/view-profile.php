<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 section-gap">
                            <div class="media avatar">
                                <div class="media-left">
                                    <a href="<?= Url::to(['view-profile']) ?>">
                                        <?= Html::img(\app\helpers\LetHelper::getFileUploaded(Yii::$app->user->identity->image), ['class' => 'media-object', 'width' => '80', 'height' => '80']) ?>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?= Html::encode($userJob->getDisplayName()) ?></h4>
                                    <p><a href="<?= Url::to(['list-job']) ?>"><?= Yii::t('job', 'Review my posted jobs'); ?></a></p>
                                </div>
                            </div>
                            <dl class="row information">
                                <dt class="col-xs-12 col-sm-4">Display Name:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= Html::encode($userJob->getDisplayName()) ?></dd>
                                <dt class="col-xs-12 col-sm-4">Company Name:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= ($userJob->agent_company_name) ? Html::encode($userJob->agent_company_name) : Yii::t('common', 'Not set') ?></dd>
                                <dt class="col-xs-12 col-sm-4">Position:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= ($userJob->agent_position) ? Html::encode($userJob->agent_position) : Yii::t('common', 'Not set') ?></dd>
                                <dt class="col-xs-12 col-sm-4">Office Location:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= ($userJob->agent_office_location) ? Html::encode(app\modules\job\models\JobLocation::findOne(['_id' => $userJob->agent_office_location])->title) : Yii::t('common', 'Not set') ?></dd>
                                <dt class="col-xs-12 col-sm-4">City Name:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= ($userJob->agent_city_name) ? Html::encode($userJob->agent_city_name) : Yii::t('common', 'Not set') ?></dd>
                                <dt class="col-xs-12 col-sm-4">Corporate Site:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= ($userJob->agent_website) ? Html::encode($userJob->agent_website) : Yii::t('common', 'Not set') ?></dd>
                                <dt class="col-xs-12 col-sm-4">Email:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= Yii::$app->user->identity->email; ?></dd>
                                <dt class="col-xs-12 col-sm-4">Telephone:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= (Yii::$app->user->identity->phone) ? Yii::$app->user->identity->phone : Yii::t('common', 'Not set'); ?></dd>
                                <dt class="col-xs-12 col-sm-4">Industry Coverage:</dt>
                                <dd class="col-xs-12 col-sm-8"><?= Html::encode($userJob->getJobIndustryCoverageTitle()); ?></dd>
                                <dt class="col-xs-12 col-sm-4">Jobs Functions :</dt>
                                <dd class="col-xs-12 col-sm-8"><dd class="col-xs-12 col-sm-8"><?= Html::encode($userJob->getJobFunctionTitle()); ?></dd></dd>
                                <dt class="col-xs-12 col-sm-4">Professional Summary :</dt>
                                <dd class="col-xs-12 col-sm-8"><?= ($userJob->agent_summary) ? Html::encode($userJob->agent_summary) : Yii::t('common', 'Not set') ?></dd>
                            </dl>
                            
                            <?= Html::a(Yii::t('job', 'Edit'), ['/job/recruiter/edit-profile'], ['class' => 'button button-lg']) ?>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4">
                            <div class="block block-week-spotlight">
                                <div class="block-title">
                                    <h5><i class="fa fa-user"></i> Weekly Spotlight</h5>
                                </div>
                                <div class="block-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum laoreet mi sit amet sem conse quat eget ultricies nisi tincidunt. Donec dictum posuere commodo. Curabitur soll dictum icitudin dictum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
                            <div class="block block-week-spotlight">
                                <div class="block-title">
                                    <h5>Your Weekly Activity Stats</h5>
                                </div>
                                <div class="block-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipi scing elit. Vestibulum laoreet mi sit amet. amet sem conse.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->