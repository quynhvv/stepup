<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\GridView;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <ul class="nav nav-tabs m-b-lg">
        <li role="presentation"><a href="<?= Url::to(['/account/default']) ?>"><?= Yii::t('account', 'User') ?></a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['/account/rbac/role']) ?>"><?= Yii::t('account', 'Role') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/permission']) ?>"><?= Yii::t('account', 'Permission') ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['/account/rbac/actionlist']) ?>"><?= Yii::t('account', 'Action list') ?></a></li>
    </ul>
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formRole"><?= Yii::t('common', 'Create') ?></button>
            <div class="btn-group pull-right nestable-menu">
                <button type="button" data-action="expand-all" class="btn btn-white"><?= Yii::t('common', 'Expand All') ?></button>
                <button type="button" data-action="collapse-all" class="btn btn-white"><?= Yii::t('common', 'Collapse All') ?></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><?= Yii::t('account', 'Manage Roles') ?></h5>
                </div>
                <div class="ibox-content">
                    <p class="m-b-lg"><?= Yii::t('account', 'Drag and drop to rearrange the role trees. Parent role included all permission of children role.') ?></p>
                    <div class="dd" id="nestable">
                        <?= $treeHtml; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="formRole" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-body">
                <div id="msg" style="display: none;" class="alert alert-dismissable">
                </div>
                <div class="form-group"><label>Tên vai trò</label> 
                    <input type="text" data-name="" id="roleDescription" name="roleDescription" placeholder="Nhập trên vai trò" class="form-control"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                <input type="button" onclick="updateRole()" value="Lưu" class="btn btn-primary"/>
            </div>
        </div>
    </div>
</div>
<!--<div id="updateRole"></div>-->

<script type="text/javascript">
    function createRoleForm(name) {
        // Tạo form update.
        $('#formRole').modal('show');
        $('#formRole #roleDescription').val($('.dd-item[data-id=' + name + '] .dd-handle:first').text().trim());
        $('#formRole #roleDescription').attr('data-name', name);
    }

    function updateRole() {
        var name = $('#formRole #roleDescription').attr('data-name');
        var description = $('#formRole #roleDescription').val();
        $.ajax({
            url: '<?= Url::to(['/account/ajax/updaterole']) ?>',
            type: "post",
            dataType: "json",
            data: {name: name, description: description},
        }).done(function (msg) {
            $('#formRole #roleDescription').attr('data-name', '');
            if (msg.status != 2) {
                $('#formRole #roleDescription').val($('.dd-item[data-id=' + name + '] .dd-handle:first').text(description));
            } else {
                $('.dd-list').append('<li class="dd-item" data-id="' + msg.name + '"><div class="btn-group pull-right"><span class="btn btn-info btn-xs" onclick="window.location.href=\'<?= Url::to(['/account/rbac/permission']) ?>?role=' + msg.name + '\'"><i class="fa fa-plus-square-o"></i></span><span class="btn btn-info btn-xs" onclick="createRoleForm(\'' + msg.name + '\')"><i class="fa fa-pencil"></i></span><span class="btn btn-danger btn-xs" onclick="deleteRole(\'' + msg.name + '\')""><i class="fa fa-trash-o"></i></span></div><div class="dd-handle"> ' + description + '</div></li>');
            }
            if (msg.status == 0) {
                $('#msg').show();
                $('#msg').addClass('alert-danger');
                $('#msg').text(msg.message);
                $('#formRole').modal('hide');
            } else {
                $('#msg').show();
                $('#msg').addClass('alert-success');
                $('#msg').text(msg.message);
                $('#formRole').modal('hide');
            }
            $('#msg').hide(3000);
            $('#formRole #roleDescription').val('');
        });
    }

    function deleteRole(name) {
        if (confirm("Bạn có chắc chắn muốn xóa?")) {
            $.ajax({
                url: '<?= Url::to(['/account/ajax/deleterole']) ?>',
                type: "post",
                dataType: "json",
                data: {name: name},
            }).done(function (msg) {
                window.location = "<?= Url::to(['/account/rbac/role']) ?>";
            });
        }
        else {
            return false;
        }
    }
</script>