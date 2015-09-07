<?php

namespace app\modules\common\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class FieldMap extends \yii\widgets\InputWidget {

	public function init() {}

	/**
	 * Renders the widget.
	 */
	public function run() {
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control';
        
        // Get field in excel file
        $fieldsExcel = $this->model->getFieldsExcel();
        
        // Get all attributes in model
        $model = new $this->model->attributes['model_namespace'];
        $attributes = [];
        foreach ($model->attributes as $attribute => $value) {
            $attributes[$attribute] = $attribute;
        }
        
        // Show all attributes for collection in table_name
        foreach ($fieldsExcel as $fieldExcel) {
            $name = \yii\helpers\StringHelper::basename(get_class($this->model)) . '[' . $this->attribute . ']' . '[' . $fieldExcel . ']';
            $value = $attributes[$fieldExcel];
            echo '<div class="form-group">';
                echo '<label for="inputEmail3" class="col-sm-2 control-label">' . $fieldExcel . '</label>';
                echo '<div class="col-sm-10">' . Html::dropDownList($name, $value, $attributes, $this->options) . '</div>';
            echo '</div>';
        }
	}
}

