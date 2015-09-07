<?php

namespace app\modules\product\components;

use Yii;
use yii\helpers\Html;

class FieldDropdown extends \yii\widgets\InputWidget {

    public $list = [];

    public function init() {}

	/**
	 * Renders the widget.
	 */
	public function run() {
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control';
        
        $list[''] = '';
        $list += $this->list;
        echo Html::activeDropDownList($this->model, $this->attribute, $list, $this->options);
	}
}

