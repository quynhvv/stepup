<?php

namespace app\modules\message\models;

use Yii;

/**
 * This is the model class for collection "message_user".
 *
 * @property \MongoId|string $_id
 * @property mixed $type_id
 * @property mixed $user_id
 * @property mixed $message_id
 * @property mixed $category_id
 * @property mixed $is_read
 * @property mixed $is_delete
 * @property mixed $updated_at
 */
class BaseMessageUser extends \app\components\ActiveRecord
{

    public $moduleName = 'message';

    public static $collectionName = 'message_user';

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
            'type_id',
            'user_id',
            'message_id',
            'category_id',
            'is_read',
            'is_delete',
            'updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'user_id', 'message_id', 'category_id', 'is_read', 'is_delete', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('message', 'ID'),
            'type_id' => Yii::t('message', 'Type ID'),
            'user_id' => Yii::t('message', 'User ID'),
            'message_id' => Yii::t('message', 'Message ID'),
            'category_id' => Yii::t('message', 'Category ID'),
            'is_read' => Yii::t('message', 'Is Read'),
            'is_delete' => Yii::t('message', 'Is Delete'),
            'updated_at' => Yii::t('message', 'Updated At'),
        ];
    }
}
