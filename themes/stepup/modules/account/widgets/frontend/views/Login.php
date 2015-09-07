<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="z-index: 2000;">
        <div class="modal-content user_modal">
            <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['/account/frontend/auth/login']),'id' => 'login-form', 'options' => ['class' => 'm-t', 'role' => 'form']]); ?>
                <div class="modal-body">
                    <button type="button" style="background-color: white; opacity: 1; font-size: 26px; padding: 0 4px; margin-bottom: 12px;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div id="msg" style="display: none;" class="alert alert-dismissable alert-danger"></div>
                    <?= $form->field($model, 'email')->input('email', ['class' => 'loginInput form-control"', 'placeholder' => 'Email'])->label(false); ?>
                    <?= $form->field($model, 'password')->passwordInput(['class' => 'loginInput form-control"', 'placeholder' => 'Password'])->label(false) ?>  
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12 text-right" style="padding-top: 7px;">
                            <a href="">Quên mật khẩu?</a>
                            <a href="">Đăng ký</a>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 text-right">
                            <?= Html::submitButton(Yii::t('account', 'Sign in'), ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                </div>
<!--                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    
                </div>-->
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>