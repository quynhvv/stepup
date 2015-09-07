<?php

namespace app\modules\account\components;

use Yii;
use app\modules\account\models\AuthItem;
use app\modules\account\models\AuthItemChild;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SelectActionForItemColumn extends \yii\grid\CheckboxColumn {
    
    /**
     * Item Permission
     * @var array 
     */
    private $itemPermissions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->itemPermissions))
            $this->itemPermissions = $this->getItemPermissions();

        parent::init();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $this->options['value'] = $model->_id;
        $this->options['id'] = 'selection_'.  uniqid();
        if (in_array($model->_id, $this->itemPermissions))
            return null;
        else 
            return Html::checkbox($this->name, false, $this->options);
    }
    
    protected function getItemPermissions() {
        $auth = Yii::$app->authManager;
        $itemPermission = $auth->getPermissions();
        $result = [];
        foreach ($itemPermission as $item) {
            $result[] = $item->name;
        }
        return $result;
    }
    
}
