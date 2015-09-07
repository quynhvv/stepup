<?php

namespace app\modules\job\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * This is the model class for collection "job_seeker_stats".
 *
 * @property \MongoId|string $_id
 * @property mixed $date_time
 * @property mixed $data
 */
class JobStats extends BaseJobStats
{
    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'search' => ['_id', 'date_time'],
            'default' => ['_id', 'date_time']
        ]);
    }

    public function search($params, $pageSize = 20, $where)
    {
        $query = self::find();
        $query->orderBy(['date_time' => -1]);
        $query->where($where);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query = \app\helpers\LetHelper::addFilter($query, '_id', $this->_id, 'like');

        if (!empty($this->date_time)) {
            list($minDate, $maxDate) = explode(' to ', $this->date_time);
            $min_date = new \MongoDate(strtotime($minDate . ' 00:00:00'));
            $max_date = new \MongoDate(strtotime($maxDate . ' 23:59:59'));
            $query = \app\helpers\LetHelper::addFilter($query, 'date_time', [$min_date, $max_date], 'between');
        }

        return $dataProvider;
    }
}
