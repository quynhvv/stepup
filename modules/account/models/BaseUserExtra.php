<?php

namespace app\modules\account\models;

use Yii;

/**
 * This is the model class for collection "user_extra".
 *
 * @property \MongoId|string $_id
 * @property mixed $birthday
 * @property mixed $introduce
 * @property mixed $address
 * @property mixed $height
 * @property mixed $weight
 * @property mixed $sex
 * @property mixed $measure
 * @property mixed $job
 * @property mixed $housing
 * @property mixed $marriage
 * @property mixed $children
 * @property mixed $religion
 * @property mixed $interest
 * @property mixed $free_time
 */
class BaseUserExtra extends \app\components\ActiveRecord
{
    
    public $moduleName = 'account';

    public static $collectionName = 'user_extra';
    
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return self::$collectionName;
    }


    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'birthday',
            'introduce',
            'address',
            'height',
            'weight',
            'sex',
            'measure',
            'job',
            'housing',
            'marriage',
            'children',
            'religion',
            'interest',
            'free_time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthday', 'introduce', 'address', 'height', 'weight', 'sex', 'measure', 'job', 'housing', 'marriage', 'children', 'religion', 'interest', 'free_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('account', 'ID'),
            'birthday' => Yii::t('account', 'Birthday'),
            'introduce' => Yii::t('account', 'Introduce'),
            'address' => Yii::t('account', 'Address'),
            'height' => Yii::t('account', 'Height'),
            'weight' => Yii::t('account', 'Weight'),
            'sex' => Yii::t('account', 'Sex'),
            'measure' => Yii::t('account', 'Measure'),
            'job' => Yii::t('account', 'Job'),
            'housing' => Yii::t('account', 'Housing'),
            'marriage' => Yii::t('account', 'Marriage'),
            'children' => Yii::t('account', 'Children'),
            'religion' => Yii::t('account', 'Religion'),
            'interest' => Yii::t('account', 'Interest'),
            'free_time' => Yii::t('account', 'Free Time'),
        ];
    }
}
