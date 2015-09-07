<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\category\models\Category;

class FieldCategory extends \yii\widgets\InputWidget {

	/**
	 * Renders the widget.
	 */
	public function run() {
        $categories = Html::getAttributeValue($this->model, $this->attribute);
        $model = new Category;
        $tree = Category::findOne(['module' => $this->model->moduleName, $model->leftAttribute => 1]);
        if ($tree) {
            $tree = $tree->buildTreeHtml([], [], [
                'actions' => '<div class="btn-group pull-right">
                    <input type="checkbox" {check} class="choseCategories" name="choseCategories[]" value="{_id}">
                </div>',
            ], $categories);
        }
        
        echo $tree;
	}
}

