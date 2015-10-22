<?php

namespace app\components\fields;

use Yii;
use yii\helpers\Html;

use app\modules\category\models\Category;

class FieldSlugPrefix extends \yii\widgets\InputWidget {

	/**
	 * Renders the widget.
	 */
	public function run() {

        if (!isset($this->options['class']) OR empty($this->options['class']))
            $this->options['class'] = 'form-control';

        echo Html::activeTextInput($this->model, $this->attribute, $this->options);


//        $categories = Html::getAttributeValue($this->model, $this->attribute);
//        $model = new Category;

//        $items = [];
//        $category = Category::findOne(['module' => $this->model->moduleName, 'lft' => 1]);
//        $categories = $category->children()->all();
//        foreach ($categories as $cat) {
//            $items[(string) $cat->_id] = str_repeat('--', ($cat->depth)) . $cat->name;
//        }
//
//        echo Html::dropDownList('Article[slug_prefix][]', null, $items, $this->options);
	}
}

