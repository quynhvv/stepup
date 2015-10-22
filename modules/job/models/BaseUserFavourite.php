<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "user_favourite".
 *
 * @property \MongoId|string $_id
 * @property mixed $object_id
 * @property mixed $object_type // seeker/job
 * @property mixed $created_by
 * @property mixed $created_time
 */
class BaseUserFavourite extends \app\components\ActiveRecord
{

    public $moduleName = 'job';

    public static $collectionName = 'user_favourite';

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
            '_id','object_id','object_type','created_by','created_time'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id','object_id','object_type','created_by','created_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'object_id' => Yii::t('job', 'Favourite Object'),
            'object_type' => Yii::t('job', 'Favourite Object Type'),
            'created_by' => Yii::t('job', 'Favourite By'),
            'created_time' => Yii::t('job', 'Favourite Time'),
        ];
    }
}
