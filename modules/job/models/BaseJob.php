<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "job".
 *
 * @property \MongoId|string $_id
 * @property mixed $code
 * @property mixed $title
 * @property mixed $country_id
 * @property mixed $category_ids
 * @property mixed $city_name
 * @property mixed $annual_salary_from
 * @property mixed $annual_salary_to
 * @property mixed $functions
 * @property mixed $work_type
 * @property mixed $industry
 * @property mixed $company_name
 * @property mixed $company_description
 * @property mixed $description
 * @property mixed $email_cc
 * @property mixed $is_filtering
 * @property mixed $seo_url
 * @property mixed $seo_title
 * @property mixed $seo_desc
 * @property mixed $status
 * @property mixed $hits
 * @property mixed $created_by
 * @property mixed $created_time
 * @property mixed $updated_time
 */
class BaseJob extends \app\components\ActiveRecord
{
    
    public $moduleName = 'job';
    
    public static $collectionName = 'job';
    
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
            'code',
            'title',
            'country_id',
            'category_ids',
            'city_name',
            'annual_salary_from',
            'annual_salary_to',
            'functions',
            'work_type',
            'industry',
            'company_name',
            'company_description',
            'description',
            'email_cc',
            'is_filtering',
            'seo_url',
            'seo_title',
            'seo_desc',
            'hits',
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
            [['code', 'title', 'country_id', 'category_ids', 'city_name', 'annual_salary_from', 'annual_salary_to', 'functions', 'work_type', 'industry', 'company_name', 'company_description', 'company_name', 'description', 'email_cc', 'is_filtering', 'seo_url', 'seo_title', 'seo_desc', 'status', 'hits', 'created_by', 'created_time', 'updated_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'code' => Yii::t('job', 'Job Code'),
            'title' => Yii::t('job', 'Job Title'),
            'country_ids' => Yii::t('job', 'Job Location'),
            'category_ids' => Yii::t('job', 'Job Category'),
            'city_name' => Yii::t('job', 'Job City Name'),
            'annual_salary_from' => Yii::t('job', 'Annual Salary From'),
            'annual_salary_to' => Yii::t('job', 'Annaual Salary To'),
            'functions' => Yii::t('job', 'Job Functions'),
            'work_type' => Yii::t('job', 'Work Type'),
            'industry' => Yii::t('job', 'Job Industry'),
            'company_name' => Yii::t('job', 'Company Name'),
            'company_description' => Yii::t('job', 'Company Description'),
            'description' => Yii::t('job', 'Job Description'),
            'email_cc' => Yii::t('job', 'CC Email'),
            'is_filtering' => Yii::t('job', 'Application Filtering'),
            'seo_url' => Yii::t('job', 'SEO URL'),
            'seo_title' => Yii::t('job', 'SEO Title'),
            'seo_desc' => Yii::t('job', 'SEO Description'),
            'status' => Yii::t('job', 'Job Status'),
            'hits' => Yii::t('job', 'Number View'),
            'created_by' => Yii::t('job', 'Created By'),
            'created_time' => Yii::t('job', 'Created Time'),
            'updated_time' => Yii::t('job', 'Updated Time')
        ];
    }
}
