<?php

namespace app\modules\account\components;

use Yii;
use app\modules\account\models\AuthItem;
use app\modules\account\models\AuthItemChild;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SelectPermissionForRoleColumn extends \yii\grid\CheckboxColumn {
    
    /**
     * Children of roles
     * @var array 
     */
    private $children = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $role = \Yii::$app->request->get('role');
        if (!isset($this->children[$role]))
            $this->children[$role] = $this->getChirlrenOfRole($role);

        parent::init();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $this->options['value'] = $model->name;
        $role = \Yii::$app->request->get('role');
        if (in_array($model->name, $this->children[$role]))
            return Html::checkbox($this->name, true, $this->options);
        else 
            return Html::checkbox($this->name, false, $this->options);
    }
    
    protected function getChirlrenOfRole($role = null) {
        if ($role) {
            // Get Children
            $children = AuthItemChild::findAll(['parent' => $role]);
            $result = [];
            foreach ($children as $child) {
                $result[] = $child->child;
            }
            return $result;
        } else return null;
    }
    
}
