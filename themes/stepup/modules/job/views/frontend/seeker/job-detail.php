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
                <div class="section-content layout-2cols-right">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-main section-gap">
                            <div class="table-responsive">
                                <table id="jobdetail" class="table table-bordered table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <th colspan="2">New job post</th>
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
                                        <td>US$3000 to US$5000</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Job Title</td>
                                        <td><?= Html::encode($model->title) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Location</td>
                                        <td>Sydney Australia</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Jobs Industry</td>
                                        <td>Real Estate, Property Management </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Company Info</td>
                                        <td>
                                            <a href="<?= Url::to(['pricing']) ?>">Upgrade here to view this information</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">Job Description</td>
                                        <td>
                                            <?= $model->description ?>
                                            <br><strong><a href="<?= Url::to(['pricing']) ?>">... Want to know more? Upgrade to Premium!</a></strong> </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" colspan="3">
                                            <a href="#" class="button button-lg button-secondary button-long">
                                                <span>Upgrade to Apply</span>
                                            </a>
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
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-uppercase">Posted by this approved recruiter</span>
                                        </td>
                                        <td><a href="#">View All Jobs</a></td>
                                        <td colspan="2"><a href="#">View Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="5"><img width="100" height="100" class="avatar avatar-100 photo" src="" alt=""></td>
                                        <td>Recruiter Name</td>
                                        <td colspan="2">
                                            <a href="<?= Url::to(['pricing']) ?>">Upgrade here to view this information </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Company</td>
                                        <td colspan="2">
                                            <a href="<?= Url::to(['pricing']) ?>">Upgrade here to view this information </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Position/Dept.</td>
                                        <td colspan="2">
                                            <a href="<?= Url::to(['pricing']) ?>">Upgrade here to view this information </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Industry Coverage</td>
                                        <td colspan="2">
                                            Business Services, Consumer Goods, Food, Clothing, Electronics, Semiconductor, Automotive
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td colspan="2">Sydney Australia</td>
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