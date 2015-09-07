<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use app\components\ActiveForm;
use app\components\SwitchInput;
use app\components\FieldRange;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$buttons = Html::button(Yii::t('common', 'Apply'), [
    'class' => 'btn btn-success',
    'onclick' => '$("input[name=save_type]").val("apply"); $("#formDefault").submit();',
]);
$buttons .= Html::button(Yii::t('common', 'Save'), [
    'class' => 'btn btn-success',
    'onclick' => '$("#formDefault").submit();',
]);
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-sm">
        <div class="col-lg-12">
            <?php if (!empty($message)): ?>
            <div id="msg" class="alert alert-dismissable alert-danger"><?= $message ?></div>
            <?php endif; ?>
            <div class="btn-group pull-right">
                <?= $buttons; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Yii::t('common', 'Edit avatar') ?></h5>
                </div>
                <div class="ibox-content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'formDefault',
                        'options' => ['enctype' => 'multipart/form-data'],
                    ]);
                    echo Html::hiddenInput('submit', 1);
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="image-crop">
                                <img src="<?= app\helpers\LetHelper::getAvatar(Yii::$app->user->id, LetHelper::URL, true, 48) . '?time=' . time() ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Preview image</h4>
                            <div class="img-preview img-preview-sm"></div>
                            <h4>Comon method</h4>
                            <p>
                                You can upload new image to crop container and easy download new cropped image.
                            </p>
                            <input class="avatar-data" name="data" type="hidden">
                            <div class="btn-group">
                                <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                    <input type="file" accept="image/*" name="User[avatar]" id="inputImage" class="hide">
                                    <?= Yii::t('yii', 'Please upload a file.'); ?>
                                </label>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-white" id="zoomIn" type="button">Zoom In</button>
                                <button class="btn btn-white" id="zoomOut" type="button">Zoom Out</button>
                                <button class="btn btn-white" id="rotateLeft" type="button">Rotate Left</button>
                                <button class="btn btn-white" id="rotateRight" type="button">Rotate Right</button>
                                <button class="btn btn-warning" id="setDrag" type="submit">New crop</button>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Image cropper -->
<?php
$this->registerJsFile($this->theme->baseUrl . '/js/plugins/cropper/cropper.min.js', ['depends' => app\assetbundle\BackendAsset::className(), 'position' => yii\web\View::POS_END]);
$this->registerJs('
    var $image = $(".image-crop > img")
    $($image).cropper({
        aspectRatio: 1 / 1,
        preview: ".img-preview",
        crop: function(data) {
            var json = [
                  \'{"x":\' + Math.round(data.x),
                  \'"y":\' + Math.round(data.y),
                  \'"height":\' + Math.round(data.height),
                  \'"width":\' + Math.round(data.width),
                  \'"rotate":\' + Math.round(data.rotate) + \'}\'
                ].join();
            $(".avatar-data").val(json);
        }
    });

    var $inputImage = $("#inputImage");
    if (window.FileReader) {
        $inputImage.change(function() {
            var fileReader = new FileReader(),
                    files = this.files,
                    file;

            if (!files.length) {
                return;
            }

            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $image.cropper("reset", true).cropper("replace", this.result);
                };
            } else {
                showMessage("Please choose an image file.");
            }
        });
    } else {
        $inputImage.addClass("hide");
    }

    $("#download").click(function() {
        window.open($image.cropper("getDataURL"));
    });

    $("#zoomIn").click(function() {
        $image.cropper("zoom", 0.1);
    });

    $("#zoomOut").click(function() {
        $image.cropper("zoom", -0.1);
    });

    $("#rotateLeft").click(function() {
        $image.cropper("rotate", 45);
    });

    $("#rotateRight").click(function() {
        $image.cropper("rotate", -45);
    });
', yii\web\View::POS_END);
?>