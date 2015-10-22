<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for collection "user_job_profile_view_log".
 *
 * @property \MongoId|string $_id
 * @property mixed $user_id
 * @property mixed $view_by_user_id
 * @property mixed $hits
 * @property mixed $last_view_date
 */
class UserJobProfileViewLog extends BaseUserJobProfileViewLog
{
    protected $name;
    protected $company_name;

    public function rules() {
        return array_merge(
            parent::rules(), [
                [['user_id','view_by_user_id','last_view_date'], 'required', 'on' => 'default'],
            ]
        );
    }

    public function scenarios() {
        return array_merge(Model::scenarios(), [
            'search' => ['user_id','view_by_user_id'],
        ]);
    }
    
    public function search($params, $pageSize = 20) {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }
        
        if (!empty($this->user_id)) {
            $query->andFilterWhere(['=', 'user_id', $this->user_id]);
        }
        
        if (!empty($this->view_by_user_id)) {
            $query->andFilterWhere(['=', 'view_by_user_id', $this->view_by_user_id]);
        }
        
        return $dataProvider;
    }
    
     /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            '_id' => Yii::t('job', 'ID'),
            'view_by_user_id' => Yii::t('job', 'View By'),
            'last_view_date' => Yii::t('job', 'Last Viewed Date')
        ];
    }
}
