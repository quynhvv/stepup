<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use kartik\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= $this->theme->baseUrl ?>/assets/images/favicon.ico" type="image/x-icon" />	
    <?= Html::csrfMetaTags() ?>
    
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?= $this->theme->baseUrl ?>/assets/vendors/html5/html5shiv.min.js"></script>
    <script type="text/javascript" src="<?= $this->theme->baseUrl ?>/assets/vendors/html5/html5shiv-printshiv.min.js"></script>
    <script type="text/javascript" src="<?= $this->theme->baseUrl ?>/assets/vendors/html5/respond.min.js"></script>
    <![endif]-->
    
    <?php
    $this->registerCssFile(Yii::getAlias('@web') . '/vendor/components/font-awesome/css/font-awesome.css', ['depends' => \yii\bootstrap\BootstrapPluginAsset::className()]);
    $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/pushy/css/pushy.css', ['depends' => \yii\bootstrap\BootstrapPluginAsset::className()]);
    $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/font-elegant/style.css', ['depends' => \yii\bootstrap\BootstrapPluginAsset::className()]);
    $this->registerCssFile($this->theme->baseUrl . '/assets/css/styles.css', ['depends' => \yii\bootstrap\BootstrapPluginAsset::className()]);
    
    //custom css
    $this->registerCssFile($this->theme->baseUrl . '/assets/css/custom.css', ['depends' => \yii\bootstrap\BootstrapPluginAsset::className()]);
    
    $this->registerJsFile($this->theme->baseUrl . '/assets/vendors/jquery/jquery-migrate-1.2.1.min.js', ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJsFile($this->theme->baseUrl . '/assets/vendors/jquery/jquery.easing.1.3.js', ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJsFile($this->theme->baseUrl . '/assets/js/sticky-nav.js', ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJsFile($this->theme->baseUrl . '/assets/js/scroll-top.js', ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJsFile($this->theme->baseUrl . '/assets/vendors/pushy/js/pushy.min.js', ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJsFile($this->theme->baseUrl . '/assets/js/testimonial-carousel.js', ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJsFile($this->theme->baseUrl . '/assets/js/theme.js', ['depends' => \yii\web\JqueryAsset::className()]);
    ?>
    <?php $this->head(); ?>
</head>
<body class="logged_in home-page">
    <?php $this->beginBody() ?>
    
<div class="wrapper">
    <div class="page" id="container">
        <!-- TOP TOOLBAR -->
        <div id="top-toolbar" class="top-toolbar-container toolbar-dark">
            <div class="top-toolbar">
                <span class="visible-xs top-toolbar-trigger">
                    <i class="icon_close_alt2 fa-2x"></i>
                </span>
                <div class="main-top-toolbar">
                    <div class="container">
                        <div class="main-top-toolbar-inner">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="block block-login">
                                        <div class="block-content">
                                        <?php if (!Yii::$app->user->isGuest) : ?>
                                            <h4 class="welcome">Welcome <?= Html::encode(Yii::$app->user->identity->email) ?></h4>
                                            <div class="media author">
                                                <div class="media-left text-center">
                                                    <a href="#">
                                                        <?= Html::img(\app\helpers\LetHelper::getFileUploaded(Yii::$app->user->identity->image), ['class' => 'media-object', 'width' => '64', 'height' => '64']) ?>
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <p class="media-heading">Logged in as <strong><?= Html::encode(Yii::$app->user->identity->email) ?></strong></p>
                                                    <ul class="list-inline list-separator">
                                                        <li><a href="<?= \app\modules\job\models\UserJob::getDashboardUrl() ?>">Dashboard</a></li>
                                                        <li><a href="<?= \app\modules\job\models\UserJob::getProfileUrl() ?>">Profile</a></li>
                                                        <li><a href="<?= Url::to(['/account/default/logout']) ?>">Logout</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div>
                                                <?php
                                                $model = new \app\modules\account\models\User();
                                                $model->scenario = 'login';
                                                $form = ActiveForm::begin(['action' => ['/job/account/login']]);
                                                ?>
                                                <?= $form->field($model, 'email')->textInput() ?>
                                                <?= $form->field($model, 'password')->passwordInput() ?>
                                                <div class="form-group">
                                                    <?= Html::submitButton(Yii::t('account', 'Sign in'), ['class' => 'button button-primary']) ?>
                                                </div>
                                                <div class="form-group">
                                                    <p><?= Html::a(Yii::t('account', 'Sign up'), ['/job/account/register']) ?></p>
                                                    <p><?= Html::a(Yii::t('account', 'Forgot your password?'), ['/account/auth/passwordrequest']) ?></p>
                                                </div>
                                                <?php ActiveForm::end(); ?>

                                                <?php /*
                                                <form method="post" action="#" id="loginform" name="loginform">
                                                    <div class="form-group">
                                                        <label for="user_login">Username</label>
                                                        <input type="email" class="form-control" id="user_login" placeholder="Username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="user_pass">Password</label>
                                                        <input type="password" class="form-control" id="user_pass" placeholder="Password">
                                                    </div>
                                                    <button type="submit" class="button button-primary" id="user_submit">Log In</button>
                                                </form>
                                                */ ?>
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="block block-text">
                                        <div class="block-content">
                                            <p class="text-big">We reply on all questions within</p>
                                            <span class="text-special three-dots dots-bottom">24 h</span>
                                            <p class="text-center">
                                                <span class="text-gray">Email and Skype support for our clients</span><br/>
                                                <b><i class="icon_clock_alt"></i> Mon - Fri 8:00am - 6:00pm <span class="css-tooltip" data-tooltip="we are located in Asia">(GMT +8)</span></b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="block block-text block-contact">
                                        <div class="block-content">
                                            <h5><i class="icon_mail_alt"></i> Our address:</h5>
                                            <p>
                                                <strong>Stepup Careers</strong><br>
                                                Room 747, 7/F Star House,<br>
                                                3 Salisbury Road, TST, Hong Kong</p>
                                            <h5><i class="icon_phone"></i> Have any questions?</h5>
                                            <p><a href="mailto:info@stepupcareers.com">info@stepupcareers.com</a></p>
                                            <h5><i class="icon_comment_alt"></i> Call us:</h5>
                                            <p><a href="#">+852 9161 8423</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="block block-text">
                                        <div class="block-content">
                                            <h6>Version 0.6 - Jul 17, 2014</h6>
                                            <ul class="list-disc">
                                                <li>Added: 3 New Header Styles</li>
                                                <li>Added: Secondary Header Menu for Stack Header Style</li>
                                                <li>Fixed: DB code cleanup</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="top-toolbar-toggle top-toolbar-trigger">
                    <i class="arrow_carrot-down"></i>
                </span>
            </div>
        </div>
        <!-- # TOP TOOLBAR -->

        <!-- HEADER -->
        <header id="header" class="header-container header-style-image">
            <div class="main-header">
                <div class="container">
                    <div class="main-header-inner">
                        <div class="logo">
                            <h1>
                                <a href="<?= Yii::$app->homeUrl ?>">
                                    <img src="<?= $this->theme->baseUrl ?>/images/logo/logo.png" class="thumbnail-img" alt="logo"/>
                                </a>
                            </h1>
                        </div>
                        <?php echo app\modules\common\widgets\frontend\Navigation::widget(['position' => 'top']); ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- # HEADER -->
        
        <!-- BREADCRUMB -->
        <div id="breadcrumb" class="breadcrumb-container">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <h1 class="title"><?= Yii::$app->view->title ?></h1>
                    </div>
                    <div class="main-breadcrumb">
                        <?php echo Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- # BREADCRUMB -->
        
        <!--//Get all flash messages and loop through them-->
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
        
        <?= $content; ?>

        <!-- FOOTER -->
        <footer id="footer" class="footer-container">
            <div class="main-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="block block-text">
                                <div class="block-content">
                                    <p>
                                        <a href="<?= Yii::$app->homeUrl ?>">
                                            <img src="<?= $this->theme->baseUrl ?>/images/logo/logo_footer1.png" class="thumbnail-img" alt="footer logo"/>
                                        </a>
                                    </p>
                                    <p class="text-big">We love who we are and we are very proud to be the part of your business</p>
                                    <p>Stepup Careers is a leading jobs, employment and recruitment website, providing job vacancies, interview skills and tips.</p>
                                    <div class="block block-social">
                                        <div class="block-content">
                                            <ul class="list-inline">
                                                <li><a href="#" class="btn-social facebook"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="#" class="btn-social google-plus"><i class="fa fa-google-plus"></i></a></li>
                                                <li><a href="#" class="btn-social twitter"><i class="fa fa-twitter"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="block block-recent-comment">
                                <div class="block-content">
                                    <ul>
                                        <li>
                                            <span class="date_label">July 22, 2014</span>
                                            <p>
                                                <i class="fa fa-user"></i>
                                                <strong>admin</strong> commented on <a title="Announce news here" href="post.html">Announce news here.</a>
                                            </p>
                                        </li>
                                        <li>
                                            <span class="date_label">July 22, 2014</span>
                                            <p>
                                                <i class="fa fa-user"></i>
                                                <strong>admin</strong> commented on <a title="First post" href="post.html">First post</a>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="block block-recent-post">
                                <div class="block-content">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <div class="post-item">
                                                    <span class="photo-number">1</span>
                                                    <h6 class="post-title">Announce news here.</h6>
                                                    <span class="date"><i class="icon_clock_alt"></i>July 22, 2014</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="post-item">
                                                    <span class="photo-number">1</span>
                                                    <h6 class="post-title">First post</h6>
                                                    <span class="date"><i class="icon_clock_alt"></i>July 22, 2014</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="post-item">
                                                    <span class="photo-number">0</span>
                                                    <h6 class="post-title">Hello world !</h6>
                                                    <span class="date"><i class="icon_clock_alt"></i>July 22, 2014</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="block block-list">
                                <div class="block-content">
                                    <?php echo app\modules\common\widgets\frontend\Navigation::widget(['position' => 'bottom']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <address class="copyright">
                                &copy; 2015 StepUp Careers. All Rights Reserved. <a href="index.html" rel="nofollow" target="_blank">StepUp Careers</a>
                            </address>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <div class="block block-social">
                                <div class="block-content">
                                    <ul class="list-inline">
                                        <li><a href="#" class="link-social"><i class="fa fa-skype"></i></a></li>
                                        <li><a href="#" class="link-social"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="link-social"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#" class="link-social"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="link-social"><i class="fa fa-instagram"></i></a></li>
                                        <li><a href="#" class="link-social"><i class="fa fa-pinterest"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <span class="button scroll-to-top"><i class="arrow_carrot-up"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- # FOOTER -->
    </div>
    
    <!-- MOBILE MENU -->
    <nav class="pushy pushy-left">
        <ul class="mobile-menu">
            <li class="active">
                <a href="index.html">Home</a>
            </li>
            <li>
                <a href="about.html">About</a>
            </li>
            <li>
                <a href="blog.html">Blog</a>
            </li>
            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </nav>
    <div class="site-overlay"></div>
    <!-- # MOBILE MENU -->
</div>
        
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>