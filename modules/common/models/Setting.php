<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for collection "config".
 *
 * @property \MongoId|string $_id
 * @property mixed $module
 * @property mixed $key
 * @property mixed $value
 * @property mixed $type
 * @property mixed $items
 */
class Setting extends BaseSetting
{
    public static $options = [
        'type' => [
            'text' => 'Text',
            'editor' => 'Editor',
            'dropdown' => 'Dropdown',
            'radio' => 'Radio',
            'checkbox' => 'Check box',
        ],
    ];
    
    /**
     * Ham lay ra gia tri cua option setting
     * @param string $module ten module
     * @param string $key config key
     * @return string tra ve gia tri cua config key
     */
    public static function getValue($module, $key){
        $model = self::findOne(['module' => $module, 'key' => $key]);
        if (!$model) {
            $model = new self;
            $model->module = $module;
            $model->type = 'text';
            $model->key = $key;
            $model->value = '';
        }
        
        $attributes = array_keys($model->getAttributes());
        $value = in_array('value', $attributes) ? $model->value : '';
        if ($model->type == 'text')
            return $value;
        elseif (in_array($model->type, ['checkbox', 'radio', 'dropdown']) AND property_exists($model, 'items'))
            return \app\helpers\ArrayHelper::getValue($model->items, $model->value, '');
        else
            return '';
    }
}
