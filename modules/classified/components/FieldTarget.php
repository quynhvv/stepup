<?php

namespace app\modules\classified\components;

use Yii;
use yii\helpers\Html;
use app\modules\classified\models\Classified;
use yii\helpers\ArrayHelper;

class FieldTarget extends \yii\widgets\InputWidget {

	public function init() {}

	/**
	 * Renders the widget.
	 */
	public function run() {
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control';
        
        $ages[''] = 'Chọn Mục tiêu';
        $ages += ArrayHelper::getValue(Classified::$options, 'target', []);
        echo Html::activeDropDownList($this->model, $this->attribute, $ages, $this->options);
	}
}

