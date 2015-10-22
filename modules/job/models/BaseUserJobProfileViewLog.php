<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "user_job_profile_view_log".
 *
 * @property \MongoId|string $_id
 * @property mixed $user_id
 * @property mixed $view_by_user_id
 * @property mixed $hits
 * @property mixed $last_view_date
 */
class BaseUserJobProfileViewLog extends \app\components\ActiveRecord
{

    public $moduleName = 'job';

    public static $collectionName = 'user_job_profile_view_log';

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
            '_id','user_id','view_by_user_id','hits','last_view_date'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id','user_id','view_by_user_id','hits','last_view_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'user_id' => Yii::t('job', 'User ID'),
            'view_by_user_id' => Yii::t('job', 'View By User ID'),
            'hits' => Yii::t('job', 'Hits'),
            'last_view_date' => Yii::t('job', 'Created Time')
        ];
    }
}
