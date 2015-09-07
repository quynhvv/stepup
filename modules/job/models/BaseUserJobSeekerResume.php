<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "user_job_seeker_resume".
 *
 * @property \MongoId|string $_id
 * @property mixed $nationality
 * @property mixed $location
 * @property mixed $phone_country
 * @property mixed $phone_number
 * @property mixed $social_linkedin
 * @property mixed $social_facebook
 * @property mixed $social_twitter
 * @property mixed $experience
 * @property mixed $functions
 * @property mixed $industries
 * @property mixed $salary
 * @property mixed $education_name
 * @property mixed $education_degree
 * @property mixed $education_study
 * @property mixed $education_month
 * @property mixed $education_year
 * @property mixed $language_ability
 */
class BaseUserJobSeekerResume extends \app\components\ActiveRecord
{

    public $moduleName = 'job';

    public static $collectionName = 'user_job_seeker_resume';

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
            'nationality',
            'location',
            'phone_country',
            'phone_number',
            'social_linkedin',
            'social_facebook',
            'social_twitter',
            'experience',
            'functions',
            'industries',
            'salary',
            'education_name',
            'education_degree',
            'education_study',
            'education_month',
            'education_year',
            'language_ability',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nationality', 'location', 'phone_country', 'phone_number', 'social_linkedin', 'social_facebook', 'social_twitter', 'experience', 'functions', 'industries', 'salary', 'education_name', 'education_degree', 'education_study', 'education_month', 'education_year', 'language_ability'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'nationality' => Yii::t('job', 'Nationality'),
            'location' => Yii::t('job', 'Location'),
            'phone_country' => Yii::t('job', 'Phone Country'),
            'phone_number' => Yii::t('job', 'Phone Number'),
            'social_linkedin' => Yii::t('job', 'Social Linkedin'),
            'social_facebook' => Yii::t('job', 'Social Facebook'),
            'social_twitter' => Yii::t('job', 'Social Twitter'),
            'experience' => Yii::t('job', 'Experience'),
            'functions' => Yii::t('job', 'Functions'),
            'industries' => Yii::t('job', 'Industries'),
            'salary' => Yii::t('job', 'Salary'),
            'education_name' => Yii::t('job', 'Education Name'),
            'education_degree' => Yii::t('job', 'Education Degree'),
            'education_study' => Yii::t('job', 'Education Study'),
            'education_month' => Yii::t('job', 'Education Month'),
            'education_year' => Yii::t('job', 'Education Year'),
            'language_ability' => Yii::t('job', 'Language Ability'),
        ];
    }
}
