<?php

namespace app\modules\message\models;

use Yii;

/**
 * This is the model class for collection "message".
 *
 * @property \MongoId|string $_id
 * @property mixed $users
 * @property mixed $subject
 * @property mixed $content
 * @property mixed $created_at
 * @property mixed $created_by
 * @property mixed $message_id
 * @property mixed $category_id
 */
class BaseMessage extends \app\components\ActiveRecord
{

    public $moduleName = 'message';

    public static $collectionName = 'message';

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
            'users',
            'subject',
            'content',
            'created_at',
            'created_by',
            'message_id',
            'category_id',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users', 'subject', 'content', 'created_at', 'created_by', 'message_id', 'category_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('message', 'ID'),
            'users' => Yii::t('message', 'Users'),
            'category' => Yii::t('message', 'Category'),
            'subject' => Yii::t('message', 'Subject'),
            'content' => Yii::t('message', 'Content'),
            'created_at' => Yii::t('message', 'Created At'),
            'created_by' => Yii::t('message', 'Created By'),
            'message_id' => Yii::t('message', 'Message ID'),
        ];
    }
}
