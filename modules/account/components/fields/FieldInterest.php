<?php

namespace app\modules\account\components\fields;

use Yii;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
use app\modules\account\models\UserExtra;

class FieldInterest extends \yii\widgets\InputWidget {

    public function init() {}

	/**
	 * Renders the widget.
	 */
	public function run() {
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control m-t-xs';

        $name = Html::getInputName($this->model, $this->attribute);
        $id = Html::getInputId($this->model, $this->attribute);
        $value = Html::getAttributeValue($this->model, $this->attribute);
        
        $interestList = ArrayHelper::getValue(UserExtra::$options, 'interest', []);
        foreach ($interestList as $key => $label) {
            $this->options['id'] = $id . '-' . $key;
            echo Html::beginTag('div', ['class' => 'm-b-md']);
                echo Html::beginTag('label', ['class' => 'control-label', 'for' => $this->options['id']]);
                    echo Yii::t('account', $label);
                echo Html::endTag('label');
                echo Html::beginTag('div');
                    echo Html::textInput($name . '[' . $key . ']', ArrayHelper::getValue($value, $key, ''), $this->options);
                echo Html::endTag('div');
            echo Html::endTag('div');
        }
	}
}

