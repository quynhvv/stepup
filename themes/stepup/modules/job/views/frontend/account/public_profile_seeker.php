<?php
use app\components\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([])?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-title section-title-style-1">
                <h2 class="title">
                    <?php
                       if (\app\modules\job\models\UserFavourite::isFavourite($user->_id, 'seeker', Yii::$app->user->id)){
                            $class = "favourites";
                            $title = Yii::t('job', 'Remove from favourites list?');
                        }
                        else {
                            $class = "un-favourites";
                            $title = Yii::t('job', 'Add to favourites list?');
                        }
                        echo Html::a('<i class="fa fa-star"></i>', ['account/favourite'], ['title' => $title, 'class' => $class, 'onclick'=> 'js:favourite($(this)); return false', 'data-id' => $user->_id, 'data-type' => 'seeker']);
                    ?>
                    <?= $this->title ?>
                </h2>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hovered table-striped" id="table-basic-infomation">
                            <tbody>
                            <tr>
                                <td colspan="2"><?= Html::img(\app\helpers\LetHelper::getFileUploaded($user->image), ['class' => 'media-object', 'width' => '100']) ?></td>
                            </tr>
                            <?php if (($latestEmployer = $user->userSeekerResume->getLatestEmployer()) != null) : ?>
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
                                <td><?= $user->userSeekerResume->getFunctionNames() ?></td>
                            </tr>
                            <tr>
                                <th><?= Yii::t('job', 'Industry Experience') ?></th>
                                <td><?= $user->userSeekerResume->getIndustryNames() ?></td>
                            </tr>
                            <tr>
                                <th><?= Yii::t('job', 'Work Experience') ?></th>
                                <td><?= Html::encode($user->userSeekerResume->experience) ?>&nbsp;Years</td>
                            </tr>
                            <tr>
                                <th><?= Yii::t('job', 'Current Location') ?></th>
                                <td><?= Html::encode($user->userSeekerResume->getLocationTitle()) ?></td>
                            </tr>
                            <tr>
                                <th>
                                    <?= Yii::t('job', 'Education') ?>
                                    <br>
                                    <span><?= Yii::t('job', 'Please input your most recent School Name and Field of Study.') ?></span>
                                </th>
                                <td>
                                    <?= Html::encode($user->userSeekerResume->education_name) ?>
                                    <br>
                                    <?= Html::encode($user->userSeekerResume->education_study) ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?= Yii::t('job', 'Language Ability') ?></th>
                                <td>
                                    <?php
                                    if (is_array($user->userSeekerResume->language_ability)) {
                                        foreach ($user->userSeekerResume->language_ability as $lang) {
                                            if ($lang['language'] != '') {
                                                echo $user->userSeekerResume->getLanguageText($lang['language']) . '<br>';
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?= Yii::t('job', 'Contact Number') ?></th>
                                <td><?= Html::encode($user->userSeekerResume->phone_number) ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->
<?php ActiveForm::end(); ?>