<?php

namespace app\modules\account\models;

use Yii;

/**
 * This is the model class for collection "auth_item".
 *
 * @property \MongoId|string $_id
 * @property mixed $name
 * @property mixed $type
 * @property mixed $description
 * @property mixed $rule_name
 * @property mixed $data
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class BaseAuthItem extends \app\components\ActiveRecord
{
    
    public $moduleName = 'account';
    
    public static $collectionName = 'auth_item';
    
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
            'name',
            'type',
            'description',
            'rule_name',
            'data',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('account', 'ID'),
            'name' => Yii::t('account', 'Name'),
            'type' => Yii::t('account', 'Type'),
            'description' => Yii::t('account', 'Description'),
            'rule_name' => Yii::t('account', 'Rule Name'),
            'data' => Yii::t('account', 'Data'),
            'created_at' => Yii::t('account', 'Created At'),
            'updated_at' => Yii::t('account', 'Updated At'),
        ];
    }
}
