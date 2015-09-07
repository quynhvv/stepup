<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for collection "setting".
 *
 * @property \MongoId|string $_id
 * @property mixed $module
 * @property mixed $key
 * @property mixed $value
 * @property mixed $type
 * @property mixed $items
 */
class BaseSetting extends \app\components\ActiveRecord
{
    public $moduleName = 'common';
    
    public static $collectionName = 'setting';
    
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return self::$collectionName;
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'module',
            'key',
            'value',
            'type',
            'items',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'key', 'value', 'type', 'items'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('common', 'ID'),
            'module' => Yii::t('common', 'Module'),
            'key' => Yii::t('common', 'Key'),
            'value' => Yii::t('common', 'Value'),
            'type' => Yii::t('common', 'Type'),
            'items' => Yii::t('common', 'Items'),
        ];
    }
}
