<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use app\components\ActiveForm;
use app\assetbundle\BackendAsset;

$currentModule = Yii::$app->request->get('module');
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <?php if (!empty($currentModule)): ?>
                <button type="button" class="btn btn-primary" onclick="$('#formDefault #category-name').attr('data-name', null); " data-toggle="modal" data-target="#formDefault">
                    <?= Yii::t('common', 'Create') ?>
                </button>
                <button type="button" onclick="saveChanges();" id="saveChanges" class="btn btn-success"><?= Yii::t('common', 'Save Changes') ?></button>
            <?php else: ?>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><?= $currentModule ? Yii::t('common', 'You are choosing') . ' module ' . $currentModule : Yii::t('common', 'Choose module') ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <?php foreach ($modules as $module): ?>
                            <li><a href="<?= Url::to(['/category/default', 'module' => $module]) ?>"><?= $module ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($currentModule)): ?>
                <div class="btn-group pull-right nestable-menu">
                    <button type="button" data-action="expand-all" class="btn btn-white"><?= Yii::t('common', 'Expand All') ?></button>
                    <button type="button" data-action="collapse-all" class="btn btn-white"><?= Yii::t('common', 'Collapse All') ?></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($currentModule)): ?>
        <!-- Modal -->
        <div class="modal inmodal fade" id="formDefault" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated flipInX">
                    <div class="modal-body">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'formDefault',
                            'layout' => 'horizontal',
                            'options' => ['enctype' => 'multipart/form-data'],
                            'fieldConfig' => [
                                'horizontalCssClasses' => [
                                    'label' => 'col-sm-2',
                                    'wrapper' => 'col-sm-10',
                                    'error' => 'help-block m-b-none',
                                    'hint' => '',
                                ],
                            ],
                        ]);
                        echo $form->field($model, 'name')->textInput();
                        ActiveForm::end();
                        ?>
<!--                        <div class="form-group"><label>Tên danh mục</label> 
                            <input type="text" data-name="" id="category-name" name="category-name" placeholder="Nhập tên danh mục" class="form-control"/>
                        </div>-->
                    </div>
                    <div class="modal-footer">
                        <input type="button" onclick="updateCategory()" value="<?= Yii::t('common', 'Save') ?>" class="btn btn-primary"/>
                        <button type="button" class="btn btn-white" data-dismiss="modal"><?= Yii::t('common', 'Cancel') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!--<div id="updateRole"></div>-->
    <?php endif; ?>
    <!-- END Modal -->

    <?php if (!empty($currentModule)): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><?= Yii::t('category', 'Category') ?></h5>
                    </div>
                    <div class="ibox-content">
                        <input type="hidden" id="data_list_category" />
                        <!--<p class="m-b-lg"> Each list you can customize by standard css styles. Each element is responsive so you can add to it any other element to improve functionality of list. </p>-->
                        <?= $tree; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<script type="text/javascript">


</script>

<?php
$this->registerCssFile($this->theme->baseUrl . '/css/plugins/sweetalert/sweetalert.css', ['depends' => BackendAsset::className()]);
$this->registerJsFile($this->theme->baseUrl . '/js/plugins/sweetalert/sweetalert.min.js', ['depends' => BackendAsset::className()]);
$this->registerJs("
    $('#saveChanges').hide();
    var updateOutputCategory = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            $('#data_list_category').val(window.JSON.stringify(list.nestable('serialize')));
            $('#saveChanges').show();
        } else {
            console.log('JSON browser support required for this demo.');
        }
    };

    $('#nestable_category').nestable({
        group: 1
    }).on('change', updateOutputCategory);
", yii\web\View::POS_READY);

$this->registerJs("
    function createCategory(name) {
        // Tạo form update
        $('#formDefault').modal('show');
//        $('#formDefault #category-name').val($('.dd-item[data-id=' + name + '] .dd-handle:first').text().trim());
        $('#formDefault #category-name').attr('data-name', name);
    }

    function updateCategory() {
        var id = $('#formDefault #category-name').attr('data-name');
        var name = $('#formDefault #category-name').val();
        var module = '".Yii::$app->request->get('module')."';
        $.ajax({
            url: '".Url::to(['/category/ajax/updatecategory'])."',
            type: 'post',
            dataType: 'json',
            data: {id: id, name: name, module: module},
        }).done(function (msg) {
            $('#formDefault #roleDescription').attr('data-name', '');
            var stringItem = '<li class=\"dd-item\" data-id=\"' + msg.id + '\"><div class=\"btn-group pull-right\">' +
                '<span class=\"btn btn-success btn-xs\" onclick=\"createCategory(\'' + msg.id + '\')\"><i class=\"glyphicon glyphicon-plus\"></i></span>' +
                '<a class=\"btn btn-info btn-xs\" href=\"" . Url::to(['/category/backend/default/update']) . "?id=' + msg.id + '\"><i class=\"glyphicon glyphicon-pencil\"></i></a>' +
                '<span class=\"btn btn-danger btn-xs\" onclick=\"deleteCategory(\'' + msg.id + '\')\"><i class=\"glyphicon glyphicon-trash\"></i></span>' +
                '</div><div class=\"dd-handle\">' + msg.name + '</div></li>';
            if (msg.status == 2) {
                if (jQuery.isEmptyObject(id)) {
                    $('.dd-list:first').append(stringItem);
                } else {
                    if ($('.dd-item[data-id=\"' + id + '\"] ul.dd-list').html()) {
                        $('.dd-item[data-id=\"' + id + '\"] ul.dd-list:first').append(stringItem);
                    } else {
                        $('.dd-item[data-id=\"' + id + '\"]').append('<ul class=\"dd-list\">' + stringItem + '</ul>');
                    }
                }
            } else if (msg.status == 3) {
                $('.ibox-content').html('<div id=\"nestable\" class=\"dd\"><ul class=\"dd-list\">' + stringItem + '</ul></div>');
            }

            if (msg.status == 0) {
                $('#msg').show();
                $('#msg').addClass('alert-danger');
                $('#msg').text(msg.message);
                $('#formDefault').modal('hide');
            } else {
//                $('#msg').show();
//                $('#msg').addClass('alert-success');
//                $('#msg').text(msg.message);
                $('#formDefault').modal('hide');
            }
            $('#formDefault #category-name').val('');
        });
    }

    function deleteCategory(id) {
        if (confirm('".Yii::t('yii', 'Are you sure you want to delete this item?')."')) {
            $.ajax({
                url: '".Url::to(['/category/ajax/deletecategory'])."',
                type: 'post',
                dataType: 'json',
                data: {id: id},
            }).done(function (msg) {
                $('.dd-item[data-id=\"' + id + '\"] ul.dd-list').remove();
                $('.dd-item[data-id=\"' + id + '\"]').remove();
            });
        }
        else {
            return false;
        }
    }

    function changeUrlModule() {
        var choseModule = $('#module option:selected').val();
        window.location.href = '".Url::to(['default'])."?module=' + choseModule;
    }
    
    function saveChanges(){
        var data = $('#data_list_category').val();
        var module = '" . Yii::$app->request->get('module') . "';
        $.ajax({
            url: '".Url::to(['/category/ajax/updatelist'])."',
            type: 'post',
            dataType: 'json',
            data: {data: data, module: module},
        }).done(function (msg) {
            $('#saveChanges').hide();
            swal({
                title: '".Yii::t('common', 'Good job!')."',
                text: '".Yii::t('common', 'Your changes have been saved!')."',
                type: 'success'
            });
        });
    }
", yii\web\View::POS_END);
?>