<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class JobLocation extends BaseJobLocation
{

    public static function moduleName(){
        return 'job';
    }

    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'search' => ['_id', 'title', 'sort', 'status', 'creator', 'create_time', 'editor', 'update_time'],
        ]);
    }

    public function beforeSave($insert)
    {
        $this->sort = (int) $this->sort;
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

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // condition here
        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'sort', $this->sort])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'creator', $this->creator])
            ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'editor', $this->editor])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        
        if (!empty($this->create_time)){
            list($minDate, $maxDate) = explode(' to ', $this->create_time);
            $min_date = new \MongoDate(strtotime($minDate . ' 00:00:00'));
            $max_date = new \MongoDate(strtotime($maxDate . ' 23:59:59'));
            $query = \app\helpers\LetHelper::addFilter($query, 'create_time', [$min_date, $max_date], 'between');
        }

        if (\app\helpers\ArrayHelper::getValue($params, 'sort') == NULL)
            $query->orderBy('create_time DESC');
        
        return $dataProvider;
    }

    public static function getOptions() {
        return \app\helpers\ArrayHelper::map(self::find()->where(['status' => '1'])->orderBy('sort')->all(), '_id', 'title');
    }

    public function setDefaultValues() {
        if ($this->sort == null) {
            $this->sort = self::find()->max('sort') + 1;
        }
    }

}
