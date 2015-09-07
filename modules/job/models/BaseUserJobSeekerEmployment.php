<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "user_job_seeker_employment".
 *
 * @property \MongoId|string $_id
 * @property mixed $seeker_id
 * @property mixed $company_name
 * @property mixed $position
 * @property mixed $belong_month_from
 * @property mixed $belong_year_from
 * @property mixed $belong_month_to
 * @property mixed $belong_year_to
 * @property mixed $description
 */
class BaseUserJobSeekerEmployment extends \app\components\ActiveRecord
{

    public $moduleName = 'job';

    public static $collectionName = 'user_job_seeker_employment';

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
            'seeker_id',
            'company_name',
            'position',
            'belong_month_from',
            'belong_year_from',
            'belong_month_to',
            'belong_year_to',
            'description',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seeker_id', 'company_name', 'position', 'belong_month_from', 'belong_year_from', 'belong_month_to', 'belong_year_to', 'description'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'seeker_id' => Yii::t('job', 'Seeker ID'),
            'company_name' => Yii::t('job', 'Company Name'),
            'position' => Yii::t('job', 'Position'),
            'belong_month_from' => Yii::t('job', 'Belong Month From'),
            'belong_year_from' => Yii::t('job', 'Belong Year From'),
            'belong_month_to' => Yii::t('job', 'Belong Month To'),
            'belong_year_to' => Yii::t('job', 'Belong Year To'),
            'description' => Yii::t('job', 'Description'),
        ];
    }
}
