<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "user_vip_package".
 *
 * @property \MongoId|string $_id
 * @property mixed $role
 * @property mixed $title
 * @property mixed $days
 * @property mixed $price
 * @property mixed $sort
 * @property mixed $status
 * @property mixed $creator
 * @property mixed $create_time
 * @property mixed $editor
 * @property mixed $update_time
 */
class BaseUserVipPackage extends \app\components\ActiveRecord
{

    public $moduleName = 'job';

    public static $collectionName = 'user_vip_package';

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
            'role',
            'title',
            'days',
            'price',
            'sort',
            'status',
            'creator',
            'create_time',
            'editor',
            'update_time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'role', 'days', 'price', 'sort', 'status', 'creator', 'create_time', 'editor', 'update_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('account', 'ID'),
            'title' => Yii::t('account', 'Title'),
            'role' => Yii::t('role', 'Member Role'),
            'days' => Yii::t('account', 'Days'),
            'price' => Yii::t('account', 'Price'),
            'sort' => Yii::t('account', 'Sort'),
            'status' => Yii::t('account', 'Status'),
            'creator' => Yii::t('account', 'Creator'),
            'create_time' => Yii::t('account', 'Create Time'),
            'editor' => Yii::t('account', 'Editor'),
            'update_time' => Yii::t('account', 'Update Time'),
        ];
    }
}
