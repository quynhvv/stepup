<?php

namespace app\modules\account\models;

use Yii;

/**
 * This is the model class for collection "auth_item_child".
 *
 * @property \MongoId|string $_id
 * @property mixed $parent
 * @property mixed $child
 */
class BaseAuthItemChild extends \app\components\ActiveRecord
{
    
    public $moduleName = 'account';
    
    public static $collectionName = 'auth_item_child';
    
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
            'parent',
            'child',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('account', 'ID'),
            'parent' => Yii::t('account', 'Parent'),
            'child' => Yii::t('account', 'Child'),
        ];
    }
}
