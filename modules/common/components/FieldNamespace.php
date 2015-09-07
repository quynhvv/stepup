<?php

namespace app\modules\common\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\account\models\AuthActionList;

class FieldNamespace extends \yii\widgets\InputWidget {

	public function init() {}

	/**
	 * Renders the widget.
	 */
	public function run() {
        // Get all module
        $modules = AuthActionList::getModules();
        
        $models = [];
        foreach ($modules as $module) {
            $modelsInModule = AuthActionList::getModelsInModule('', $module);
            if (count($modelsInModule) > 0)
                $models[$module] = $modelsInModule;
        }
        
        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control';
        
        echo Html::activeDropDownList($this->model, $this->attribute, $models, $this->options);
	}
}

