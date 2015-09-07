<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "job_location".
 *
 * @property \MongoId|string $_id
 * @property mixed $title
 * @property mixed $sort
 * @property mixed $status
 * @property mixed $creator
 * @property mixed $create_time
 * @property mixed $editor
 * @property mixed $update_time
 */
class BaseJobLocation extends \app\components\ActiveRecord
{

    public $moduleName = 'job';

    public static $collectionName = 'job_location';

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
            'title',
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
            [['title', 'sort', 'status', 'creator', 'create_time', 'editor', 'update_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'title' => Yii::t('job', 'Title'),
            'sort' => Yii::t('job', 'Sort'),
            'status' => Yii::t('job', 'Status'),
            'creator' => Yii::t('job', 'Creator'),
            'create_time' => Yii::t('job', 'Create Time'),
            'editor' => Yii::t('job', 'Editor'),
            'update_time' => Yii::t('job', 'Update Time'),
        ];
    }
}
