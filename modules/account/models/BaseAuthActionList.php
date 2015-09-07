<?php

namespace app\modules\account\models;

use Yii;

/**
 * This is the model class for collection "auth_action_list".
 *
 * @property \MongoId|string $_id
 * @property mixed $module
 * @property mixed $app
 * @property mixed $controller
 * @property mixed $action
 * @property mixed $is_permission
 */
class BaseAuthActionList extends \app\components\ActiveRecord
{
    
    public $moduleName = 'account';
    
    public static $collectionName = 'auth_action_list';
    
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
            'app',
            'controller',
            'action',
            'is_permission',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'app', 'controller', 'action', 'is_permission'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('account', 'ID'),
            'module' => Yii::t('account', 'Module'),
            'app' => Yii::t('account', 'App'),
            'controller' => Yii::t('account', 'Controller'),
            'action' => Yii::t('account', 'Action'),
            'is_permission' => Yii::t('account', 'Is Permission'),
        ];
    }
}
