<?php
namespace app\modules\job\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class form job Chart
 * @property mixed $from_time
 * @property mixed $to_time
 * @property mixed $display_type
 * @property mixed $status
 * @property mixed $campaign
 * @property mixed $formatDate
 */
class StatsForm extends Model
{
    /**
     *
     * @var datetime khoang thoi gian
     */
    public $datetime_range;

    /**
     *
     * @var datetime ngay bat dau
     */
    public $from_time;

    /**
     *
     * @var datetime ngay ket thuc
     */
    public $to_time;

    /**
     *
     * @var string Format date time
     */
    public $formatDate = 'd-m-Y';

    public static $typeDisplayChart = [
        'day' => 'Theo từng ngày',
        'week' => 'Theo từng tuần',
        'month' => 'Theo từng tháng'
    ];

    public function rules()
    {
        return [
            [['_id', 'datetime_range', 'from_time', 'to_time'], 'safe']
        ];
    }

    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'default' => ['_id', 'datetime_range', 'from_time', 'to_time']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'datetime_range',
            'from_time',
            'to_time',
        ];
    }

    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('job', 'ID'),
            'datetime_range' => Yii::t('job', 'Datetime range'),
            'from_time' => Yii::t('job', 'From time'),
            'to_time' => Yii::t('job', 'To time'),
        ];
    }
}
