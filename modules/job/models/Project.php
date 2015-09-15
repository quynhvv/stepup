<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
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
class Project extends BaseProject
{
    const STATUS_ON = '1';
    const STATUS_OFF = '2';
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'candidates', 'status', 'created_by', 'created_time', 'updated_time'], 'safe'],
            [['name', 'description', 'candidates'], 'required', 'on' => 'create']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => [
                'name',
                'description',
                'candidates',
                'status',
                'created_by',
                'created_time',
                'updated_time'
            ],
            'search' => [
                'name',
                'description',
                'candidates',
                'status',
                'created_by',
                'created_time',
            ],
        ];
    }
    
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (isset($_POST['Project']['name'])) {
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

        if (!empty($this->name)){
            $query = \app\helpers\LetHelper::addFilter($query, 'name', $this->name, 'like');
        }
        if (!empty($this->description)){
            $query = \app\helpers\LetHelper::addFilter($query, 'description', $this->description, 'like');
        }
        if (!empty($this->status)){
            $query = \app\helpers\LetHelper::addFilter($query, 'status', $this->status);
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
            self::STATUS_ON => Yii::t('job', 'Active'),
            self::STATUS_OFF => Yii::t('job', 'Inactive'),
        );
        
        if ($filter){
            $status = array_replace_recursive(array('' => Yii::t('job', 'All')), $status);
        }
        
        return $status;
    }
    
    public static function getCandidatesOptions(){
        //will update this later
        $rs = array(
            '227' => 'C227',
            '198' => 'C98',
            '55' => 'C198',
            '56' => 'C56',
            '55' => 'C58'
        );
        
        return $rs;
    }
}
