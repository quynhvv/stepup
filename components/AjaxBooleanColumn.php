<?php

namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class AjaxBooleanColumn extends \kartik\grid\BooleanColumn {

    public $attribute = 'status';
    public $route = null;

    public function init() {
        if (empty($this->trueLabel)) {
            $this->trueLabel = Yii::t('yii', 'Yes');
        }
        if (empty($this->falseLabel)) {
            $this->falseLabel = Yii::t('yii', 'No');
        }
        parent::init();
    }

    public function getDataCellValue($model, $key, $index)
    {
        $routes = [$this->route, 'id' => (string) $model->_id];

        if ($this->route == null) {
            $routes[0] = '/' . Yii::$app->controller->uniqueId . '/' . $this->attribute;
        }

        $url = Url::to($routes);

        $status = ArrayHelper::getValue($model, $this->attribute);
        if ($status == true) {
            return Html::a($this->trueIcon, $url, [
                'data-pjax' => '0',
                'onclick' => 'gridColumnBoolean($(this)); return false'
            ]);
        } else {
            return Html::a($this->falseIcon, $url, [
                'data-pjax' => '0',
                'onclick' => 'gridColumnBoolean($(this)); return false'
            ]);
        }
    }

}
