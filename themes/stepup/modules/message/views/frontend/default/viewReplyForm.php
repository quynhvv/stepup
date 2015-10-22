<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

use app\modules\job\helpers\ImageHelper;
?>

<?php $form = ActiveForm::begin([
    'id' => 'message-form'
]); ?>
<div class="media">
    <a href="<?= Url::to(['/job/frontend/account/public-profile', 'display_name' => Yii::$app->user->identity->display_name]) ?>" class="pull-left">
        <?= ImageHelper::getAvatar(Yii::$app->user->id, ImageHelper::IMAGE, false, 48, ['class' => 'media-object']) ?>
    </a>
    <div class="media-body">
        <?= $form->field($modelReply, 'content')->widget(letyii\tinymce\Tinymce::className(), [
            'options' => [
                'style' => 'height: 400px;',
            ],
            'configs' => [
                'setup' => new \yii\web\JsExpression('function(editor) { editor.on("change", function() { tinymce.triggerSave(); }); }'),
                'height' => 150,
                'plugins' => 'moxiemanager advlist autolink lists link image charmap print preview hr anchor pagebreak '
                    . 'searchreplace wordcount visualblocks visualchars code fullscreen '
                    . 'insertdatetime media nonbreaking save table contextmenu directionality '
                    . 'emoticons template paste textcolor colorpicker textpattern',
                'toolbar1' => 'insertfile undo redo | styleselect | fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                'toolbar2' => 'print preview media | forecolor backcolor emoticons',
                'moxiemanager_image_settings' => [
                    'moxiemanager_title' => 'Images',
                    'moxiemanager_extensions' => 'jpg,png,gif',
                    'moxiemanager_rootpath' => '/uploads/files',
                    'moxiemanager_view' => 'thumbs',
                ],
                'external_plugins' => [
                    'moxiemanager' => Url::base() . '/plugins/moxiemanager/plugin.min.js'
                ],
            ],
        ])->label(false); ?>
    </div>
</div>

<button id="message-form-submit" type="submit" class="button button-primary button-lg"><?= Yii::t('common', 'Send') ?></button>

<?php ActiveForm::end(); ?>

