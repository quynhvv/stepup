<?php
use app\components\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
?>

<!-- MAIN -->
<main id="main" class="main-container">
    <!-- SECTION 1 -->
    <div class="section section-1">
        <div class="container">
            <div class="section-title section-title-style-1">
                <?= app\modules\account\widgets\frontend\Login::widget(); ?>
                <h2 class="title">Recruiter Registration Form (it only takes a minute)</h2>
                <h5 class="subtitle">
                    This page is for Recruiters only.<br>
                    For jobseekers wishing to login. <a href="<?= \yii\helpers\Url::to(['/account/auth/loginjob']) ?>" title="Login">Login</a>
                </h5>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8">
                    <?php /*
                    <div class="section-title section-title-style-2">
                        <?= app\modules\account\widgets\frontend\Login::widget(); ?>
                        <h2 class="title">SIGN UP (Free)</h2>
                        <h5 class="subtitle">STEPUP Requires User Membership - Sign Up Now! (Free)</h5>
                    </div>
                    */ ?>

                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'formDefault',
                        'layout' => 'horizontal',
                        'options' => ['enctype' => 'multipart/form-data'],
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'label' => 'col-sm-3',
                                'wrapper' => 'col-sm-9',
                                'error' => 'help-block m-b-none',
                                'hint' => '',
                            ],
                        ],
                    ]);
                    ?>

                    <?php if ($jobModel->type == 'recruiter') : ?>
                        <?= $form->field($jobModel, 'recruiter_type')->inline(true)->radioList([
                            '1' => Yii::t('account', 'Recruiter'),
                            '2' => Yii::t('account', 'Hiring Manager '),
                        ]) ?>
                        <?= $form->field($model, 'first_name')->textInput() ?>
                        <?= $form->field($model, 'last_name')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_company_name')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_position')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_office_location')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_city_name')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_website')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'phone')->passwordInput() ?>
                        <?= $form->field($jobModel, 'recruiter_jobs_industry')->textInput() ?>
                        <?= $form->field($jobModel, 'recruiter_summary')->textarea() ?>
                        <?php
                        $imageConfig = [
                            'options' => ['accept' => 'uploads/*'],
                            'pluginOptions' => [
                                'previewFileType' => 'image',
                                'showCaption' => FALSE,
                                'showRemove' => TRUE,
                                'showUpload' => FALSE,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' => 'Select Photo',
                                'removeClass' => 'btn btn-danger',
                                'removeLabel' => "Delete",
                                'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>',
                                'allowedFileExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
                            ],
                        ];
                        if (!empty($model->image)) {
                            $imageConfig['pluginOptions']['initialPreview'] = [Html::img(LetHelper::getFileUploaded($model->image), ['class' => 'file-preview-image'])];
                        }
                        echo $form->field($model, 'image')->widget(FileInput::classname(), $imageConfig);
                        ?>

                    <?php else : ?>

                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?php
                        $imageConfig = [
                            'options' => ['accept' => 'uploads/*'],
                            'pluginOptions' => [
                                'previewFileType' => 'image',
                                'showCaption' => FALSE,
                                'showRemove' => TRUE,
                                'showUpload' => FALSE,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' => 'Select Photo',
                                'removeClass' => 'btn btn-danger',
                                'removeLabel' => "Delete",
                                'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>',
                                'allowedFileExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
                            ],
                        ];
                        if (!empty($model->image))
                            $imageConfig['pluginOptions']['initialPreview'] = [Html::img(LetHelper::getFileUploaded($model->image), ['class' => 'file-preview-image'])];

                        echo $form->field($model, 'image')->widget(FileInput::classname(), $imageConfig);
                        ?>
                        <?= $form->field($extraModel, 'birthday')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATE
                        ]); ?>
                        <?= $form->field($extraModel, 'sex')->radioList([
                            '1' => Yii::t('account', 'Male'),
                            '2' => Yii::t('account', 'Female'),
                        ]) ?>
                        <?= $form->field($jobModel, 'seeker_nationality')->textInput() ?>
                        <?= $form->field($jobModel, 'seeker_salary')->textInput() ?>

                    <?php endif; ?>

<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label"><em class="required">*</em> Email address:</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><em class="required">*</em> Password:</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" placeholder="Must be 8-20 characters in length.">
                                <p>Your password must be between 8-20 alphanumeric characters</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Profile Picture:</label>
                            <div class="col-sm-9">
                                <input type="file" name="photo" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><em class="required">*</em> Gender:</label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" name="registration_jobseeker_gender" value="male"> Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="registration_jobseeker_gender" value="female"> Female
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><em class="required">*</em> Date of birth:</label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <select class="form-control" name="birth_month">
                                            <option value="1">Jan</option>
                                            <option value="2">Feb</option>
                                            <option value="3">Mar</option>
                                            <option value="4">Apr</option>
                                            <option value="5">May</option>
                                            <option value="6">Jun</option>
                                            <option value="7">Jul</option>
                                            <option value="8">Aug</option>
                                            <option value="9">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select class="form-control" name="birth_day">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select class="form-control" name="birth_year">
                                            <option value="">---</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                            <option value="1999">1999</option>
                                            <option value="1998">1998</option>
                                            <option value="1997">1997</option>
                                            <option value="1996">1996</option>
                                            <option value="1995">1995</option>
                                            <option value="1994">1994</option>
                                            <option value="1993">1993</option>
                                            <option value="1992">1992</option>
                                            <option value="1991">1991</option>
                                            <option value="1990">1990</option>
                                            <option value="1989">1989</option>
                                            <option value="1988">1988</option>
                                            <option value="1987">1987</option>
                                            <option value="1986">1986</option>
                                            <option value="1985">1985</option>
                                            <option value="1984">1984</option>
                                            <option value="1983">1983</option>
                                            <option value="1982">1982</option>
                                            <option value="1981">1981</option>
                                            <option value="1980">1980</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><em class="required">*</em> Nationality:</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="nationality">
                                    <option value="">---</option>
                                    <option value="us">US</option>
                                    <option value="uk">UK</option>
                                    <option value="europe">Europe</option>
                                    <option value="japan">Japan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><em class="required">*</em> Latest Annual Salary:</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="annualsalary">
                                    <option value="">In US Dollars</option>
                                    <option value="00">Less than US$40,000</option>
                                    <option value="40000">US$40,000,00</option>
                                    <option value="50000">US$50,000,00</option>
                                    <option value="60000">US$60,000,00</option>
                                    <option value="70000">US$70,000,00</option>
                                    <option value="80000">US$80,000,00</option>
                                    <option value="90000">US$90,000,00</option>
                                    <option value="100000">US$100,000,00</option>
                                </select>
                                <p>Please convert local currency to US Dollars.</p>
                            </div>
                        </div>-->

                        <div class="checkbox policy_check">
                            <label>
                                <input type="checkbox" name="accept_policy_checkbox">
                                I have read, understand, and I accept the <a href="#" target="_blank">terms of use</a> and <a href="#" target="_blank">privacy policy</a>.
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="button button-primary">Sign up</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- # SECTION 1 -->
</main>
<!-- # MAIN -->