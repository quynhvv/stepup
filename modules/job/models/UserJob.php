<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\job\models\UserJobSeekerResume;

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

    public static function getAgentTypeOptions() {
        return [
            '1' => Yii::t('account', 'Recruiter'),
            '2' => Yii::t('account', 'Hiring Manager'),
        ];
    }

    public function getRecruiterTypeText() {
        if (array_key_exists($this->agent_type, self::getAgentTypeOptions()))
            return self::getAgentTypeOptions()[$this->agent_type];

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
            //header('Location: '.Url::to(['/job/account/login', 'role' => $name]));exit();
            return Yii::$app->response->redirect(Url::to(['/job/account/login', 'role' => $name]));
        } else if (self::getRole() != $name) {
            return Yii::$app->response->redirect(Url::to(['/job/account/logout', 'role' => $name]));
        } else if ($name == 'seeker' && Yii::$app->controller->action->id != 'resume' && Yii::$app->session->get('jobAccountResume') != 1) {
            return Yii::$app->response->redirect(Url::to(['/job/seeker/resume']));
        }
    }

    public static function getDashboardUrl() {
        $role = self::getRole();
        return (in_array($role, self::$roleAllows))
            ? Url::to(["/job/{$role}/index"])
            : Url::to(['/account/default/dashboard']);
    }
    
    public static function getPostJobUrl() {
        $role = self::getRole();
        return (in_array($role, self::$roleAllows))
            ? Url::to(["/job/{$role}/post-job"])
            : Url::to(['/account/default/dashboard']);
    }
    
    public static function getProfileUrl() {
        $role = self::getRole();
        return (in_array($role, self::$roleAllows))
            ? Url::to(["/job/{$role}/view-profile"])
            : Url::to(['/account/default/dashboard']);
    }
    
    public static function getNextSequence($name){
        $collection = Yii::$app->mongodb->getCollection('job_counter');
        $retval = $collection->findAndModify(
             array('_id' => $name),
             array('$inc' => array("next_seq" => 1)),
             null,
             array(
                "new" => true,
            )
        );
        if ($name == 'seeker'){
            $retval['next_seq'] = "c".$retval['next_seq'];
        }
        
        return $retval['next_seq'];
    }
    
    public static function getHighPotentialCandidate($agentId = null) {
        $dataProvider = null;
        //get agent functions
        $agent = UserJob::findOne(['role' => 'recruiter', '_id' => $agentId]);
        if ($agent){
            //get seekers fit to agent
            $model = new UserJobSeekerResume();
            $model->functions = $agent->agent_job_function;
            $model->industries = $agent->agent_job_industry;
            $dataProvider = $model->search(Yii::$app->request->getQueryParams());
        }
        
        return $dataProvider;
    }
    
    public static function getFavouriteCandidate($agentId = null) {
        
        //get candidate ids favourites by current agent
        $favourites = UserFavourite::findAll(['object_type' => 'seeker', 'created_by' => $agentId]);
        $ids = array();
        if ($favourites){
            foreach ($favourites as $favourite){
                $ids[] = $favourite->object_id;
            }
        }
        
        //search candidate by ids
        $dataProvider = null;
        if ($ids){
            $model = new UserJobSeekerResume();
            $model->_ids = $ids;
            $model->search_mode = 'AND';
            $dataProvider = $model->search(Yii::$app->request->getQueryParams(), 20);
        }
        
        return $dataProvider;
    }
    
    public static function getFavouriteJob($seekerId = null) {
        
        //get job ids favourites by current seeker
        $favourites = UserFavourite::findAll(['object_type' => 'job', 'created_by' => $seekerId]);
        $ids = array();
        if ($favourites){
            foreach ($favourites as $favourite){
                $ids[] = $favourite->object_id;
            }
        }
        
        //search candidate by ids
        $dataProvider = null;
        if ($ids){
            $model = new Job();
            $model->setScenario('search');

            $params = Yii::$app->request->getQueryParams();
            $params['Job']['_ids'] = $ids;
            
            $dataProvider = $model->search($params, 20);
        }
        
        return $dataProvider;
    }
    
    public static function canView(){
        return false;
    }
    
    public static function getUpgradeUrl() {
        $role = self::getRole();
        return (in_array($role, self::$roleAllows))
            ? Url::to(["/job/{$role}/upgrade-account"])
            : Url::to([Yii::$app->defaultRoute]);
    }
    
    public static function getApplyUrl() {
        return Url::to(["/job/seeker/apply-job"]);
    }
}
