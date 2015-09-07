<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "user_job".
 *
 * @property \MongoId|string $_id
 * @property mixed $role
 * @property mixed $email
 * @property mixed $sex
 * @property mixed $birthday
 * @property mixed $seeker_nationality
 * @property mixed $seeker_salary
 * @property mixed $agent_type
 * @property mixed $agent_company_name
 * @property mixed $agent_position
 * @property mixed $agent_office_location
 * @property mixed $agent_city_name
 * @property mixed $agent_website
 * @property mixed $agent_summary
 * @property mixed $agent_job_industry
 * @property mixed $agent_job_function
 * @property mixed $vip
 * @property mixed $vip_from
 * @property mixed $vip_to
 * @property mixed $create_time
 */
class BaseUserJob extends \app\components\ActiveRecord
{

    public $moduleName = 'account';

    public static $collectionName = 'user_job';

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
            'role',
            'email',
            'sex',
            'birthday',
            'seeker_nationality',
            'seeker_salary',
            'agent_type',
            'agent_company_name',
            'agent_position',
            'agent_office_location',
            'agent_city_name',
            'agent_website',
            'agent_summary',
            'agent_job_industry',
            'agent_job_function',
            'vip',
            'vip_from',
            'vip_to',
            'create_time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'email', 'sex', 'birthday', 'seeker_nationality', 'seeker_salary', 'agent_type', 'agent_company_name', 'agent_position', 'agent_office_location', 'agent_city_name', 'agent_website', 'agent_summary', 'agent_job_industry', 'agent_job_function', 'vip', 'vip_from', 'vip_to', 'create_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('account', 'ID'),
            'role' => Yii::t('account', 'Role'),
            'email' => Yii::t('account', 'Email'),
            'sex' => Yii::t('account', 'Sex'),
            'birthday' => Yii::t('account', 'Birthday'),
            'seeker_nationality' => Yii::t('account', 'Seeker Nationality'),
            'seeker_salary' => Yii::t('account', 'Seeker Salary'),
            'agent_type' => Yii::t('account', 'Agent Type'),
            'agent_company_name' => Yii::t('account', 'Agent Company Name'),
            'agent_position' => Yii::t('account', 'Agent Position'),
            'agent_office_location' => Yii::t('account', ' Office Location'),
            'agent_city_name' => Yii::t('account', 'Agent City Name'),
            'agent_website' => Yii::t('account', 'Agent Website'),
            'agent_summary' => Yii::t('account', 'Agent Summary'),
            'agent_job_industry' => Yii::t('account', 'Agent Job Industry'),
            'agent_job_function' => Yii::t('account', 'Agent Job Function'),
            'vip' => Yii::t('account', 'Vip'),
            'vip_from' => Yii::t('account', 'Vip From'),
            'vip_to' => Yii::t('account', 'Vip To'),
            'create_time' => Yii::t('account', 'Create Time'),
        ];
    }
}
