<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\GridView;
use app\helpers\ArrayHelper;

$role = Yii::$app->request->get('role');
$auth = Yii::$app->authManager; 
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <ul class="nav nav-tabs m-b-lg">
        <li role="presentation"><a href="<?= Url::to(['/account/default']) ?>"><?= Yii::t('account', 'User') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/role']) ?>"><?= Yii::t('account', 'Role') ?></a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['/account/rbac/permission']) ?>"><?= Yii::t('account', 'Permission') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/actionlist']) ?>"><?= Yii::t('account', 'Action list') ?></a></li>
    </ul>
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <div id="msg" style="display: none;" class="alert alert-dismissable"></div>
            <?php
            if (!empty($role)) {
                echo Html::buttonInput(Yii::t('common', 'Save'), [
                    'class' => 'btn btn-primary m-r-md',
                    'onclick' => 'addPermissionFromRole();',
                ]);
            }
            
            echo Html::dropDownList('choseRole', $role, ArrayHelper::map($auth->getRoles(), 'name', 'description'), ['prompt' => Yii::t('account', 'Select a role'), 'class' => 'chosen-select', 'id' => 'role', 'onchange' => 'changeUrlPermission()']) ?>
        </div>
    </div>
    <div id="message"></div>

    <?php
    if (!empty($role)):
        echo Html::hiddenInput('allPermission', implode(',', \app\helpers\ArrayHelper::map($dataProvider->getModels(), '_id', 'name')), [
            'id' => 'allPermission',
        ]);
        echo GridView::widget([
            'panel' => [
                'heading' => Yii::t(Yii::$app->controller->module->id, 'Account'),
                // 'after' => '{export}',
                'tableOptions' => [
                    'id' => 'listDefault',
                ],
            ],
//            'pjax' => TRUE,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'app\modules\account\components\SelectPermissionForRoleColumn',
                ],
                'name',
                'description',
                'rule_name',
            ],
            'responsive' => true,
            'hover' => true,
        ]);
    endif;
    ?>


</div>
<script type="text/javascript">
    function addPermissionFromRole() {
        var ids = $('input[name="selection[]"]:checked').serialize();
        var choseRole = $('#role option:selected').val();
        var allpermission = $('#allPermission').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?= Url::to(['ajax/addpermission']) ?>?" + ids + '&role=<?= Yii::$app->request->get('role', '') ?>',
            data: {choseRole: choseRole, allpermission: allpermission},
        }).done(function (msg) {
            console.log(msg);
            $('#msg').removeClass('alert-danger');
            $('#msg').removeClass('alert-success');
            if (msg.status == 0) {
                $('#msg').show();
                $('#msg').addClass('alert-danger');
                $('#msg').text(msg.msg);
            } else if (msg.status == 1) {
                $('#msg').show();
                $('#msg').addClass('alert-success');
                $('#msg').text(msg.msg);
            }
        });
    }

    function changeUrlPermission() {
        var choseRole = $('#role option:selected').val();
        window.location.href = '<?= Url::to(['rbac/permission']) ?>?role=' + choseRole;
    }
</script>