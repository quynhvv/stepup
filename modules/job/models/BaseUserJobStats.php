<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "job_seeker_stats".
 *
 * @property \MongoId|string $_id
 * @property mixed $date_time
 * @property mixed $data
 */
class BaseUserJobStats extends \app\components\ActiveRecord
{
    public $moduleName = 'job';
    
    public static $collectionName = 'user_job_stats';
    
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
            'date_time',
            'data',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_time', 'data'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'date_time' => Yii::t('job', 'Date Time'),
            'data' => Yii::t('job', 'Data'),
        ];
    }
}
