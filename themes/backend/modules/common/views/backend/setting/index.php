<?php

use app\helpers\LetHelper;
use yii\bootstrap\Html;
use app\components\ActiveForm;
use app\components\SwitchInput;
use app\components\FieldRange;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use kartik\icons\Icon;

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
        <div class="col-lg-6">
            <div class="btn-group">
                <?php
                if (Yii::$app->user->can('common/backend/setting/*') OR Yii::$app->user->can('common/backend/setting/create')) {
                    $createUrl = ['setting/create'];
                    $module = Yii::$app->request->get('module');
                    if (!empty($module))
                        $createUrl['module'] = $module;

                    echo Html::a(Yii::t('common', 'Create a setting'), $createUrl, [
                        'class' => 'btn btn-success',
                        'onclick' => '$("#formDefault").submit();',
                    ]);
                }
//                if (Yii::$app->user->can(Yii::$app->controller->module->id . ':delete')) {
//                    echo Html::button(Yii::t('yii', 'Delete'), [
//                        'class' => 'btn btn-danger',
//                        'onclick' => "deleteSelectedRows('" . Url::to(['/common/crud/deleteselectedrows']) . "', '" . MongoProduct::tableName() . "')",
//                    ]);
//                }
                ?>
            </div>
        </div>
        <?php if (!empty($models)): ?>
        <div class="col-lg-6">
            <div class="btn-group pull-right">
                <?= $buttons; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($models)): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Yii::t('common', 'Config') ?></h5>
                </div>
                <div class="ibox-content">
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
                    
                    foreach ($models as $model) {
                        echo Html::beginTag('div', ['class' => 'form-group']);
                            echo Html::beginTag('label', ['class' => 'col-sm-2 control-label']);
                                echo ucfirst(Yii::t($model->module, $model->key));
                                echo Html::a('', ['setting/update', 'id' => $model->_id], ['class' => 'glyphicon glyphicon-cog m-l-xs']);
                            echo Html::endTag('label');
                            echo Html::beginTag('div', ['class' => 'col-sm-10']);
                                if ($model->type === 'text')
                                    echo Html::textInput('setting[' . (string) $model->_id .']', $model->value, ['class' => 'form-control']);
                                else if ($model->type === 'dropdown')
                                    echo Html::dropDownList('setting[' . (string) $model->_id .']', $model->value, $model->items, ['class' => 'form-control']);
                                else if ($model->type === 'checkbox')
                                    echo Html::checkboxList('setting[' . (string) $model->_id .']', $model->value, $model->items, ['class' => 'i-checks', 'separator' => '<br />']);
                                else if ($model->type === 'radio')
                                    echo Html::radioList('setting[' . (string) $model->_id .']', $model->value, $model->items, ['class' => 'i-checks', 'separator' => '<br />']);
                            echo Html::endTag('div');
                        echo Html::endTag('div');
                        echo Html::beginTag('div', ['class' => 'hr-line-dashed']);echo Html::endTag('div');
                    }
                    
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>