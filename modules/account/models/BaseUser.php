<?php

namespace app\modules\account\models;

use Yii;

/**
 * This is the model class for collection "account".
 *
 * @property \MongoId|string $_id
 * @property mixed $email
 * @property mixed $display_name
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $image
 * @property mixed $openids
 * @property mixed $phone
 * @property mixed $password_hash
 * @property mixed $password_reset_token
 * @property mixed $auth_key
 * @property mixed $role
 * @property mixed $create_time
 * @property mixed $update_time
 * @property mixed $status
 */
class BaseUser extends \app\components\ActiveRecord
{
    
    public $moduleName = 'account';
    
    public static $collectionName = 'user';
    
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
            'email',
            'display_name',
            'first_name',
            'last_name',
            'image',
            'openids',
            'phone',
            'password_hash',
            'password_reset_token',
            'auth_key',
            'role',
            'create_time',
            'update_time',
            'status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'display_name', 'first_name', 'last_name', 'image', 'openids', 'phone', 'password_hash', 'password_reset_token', 'auth_key', 'role', 'create_time', 'update_time', 'status'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('account', 'ID'),
            'email' => Yii::t('account', 'Email'),
            'display_name' => Yii::t('account', 'Display Name'),
            'first_name' => Yii::t('account', 'First Name'),
            'last_name' => Yii::t('account', 'Last Name'),
            'image' => Yii::t('account', 'Image'),
            'openids' => Yii::t('account', 'Open id'),
            'phone' => Yii::t('account', 'Phone'),
            'password_hash' => Yii::t('account', 'Password Hash'),
            'password_reset_token' => Yii::t('account', 'Password Reset Token'),
            'auth_key' => Yii::t('account', 'Auth Key'),
            'role' => Yii::t('account', 'Role'),
            'create_time' => Yii::t('account', 'Create Time'),
            'update_time' => Yii::t('account', 'Update Time'),
            'status' => Yii::t('account', 'Status'),
        ];
    }
}
