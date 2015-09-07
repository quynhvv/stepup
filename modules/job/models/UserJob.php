<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class UserJob extends BaseUserJob
{

    public $accept;
    public static $roleDefault = 'seeker';
    public static $roleAllows = ['seeker', 'recruiter', 'employer'];

    public $userEmail;

    public static function moduleName(){
        return 'account';
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
                [['sex', 'birthday', 'seeker_nationality', 'seeker_salary'], 'required', 'on' => ['register_seeker']],
                [['agent_company_name', 'agent_position', 'agent_office_location', 'agent_city_name', 'agent_website', 'agent_summary', 'agent_job_industry'], 'required', 'on' => ['register_recruiter', 'edit_recruiter', 'register_employer']],
                //only for recruiter
                [['agent_job_function'], 'required', 'on' => ['register_recruiter', 'edit_recruiter']],
                //special rules
                ['sex', 'default', 'value' => '1'],
                ['accept', 'required', 'requiredValue' => 1, 'message' => Yii::t('account', 'You should accept term to use our service'), 'on' => ['register_recruiter', 'register_employer']],
                [['agent_type'], 'required', 'on' => ['register_recruiter', 'register_employer']],
            ]
        );
    }

    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'search' => ['_id', 'role', 'email', 'sex', 'birthday', 'seeker_nationality', 'seeker_salary', 'agent_type', 'agent_company_name', 'agent_position', 'agent_office_location', 'agent_city_name', 'agent_website', 'agent_summary', 'agent_job_industry', 'agent_job_function', 'vip_from', 'vip_to', 'create_time'],
            'register_seeker' => ['sex', 'birthday', 'seeker_nationality', 'seeker_salary'],
            'register_recruiter' => ['agent_type', 'agent_company_name', 'agent_position', 'agent_office_location', 'agent_city_name', 'agent_website', 'agent_summary', 'agent_job_industry', 'agent_job_function', 'accept'],
            'register_employer' => ['agent_type', 'agent_company_name', 'agent_position', 'agent_office_location', 'agent_city_name', 'agent_website', 'agent_summary', 'agent_job_industry', 'accept'],
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['_id' => '_id']);
    }

//    @DUY: Bellow comment functions, what use for?

//    public function getSeekerSalary()
//    {
//        return $this->hasOne(\app\modules\job\models\JobSalary::className(), ['_id' => 'seeker_salary']);
//    }
//
//    public function getSeekerNationality()
//    {
//        return $this->hasOne(\app\modules\job\models\JobLocation::className(), ['_id' => 'seeker_nationality']);
//    }
//
//    public function getAgentOfficeLocation()
//    {
//        return $this->hasOne(\app\modules\job\models\JobLocation::className(), ['_id' => 'agent_office_location']);
//    }
//
//    public function getAgentIndustry()
//    {
//        return $this->hasOne(\app\modules\job\models\JobIndustry::className(), ['_id' => 'agent_job_industry']);
//    }
    
    public function getDisplayName() {
        $fullName = $this->user->first_name;
        if ($this->user->last_name){
            $fullName .= " {$this->user->last_name}";
        }
        return ($this->user->display_name) ? $this->user->display_name : ($fullName) ? : $this->user->email;
    }
    
    public function getJobIndustryCoverageTitle(){
        $items = array();
        if ($this->agent_job_industry AND is_array($this->agent_job_industry)){
            $items = ArrayHelper::map(\app\modules\category\models\Category::find()->where(['module' => 'job'])->andWhere(['IN', '_id', $this->agent_job_industry])->asArray()->all(), '_id', 'name');
        }

        return ($items) ? implode(', ', $items) : Yii::t('common', 'Not set');
    }
    
    public function getJobFunctionTitle(){
        $items = array();
        if ($this->agent_job_function AND is_array($this->agent_job_function)){
            $items = ArrayHelper::map(JobFunction::find()->where(['in', '_id', $this->agent_job_function])->asArray()->all(), '_id', 'title');
        }

        return ($items) ? implode(', ', $items) : Yii::t('common', 'Not set');
    }

    public function beforeSave($insert)
    {
        if ($this->birthday != null) {
            $this->birthday = new \MongoDate(strtotime("{$this->birthday} 00:00:00"));
        }
        if ($this->vip_from != null) {
            $this->vip_from = new \MongoDate(strtotime("{$this->vip_from} 00:00:00"));
        }
        if ($this->vip_to != null) {
            $this->vip_to = new \MongoDate(strtotime("{$this->vip_to} 00:00:00"));
        }
        return parent::beforeSave($insert);
    }

    public function setDefaultValues()
    {
        $this->sex = '1';
        $this->vip = '0';
    }

    public function search($params, $pageSize = 20)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['role' => $this->role]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

    public static function getSexOptions()
    {
        return [
            '1' => Yii::t('account', 'Male'),
            '2' => Yii::t('account', 'Female'),
        ];
    }

    public function getSexText() {
        if (array_key_exists($this->sex, self::getSexOptions()))
            return self::getSexOptions()[$this->sex];

        return '';
    }

    public static function getRecruiterTypeOptions() {
        return [
            '1' => Yii::t('account', 'Recruiter'),
            '2' => Yii::t('account', 'Hiring Manager'),
        ];
    }

    public function getRecruiterTypeText() {
        if (array_key_exists($this->agent_type, self::getRecruiterTypeOptions()))
            return self::getRecruiterTypeOptions()[$this->agent_type];

        return '';
    }

    public static function getRoleOptions() {
        $result = [];
        foreach (self::$roleAllows as $role) {
            $result[$role] = Yii::t('job', $role);
        }
        return $result;
    }

    public function getRoleText($role = null) {
        if ($role == null)
            $role = $this->role;

        if (array_key_exists($role, self::getRoleOptions()))
            return self::getRoleOptions()[$role];

        return '';
    }

    public static function getRole() {
        return Yii::$app->session->get('jobAccountRole');
    }

    public static function checkRole($name) {
        return (self::getRole() == $name) ? true : false;
    }

    public static function checkAccess($name) {
        if (Yii::$app->user->isGuest) {
            header('Location: '.Url::to(['/job/account/login', 'role' => $name]));
            //return Yii::$app->response->redirect(Url::to(['/job/account/login', 'role' => $name]));
        } else if (self::getRole() != $name) {
            header('Location: '.Url::to(['/job/account/logout', 'role' => $name]));
            //return Yii::$app->response->redirect(Url::to(['/job/account/logout', 'role' => $name]));
        }
    }

    public static function getDashboardUrl() {
        $role = self::getRole();
        return (in_array($role, self::$roleAllows))
            ? Url::to(["/job/{$role}/dashboard"])
            : Url::to(['/account/default/dashboard']);
    }
}