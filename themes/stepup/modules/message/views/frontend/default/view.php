<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

    <!-- MAIN -->
    <main id="main" class="main-container">
        <!-- SECTION 1 -->
        <div class="section section-1">
            <div class="container">
                <div class="section-inner">
                    <div class="section-content layout-2cols-left">
                        <div class="row">
                            <div class="col-xs-12 col-sm-9 col-sm-push-3 col-main section-gap">
                                <div class="tab-content">
                                    <h2>
                                        <?= Html::encode($model->subject) ?>
                                        <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->primaryKey], ['class' => 'btn btn-danger pull-right message-delete']) ?>
                                    </h2>

                                    <div class="media-list message-list">
                                        <?= \yii\widgets\ListView::widget([
                                            'dataProvider' => $dataProvider,
                                            'itemView' => 'viewItem',
                                            'itemOptions' => [
                                                'class' => 'grid-item'
                                            ],
                                            'layout' => "{items}\n{pager}"
                                        ]) ?>
                                    </div>

                                    <div class="message-form">
                                        <?= $this->render('viewReplyForm', ['modelReply' => $modelReply]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-sm-pull-9 col-sidebar">
                                <?= $this->render('_sidebar'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- # SECTION 1 -->
    </main>
    <!-- # MAIN -->


<?php
Yii::$app->view->registerCss('
    .media {
        margin-bottom: 30px;
    }
    .media-object {
        width: 50px;
    }
');

Yii::$app->view->registerJs("
    $('#message-form').on('beforeSubmit', function (e) {
        form = $(this);
        if (form.find('.has-error').length) {
            return false;
        }

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function () {
                $('#message-form-submit').text('Sending...').prop('disabled', true);
            },
            success: function (data) {
                if (data.status == 1) {
                    formReset('#message-form');
                    $('.message-list').append(data.content);
                }

                if (data.status == 0) {
                    summaryError = '';
                    $.each(data.errors, function(key, val) {
                        summaryError = summaryError + '<li>' + val.toString() + '</li>';
                    });

                    bootbox.dialog({
                        title: 'Please solve following errors:',
                        message: '<ul>' + summaryError + '</ul>',
                        buttons: {
                            danger: {
                                label: 'OK',
                                className: 'btn-danger'
                            },
                        }
                    });
                }

                $('#message-form-submit').text('Send Reply').prop('disabled', false);
            }
        });
    }).on('submit', function (e) {
        e.preventDefault();
    });

    $('.message-delete').on('click', function(e){
        e.preventDefault();
        url = $(this).attr('href');
        bootbox.confirm('Are you sure you want to delete?', function(result) {
            if (result) {
                window.location.href = url;
            }
        });
    });
");

Yii::$app->view->registerJs("
    function formReset (formId) {
        if (formId.indexOf('#') !== 0) {
            formId = '#' + formId;
        }

        $(formId).find(':input').each(function () {
            switch (this.type) {
                case 'password':
                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });

        if (typeof(tinyMCE) !== 'undefined' && tinyMCE.activeEditor !== null) {
            tinyMCE.activeEditor.setContent('');
        }
    }
", yii\web\View::POS_END);