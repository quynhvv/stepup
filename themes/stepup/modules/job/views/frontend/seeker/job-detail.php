<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\ArrayHelper;
use app\modules\job\models\Job;
use app\modules\job\models\UserJob;
use app\components\ActiveForm;
?>

<?php $form = ActiveForm::begin([])?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-2cols-right">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-main section-gap">
                            <div class="table-responsive">
                                <table id="jobdetail" class="table table-bordered table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <th colspan="2">
                                            <?php
                                                if (\app\modules\job\models\UserFavourite::isFavourite($model->_id, 'job', Yii::$app->user->id)){
                                                     $class = "favourites";
                                                     $title = Yii::t('job', 'Remove from favourites list?');
                                                 }
                                                 else {
                                                     $class = "un-favourites";
                                                     $title = Yii::t('job', 'Add to favourites list?');
                                                 }
                                                 echo Html::a('<i class="fa fa-star"></i>', ['account/favourite'], ['title' => $title, 'class' => $class, 'onclick'=> 'js:favourite($(this)); return false', 'data-id' => $model->_id, 'data-type' => 'job']);
                                             ?>
                                        </th>
                                        <th class="text-center"><a href="javascript:history.back()">Back</a></th>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="2">
                                            <h4>Job Overview</h4>
                                        </td>
                                        <td><?= Yii::$app->formatter->asDatetime($model->created_time->sec) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Salary Range</td>
                                        <td><?= Html::encode(ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_from')). ' to ' . ArrayHelper::getValue(\app\modules\job\models\JobSalary::getOptions(), ArrayHelper::getValue($model, 'annual_salary_to'))) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Job Title</td>
                                        <td><?= Html::encode($model->title) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Job Code</td>
                                        <td><?= Html::encode($model->code) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Location</td>
                                        <td><?php echo ArrayHelper::getValue(\app\modules\job\models\JobLocation::getOptions(), ArrayHelper::getValue($model, 'country_id')); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Jobs Industry</td>
                                        <td><?php echo $model->getIndustryNames(); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Company Info</td>
                                        <td>
                                            <?php if (UserJob::canView()):?>
                                                <h3><?php echo $model->company_name; ?></h3>
                                                <div><?php echo $model->company_description; ?></div>
                                            <?php else: ?>
                                                <a href="<?= UserJob::getUpgradeUrl() ?>">Upgrade here to view this information</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Job Description</td>
                                        <td>
                                            <?php if (UserJob::canView()):?>
                                                <?= $model->description ?>
                                            <?php else: ?>
                                                <div><?php echo Job::subStrWords($model->description, 200); ?></div>
                                                <br/><strong><a href="<?= UserJob::getUpgradeUrl() ?>">... Want to know more? Upgrade to Premium!</a></strong> 
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" colspan="3">
                                            <?php if (UserJob::canView()):?>
                                                <a href="<?= UserJob::getApplyUrl() ?>" class="button button-lg button-secondary button-long">
                                                    <span>Apply Now</span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= UserJob::getUpgradeUrl() ?>" class="button button-lg button-secondary button-long">
                                                    <span>Upgrade to Apply</span>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            <a href="javascript:history.back()" class="button button-secondary">
                                                <span>Back</span>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <?php 
                                    $userJob = $model->getUserJobPosted();
                                ?>
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-uppercase">Posted by this approved recruiter</span>
                                        </td>
                                        <td>
                                            <?= Html::a(Yii::t('job', 'View All Jobs'), ['job-search', 'Job[created_by]' => $userJob->_id], ['class' => '']) ?>
                                        </td>
                                        <td colspan="2"><?= Html::a(Yii::t('job', 'View Detail'), ['account/public-profile', 'display_name' => (string) $userJob->user->display_name]) ?></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="5">
                                            <?= Html::img(\app\helpers\LetHelper::getFileUploaded($userJob->user->image), ['class' => 'avatar avatar-100 photo', 'width' => '100', 'height' => '100']) ?>
                                        </td>
                                        <td>Recruiter Name</td>
                                        <td colspan="2">
                                            <?php if (UserJob::canView()):?>
                                                <span><?=$userJob->getDisplayName()?></span>
                                            <?php else: ?>
                                                <a href="<?= UserJob::getUpgradeUrl() ?>">Upgrade here to view this information </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Company</td>
                                        <td colspan="2">
                                            <?php if (UserJob::canView()):?>
                                                <span><?=$userJob->agent_company_name?></span>
                                            <?php else: ?>
                                                <a href="<?= UserJob::getUpgradeUrl() ?>">Upgrade here to view this information </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Position/Dept.</td>
                                        <td colspan="2">
                                            <?php if (UserJob::canView()):?>
                                                <span><?=$userJob->agent_position?></span>
                                            <?php else: ?>
                                                <a href="<?= UserJob::getUpgradeUrl() ?>">Upgrade here to view this information </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Industry Coverage</td>
                                        <td colspan="2">
                                            <?= Html::encode($userJob->getJobIndustryCoverageTitle()); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td colspan="2"><?=Html::encode(app\modules\job\models\JobLocation::findOne(['_id' => $userJob->agent_office_location])->title)?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sidebar">
                            <?= $this->render('_sidebar') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->
<?php ActiveForm::end(); ?>