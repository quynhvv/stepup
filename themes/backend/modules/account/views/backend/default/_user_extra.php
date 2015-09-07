<?php
use app\components\fields\FieldDropdownList;
use app\modules\account\components\fields\FieldMeasure;
use app\helpers\ArrayHelper;
use app\modules\account\models\UserExtra;

return [
    [
        'label' => Yii::t('account', 'Personal infomation'),
        'content' =>
            $form->field($model, 'introduce')->textArea() .
            $form->field($model, 'address')->textInput() .
            $form->field($model, 'height')->widget(FieldDropdownList::classname(), [
                'items' => range(130, 200),
            ]) .
            $form->field($model, 'weight')->widget(FieldDropdownList::classname(), [
                'items' => range(35, 100),
            ]) .
            $form->field($model, 'sex')->widget(FieldDropdownList::classname(), [
                'items' => ArrayHelper::getValue(UserExtra::$options, 'sex', []),
            ]) .
            $form->field($model, 'measure')->widget(FieldMeasure::classname()) .
            $form->field($model, 'job')->textInput() .
            $form->field($model, 'housing')->widget(FieldDropdownList::classname(), [
                'items' => ArrayHelper::getValue(UserExtra::$options, 'housing', []),
            ]) .
            $form->field($model, 'marriage')->widget(FieldDropdownList::classname(), [
                'items' => ArrayHelper::getValue(UserExtra::$options, 'marriage', []),
            ]) .
            $form->field($model, 'children')->widget(FieldDropdownList::classname(), [
                'items' => range(0, 10),
            ]) .
            $form->field($model, 'religion')->widget(FieldDropdownList::classname(), [
                'items' => ArrayHelper::getValue(UserExtra::$options, 'religion', []),
            ]) .
            $form->field($model, 'free_time')->textInput(),
    ],
    [
        'label' => Yii::t('account', 'Interest'),
        'content' =>
            $form->field($model, 'interest')->widget(\app\modules\account\components\fields\FieldInterest::className()),
    ],
];