<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assetbundle\BackendAsset;
use kartik\icons\Icon;

BackendAsset::register($this);
Icon::map($this);
Icon::map($this, Icon::FA);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->title . ' | Administrator') ?></title>
        <?php
        // Css
        $this->registerCssFile($this->theme->baseUrl . '/css/plugins/iCheck/custom.css', ['depends' => BackendAsset::className()]);
//        $this->registerCssFile($this->theme->baseUrl . '/css/plugins/cropper/cropper.min.css', ['depends' => BackendAsset::className()]);
//        $this->registerCssFile($this->theme->baseUrl . '/css/plugins/cropper/main.css', ['depends' => BackendAsset::className()]);
        $this->registerCssFile($this->theme->baseUrl . '/css/animate.css', ['depends' => BackendAsset::className()]);
        $this->registerCssFile($this->theme->baseUrl . '/css/style.css', ['depends' => BackendAsset::className()]);
        $this->registerCssFile($this->theme->baseUrl . '/css/letyii.css', ['depends' => BackendAsset::className()]);

        // Javascript
        $this->registerJsFile($this->theme->baseUrl . '/js/plugins/metisMenu/jquery.metisMenu.js', ['depends' => BackendAsset::className()]);
        $this->registerJsFile($this->theme->baseUrl . '/js/plugins/slimscroll/jquery.slimscroll.min.js', ['depends' => BackendAsset::className()]);

        // iCheck
        $this->registerJsFile($this->theme->baseUrl . '/js/plugins/iCheck/icheck.min.js', ['depends' => BackendAsset::className()]);
        $this->registerJs("
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        ", yii\web\View::POS_READY);

        $this->head();

        echo Html::csrfMetaTags();
        ?>
        <link href="<?= $this->theme->baseUrl ?>/css/plugins/chosen/chosen.css" rel="stylesheet">
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <span>
                                    <a href="<?= Url::to(['/account/backend/default/editavatar']); ?>"><?= \app\helpers\LetHelper::getAvatar(Yii::$app->user->id, 'image', false, 48, ['class' => 'img-circle']) ?></a>
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> 
                                        <strong class="font-bold">
                                            <?= Yii::$app->user->identity->display_name ?>
                                        </strong>
                                    </span></span>
                                </a>
                            </div>
                            <div class="logo-element">
                                Letyii
                            </div>
                        </li>
                    </ul>
                    <?=
                    \app\components\BackendMenu::widget([
                        'options' => [
                            'id' => 'side-menu',
                            'class' => 'nav'
                        ],
                    ])
                    ?>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
<!--                            <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                                <div class="form-group">
                                    <input type="text" placeholder="Nhập từ khóa tìm kiếm..." class="form-control" name="top-search" id="top-search">
                                </div>-->
                            </form>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
<!--                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <li>
                                        <div class="dropdown-messages-box">
                                            <a href="profile.html" class="pull-left">
                                                <img alt="image" class="img-circle" src="<?= $this->theme->baseUrl ?>/img/a7.jpg">
                                            </a>
                                            <div class="media-body">
                                                <small class="pull-right">46h ago</small>
                                                <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="dropdown-messages-box">
                                            <a href="profile.html" class="pull-left">
                                                <img alt="image" class="img-circle" src="<?= $this->theme->baseUrl ?>/img/a4.jpg">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right text-navy">5h ago</small>
                                                <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="dropdown-messages-box">
                                            <a href="profile.html" class="pull-left">
                                                <img alt="image" class="img-circle" src="<?= $this->theme->baseUrl ?>/img/profile.jpg">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">23h ago</small>
                                                <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="text-center link-block">
                                            <a href="mailbox.html">
                                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                                </a>
                                <ul class="dropdown-menu dropdown-alerts">
                                    <li>
                                        <a href="mailbox.html">
                                            <div>
                                                <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                                <span class="pull-right text-muted small">4 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="profile.html">
                                            <div>
                                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                                <span class="pull-right text-muted small">12 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="grid_options.html">
                                            <div>
                                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                                <span class="pull-right text-muted small">4 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="text-center link-block">
                                            <a href="notifications.html">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>-->
                            <li>
                                <a href="<?= Url::to(['/account/auth/logout']); ?>">
                                    <i class="fa fa-sign-out"></i> <?= Yii::t('common', 'Logout') ?>
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-12">
                        <h2><?= $this->title ?></h2>
                        <?php echo Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]); ?>
                    </div>
                </div>
<?= $content; ?>
                <div class="footer">
                    <div>
                        <strong>Copyright</strong> Stepup Careers &copy; <?= date('Y') ?>
                    </div>
<!--                    <div class="pull-right">
                        10GB of <strong>250GB</strong> Free.
                    </div>-->
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
        <script type="text/javascript">
            function gridColumnBoolean(obj) {
                $.ajax({
                    url: obj.attr('href'),
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data.s === 1) {
                            $.pjax.reload({container: '#' + obj.parents('.grid-view').attr('id') + '-pjax', timeout: false});
                        }
                    }
                });
            }

            function addPermissionFromActionList() {
                var ids = $('input[name="selection[]"]:checked').serialize();
                console.log(ids);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "<?= Url::to(['ajax/createpermission']) ?>?" + ids,
                }).done(function (msg) {
                    if (!jQuery.isEmptyObject(msg.success)) {
                        $('#message').html(
                                '<div class="alert alert-success alert-dismissable">' +
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                                "<?= Yii::t(Yii::$app->controller->module->id, 'Add permissions success'); ?>" +
                                '</div>'
                                );
                    }

                    if (!jQuery.isEmptyObject(msg.error)) {
                        $('#message').html(
                                '<div class="alert alert-error alert-dismissable">' +
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                                "<?= Yii::t(Yii::$app->controller->module->id, 'Add permissions error'); ?>" +
                                '</div>'
                                );
                    }

                    if (!jQuery.isEmptyObject(msg.exist)) {
                        $('#message').html(
                                '<div class="alert alert-warning alert-dismissable">' +
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                                "<?= Yii::t(Yii::$app->controller->module->id, 'permissions exist'); ?>" +
                                '</div>'
                                );
                    }
                });
            }
        </script>
        <!-- Chosen -->
        <script src="<?= $this->theme->baseUrl ?>/js/plugins/chosen/chosen.jquery.js"></script>
        <!-- Nestable List -->
        <script src="<?= $this->theme->baseUrl ?>/js/plugins/nestable/jquery.nestable.js"></script>
        <script src="<?= $this->theme->baseUrl ?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?= $this->theme->baseUrl ?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="<?= $this->theme->baseUrl ?>/js/inspinia.js"></script>
        <script src="<?= $this->theme->baseUrl ?>/js/plugins/pace/pace.min.js"></script>
        <script>
            $('.chosen-select').chosen({});
            $(document).ready(function () {

                var updateOutput = function (e) {
                    var list = e.length ? e : $(e.target),
                            output = list.data('output');
                    console.log(window.JSON.stringify(list.nestable('serialize')));
                    if (window.JSON) {
//                        $.ajax({
//                            url: "<?= Url::to(['/account/rbac/updaterole']) ?>",
////                            dataType: "json",
//                            data: {listRoles: window.JSON.stringify(list.nestable('serialize'))}
//                        })
                    } else {
                        console.log('JSON browser support required for this demo.');
                    }
                };

                $('#nestable').nestable({
                    group: 1
                }).on('change', updateOutput);

                $('.nestable-menu').on('click', function (e) {
                    var target = $(e.target),
                            action = target.data('action');
                    if (action === 'expand-all') {
                        $('.dd').nestable('expandAll');
                    }
                    if (action === 'collapse-all') {
                        $('.dd').nestable('collapseAll');
                    }
                });
            });
            $("input[name='assign']").change(function () {
                if (this.checked) {
                    $.ajax({
                        url: "<?= Url::to(['ajax/addassign']); ?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            role: $(this).val(),
                            user_id: $('input[name="user_id"]').val(),
                        },
                    }).done(function (data) {
                    });
                } else {
                    $.ajax({
                        url: "<?= Url::to(['ajax/revokeassign']); ?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            role: $(this).val(),
                            user_id: $('input[name="user_id"]').val(),
                        },
                    }).done(function (data) {
                    });
                }
            });
        </script>
    </body>
</html>
<?php $this->endPage() ?>
