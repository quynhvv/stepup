<?php

namespace app\modules\account\components\fields;

use Yii;
use yii\helpers\Html;
use app\helpers\ArrayHelper;

class FieldMeasure extends \yii\widgets\InputWidget {

    public function init() {}

	/**
	 * Renders the widget.
	 */
	public function run() {
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control';

        $name = Html::getInputName($this->model, $this->attribute);
        $value = Html::getAttributeValue($this->model, $this->attribute);

        echo Html::beginTag('div', ['class' => 'row']);
            echo Html::beginTag('div', ['class' => 'col-lg-4']);
                echo Html::textInput($name . '[1]', ArrayHelper::getValue($value, '1', ''), $this->options);
            echo Html::endTag('div');
            
            echo Html::beginTag('div', ['class' => 'col-lg-4']);
                echo Html::textInput($name . '[2]', ArrayHelper::getValue($value, '2', ''), $this->options);
            echo Html::endTag('div');
            
            echo Html::beginTag('div', ['class' => 'col-lg-4']);
                echo Html::textInput($name . '[3]', ArrayHelper::getValue($value, '3', ''), $this->options);
            echo Html::endTag('div');
        echo Html::endTag('div');
	}
}

