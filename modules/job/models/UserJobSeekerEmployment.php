<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserJobSeekerEmployment extends BaseUserJobSeekerEmployment
{

    public static function moduleName(){
        return 'job';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), [
                [['seeker_id'], 'required', 'on' => ['default', 'create']],
                [['company_name', 'position'], 'required', 'on' => 'default'],
            ]
        );
    }

    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'search' => ['_id', 'seeker_id', 'company_name', 'position', 'belong_month_from', 'belong_year_from', 'belong_month_to', 'belong_year_to', 'description'],
        ]);
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

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // condition here
        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'seeker_id', $this->seeker_id])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'belong_month_from', $this->belong_month_from])
            ->andFilterWhere(['like', 'belong_year_from', $this->belong_year_from])
            ->andFilterWhere(['like', 'belong_month_to', $this->belong_month_to])
            ->andFilterWhere(['like', 'belong_year_to', $this->belong_year_to])
            ->andFilterWhere(['like', 'description', $this->description]);

        
        return $dataProvider;
    }

}
