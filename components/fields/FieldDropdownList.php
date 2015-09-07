<?php

namespace app\components\fields;

use Yii;
use yii\helpers\Html;

class FieldDropdownList extends \yii\widgets\InputWidget {

    /**
     * The option data items
     * @var array 
     */
    public $items;

	/**
	 * Renders the widget.
	 */
	public function run() {
        if (is_array($this->items)) {
            if (!isset($this->options['class']) OR empty($this->options['class']))
                $this->options['class'] = 'form-control';

            $items[''] = '';
            $items += $this->items;
            echo Html::activeDropDownList($this->model, $this->attribute, $items, $this->options);
        }
	}
}

