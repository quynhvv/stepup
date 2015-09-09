<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-inner">
                <div class="section-content layout-1col">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-main section-gap section-resume">
                            <ul class="nav nav-tabs nav-justified" id="nav-resume">
                                <li>
                                    <span>Resume</span>
                                </li>
                                <li role="presentation" class="active">
                                    <a role="button" href="<?= Url::to(['information']) ?>"><?= Yii::t('job' ,'1: Basic Information') ?></a>
                                </li>
                                <li role="presentation">
                                    <a role="button" href="#"><?= Yii::t('job' ,'2: Free Format Resume') ?></a>
                                </li>
<!--                                <li role="presentation">
                                    <a role="button" href="#"><?= Yii::t('job' ,'3: Job preferences') ?></a>
                                </li>-->
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hovered table-striped" id="table-basic-infomation">
                                            <tbody>
                                            <?php if (($latestEmployer = $model->getLatestEmployer()) != null) : ?>
                                            <tr>
                                                <th><?= Yii::t('job', 'Latest Employer') ?></th>
                                                <td><?= Html::encode($latestEmployer->company_name) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('job', 'Period of Employment') ?></th>
                                                <td>
                                                    <?= Html::encode($latestEmployer->belong_month_from . '/' . $latestEmployer->belong_year_from) ?>
                                                    -
                                                    <?= Html::encode($latestEmployer->belong_month_to . '/' . $latestEmployer->belong_year_to) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('job', 'Position/Title') ?></th>
                                                <td><?= Html::encode($latestEmployer->position) ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <th><?= Yii::t('job', 'Job Function') ?></th>
                                                <td><?= $model->getFunctionNames() ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('job', 'Industry Experience') ?></th>
                                                <td><?= $model->getIndustryNames() ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('job', 'Work Experience') ?></th>
                                                <td><?= Html::encode($model->experience) ?>&nbsp;Years</td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('job', 'Current Location') ?></th>
                                                <td><?= Html::encode($model->getLocationTitle()) ?></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <?= Yii::t('job', 'Education') ?>
                                                    <br>
                                                    <span><?= Yii::t('job', 'Please input your most recent School Name and Field of Study.') ?></span>
                                                </th>
                                                <td>
                                                    <?= Html::encode($model->education_name) ?>
                                                    <br>
                                                    <?= Html::encode($model->education_study) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('job', 'Language Ability') ?></th>
                                                <td>
                                                    <?php
                                                    if (is_array($model->language_ability)) {
                                                        foreach ($model->language_ability as $lang) {
                                                            if ($lang['language'] != '') {
                                                                echo $model->getLanguageText($lang['language']) . '<br>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('job', 'Contact Number') ?></th>
                                                <td><?= Html::encode($model->phone_number) ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="actions">
                                <?= Html::a(Yii::t('common', 'Edit'), ['resume'], ['class' => 'button button-lg button-long']) ?>
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