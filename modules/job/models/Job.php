<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use app\helpers\ClientHelper;
use app\modules\category\models\Category;

class Job extends BaseJob
{
    const STATUS_NEW = '1';//the Agent is just posted
    const STATUS_APPLIED = '2'; //Seeker read and applied the job
    const STATUS_UNDER_REVIEW = '3'; //waiting for Seeker to reply
    const STATUS_ACCEPTED = '4'; //Seeker reviewed and accepted your job. Interview is offered
    const STATUS_REJECTED = '5'; //your job is not considered
    const STATUS_CLOSED = '6'; //Agents already expired
    
    public $function2;
    public $function3;
    public $industry2;

    public $search; // Enter job title, company name / information etc.
    
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
            'function2',
            'function3',
            'work_type',
            'industry',
            'industry2',
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
            'updated_time',
            'search'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title', 'country_id', 'category_ids', 'city_name', 'annual_salary_from', 'annual_salary_to', 'functions', 'function2', 'function3', 'work_type', 'industry', 'industry2', 'company_name', 'company_description', 'description', 'seo_url', 'seo_title', 'seo_desc', 'hits', 'status', 'created_by', 'created_time', 'updated_time'], 'safe'],
            [['code', 'title', 'country_id', 'category_ids', 'city_name', 'annual_salary_from', 'annual_salary_to', 'functions', 'work_type', 'industry', 'company_name', 'company_description', 'description'], 'required', 'on' => 'post'],
            [['code'], 'unique'],
            [['search'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => [
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
                'status'
                ],
            'post' => [
                'code',
                'title',
                'country_id',
                'category_ids',
                'city_name',
                'annual_salary_from',
                'annual_salary_to',
                'functions',
                'function2',
                'function3',
                'work_type',
                'industry',
                'industry2',
                'company_name',
                'company_description',
                'description',
            ],
            'search' => [
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
                'hits',
                'status',
                'created_time',
                'updated_time',
                'search'
            ],
        ];
    }
    
     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'code' => Yii::t('job', 'Job ID'),
            'title' => Yii::t('job', 'Job Title (Position)'),
            'country_id' => Yii::t('job', 'Job Location'),
            'category_ids' => Yii::t('job', 'Job Category'),
            'city_name' => Yii::t('job', 'Job City Name'),
            'annual_salary_from' => Yii::t('job', 'Annual Salary From'),
            'annual_salary_to' => Yii::t('job', 'Annaual Salary To'),
            'functions' => Yii::t('job', 'Job Functions'),
            'work_type' => Yii::t('job', 'Work Type'),
            'industry' => Yii::t('job', 'Job Industry'),
            'company_name' => Yii::t('job', 'Hiring Company Name'),
            'company_description' => Yii::t('job', 'Hiring Company Description'),
            'description' => Yii::t('job', 'Job Description'),
            'email_cc' => Yii::t('job', 'CC Email'),
            'is_filtering' => Yii::t('job', 'Application Filtering'),
            'seo_url' => Yii::t('job', 'SEO URL'),
            'seo_title' => Yii::t('job', 'SEO Title'),
            'seo_desc' => Yii::t('job', 'SEO Description'),
            'hits' => Yii::t('job', 'Number View'),
            'status' => Yii::t('job', 'Job Status'),
            'created_by' => Yii::t('job', 'Created By'),
            'created_time' => Yii::t('job', 'Created Time'),
            'updated_time' => Yii::t('job', 'Updated Time')
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (isset($_POST['Job']['title'])) {
                $this->description = HtmlPurifier::process($this->description, [
                    'Attr.EnableID' => true,
                    'Filter.YouTube' => true,
                    'HTML.TargetBlank' => true
                ]);
            }

            return true;
        }
        return false;
    }

    public function beforeSave($insert) {
        $now = new \MongoDate();
        $this->updated_time = $now;

        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->id;
            $this->created_time = $now;
        }

        return parent::beforeSave($insert);
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
        
        if (!empty($this->created_by)){
            $query = \app\helpers\LetHelper::addFilter($query, 'created_by', $this->created_by);
        }
        
        if (\app\helpers\ArrayHelper::getValue($params, 'sort') == NULL) {
            $query->orderBy('created_time DESC');
        }

        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }

        $query->orFilterWhere(['like', 'title', $this->search])
            ->orFilterWhere(['like', 'company_name', $this->search]);

        if (!empty($this->_id)){
            $query = \app\helpers\LetHelper::addFilter($query, '_id', $this->_id, 'like');
        }
        if (!empty($this->code)){
            $query = \app\helpers\LetHelper::addFilter($query, 'code', $this->code, 'like');
        }
        if (!empty($this->title)){
            $query = \app\helpers\LetHelper::addFilter($query, 'title', $this->title, 'like');
        }
        if (!empty($this->company_name)){
            $query = \app\helpers\LetHelper::addFilter($query, 'company_name', $this->company_name, 'like');
        }
        if (!empty($this->status)){
            $query = \app\helpers\LetHelper::addFilter($query, 'status', $this->status);
        }
        if (!empty($this->category_ids)){
            $query = \app\helpers\LetHelper::addFilter($query, 'category_ids', $this->category_ids);
        }
        
        if (!empty($this->created_time)){
            list($minDate, $maxDate) = explode(' to ', $this->created_time);
            $min_date = new \MongoDate(strtotime($minDate . ' 00:00:00'));
            $max_date = new \MongoDate(strtotime($maxDate . ' 23:59:59'));
            $query = \app\helpers\LetHelper::addFilter($query, 'created_time', [$min_date, $max_date], 'between');
        }
        
        if (!empty($this->updated_time)){
            list($minDate, $maxDate) = explode(' to ', $this->updated_time);
            $min_date = new \MongoDate(strtotime($minDate . ' 00:00:00'));
            $max_date = new \MongoDate(strtotime($maxDate . ' 23:59:59'));
            $query = \app\helpers\LetHelper::addFilter($query, 'updated_time', [$min_date, $max_date], 'between');
        }

        return $dataProvider;
    }
    
    public static function getStatusOptions($filter = false){
        $status = array(
            self::STATUS_NEW => Yii::t('job', 'New'),
            self::STATUS_APPLIED => Yii::t('job', 'Applied'),
            self::STATUS_UNDER_REVIEW => Yii::t('job', 'Under Review'),
            self::STATUS_ACCEPTED => Yii::t('job', 'Accepted'),
            self::STATUS_REJECTED => Yii::t('job', 'Rejected'),
            self::STATUS_CLOSED => Yii::t('job', 'Closed')
        );
        
        if ($filter){
            $status = array_replace_recursive(array('' => Yii::t('job', 'All')), $status);
        }
        
        return $status;
    }
    
    public function getCategoryOptions(){
        return ArrayHelper::map(Category::find()->where(['module' => 'job', 'status' => '1'])->andWhere(['lft' => ['$gt' => 1]])->asArray()->all(), '_id', 'name');
    }
    
    public function getCategoryNames(){
        $items = array();
        if ($this->category_ids AND is_array($this->category_ids)){
            $items = ArrayHelper::map(Category::find()->where(['module' => 'job'])->andWhere(['IN', '_id', $this->category_ids])->asArray()->all(), '_id', 'name');
        }
        
        return implode('<br/>', $items);
    }
    
    public function getFunctionNames(){
        $items = array();
        if ($this->functions AND is_array($this->functions)){
            $items = ArrayHelper::map(JobFunction::find()->where(['in', '_id', $this->functions])->asArray()->all(), '_id', 'title');
        }

        return implode('<br/>', $items);
    }
    
    public function getIndustryNames(){
        $items = array();
        if ($this->industry AND is_array($this->industry)){
            $items = ArrayHelper::map(JobIndustry::find()->where(['in', '_id', $this->industry])->asArray()->all(), '_id', 'title');
        }

        return implode('<br/>', $items);
    }
    
}
