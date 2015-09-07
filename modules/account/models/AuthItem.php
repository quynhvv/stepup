<?php

namespace app\modules\account\models;

use Yii;
use yii\data\ActiveDataProvider;

class AuthItem extends BaseAuthItem
{
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['_id', 'name', 'description', 'rule_name', 'data', 'created_at', 'updated_at'],
            'search' => ['_id', 'name', 'description', 'rule_name', 'data', 'created_at', 'updated_at'],
        ];
    }
    
    public function searchPermission($params, $pageSize = 200)
    {
        $query = self::find();
        $query->orderBy('_id ASC');
        $query->where(['type' => 2]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        
        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'rule_name', $this->rule_name])
            ->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
