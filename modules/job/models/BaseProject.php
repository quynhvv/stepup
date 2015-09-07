<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "project".
 *
 * @property \MongoId|string $_id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $candidates
 * @property mixed $status
 * @property mixed $created_by
 * @property mixed $created_time
 * @property mixed $updated_time
 */
class BaseProject extends \app\components\ActiveRecord
{
    
    public $moduleName = 'job';
    
    public static $collectionName = 'project';
    
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
            'description',
            'candidates',
            'status',
            'created_by',
            'created_time',
            'updated_time'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'candidates', 'status', 'created_by', 'created_time', 'updated_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'name' => Yii::t('job', 'Project Name'),
            'description' => Yii::t('job', 'Project Description'),
            'candidates' => Yii::t('job', 'Assign Candidates'),
            'status' => Yii::t('job', 'Project Status'),
            'created_by' => Yii::t('job', 'Created By'),
            'created_time' => Yii::t('job', 'Created Time'),
            'updated_time' => Yii::t('job', 'Updated Time')
        ];
    }
}
