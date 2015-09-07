<?php

namespace app\modules\classified\models;

use Yii;

/**
 * This is the model class for collection "classified".
 *
 * @property \MongoId|string $_id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $target
 * @property mixed $about_me
 * @property mixed $about_you
 * @property mixed $image
 * @property mixed $category
 * @property mixed $promotion
 * @property mixed $status
 * @property mixed $creator
 * @property mixed $create_time
 * @property mixed $editor
 * @property mixed $update_time
 * @property mixed $seo_url
 * @property mixed $seo_title
 * @property mixed $seo_desc
 */
class BaseClassified extends \app\components\ActiveRecord
{
    public $moduleName = 'classified';
    
    public static $collectionName = 'classified';
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
            'title',
            'description',
            'target',
            'about_me',
            'about_you',
            'image',
            'category',
            'promotion',
            'status',
            'creator',
            'create_time',
            'editor',
            'update_time',
            'seo_url',
            'seo_title',
            'seo_desc',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'target', 'about_me', 'about_you', 'image', 'category', 'creator', 'create_time', 'editor', 'update_time', 'seo_url', 'seo_title', 'seo_desc', 'promotion', 'status'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('classified', 'ID'),
            'title' => Yii::t('classified', 'Title'),
            'description' => Yii::t('classified', 'Description'),
            'target' => Yii::t('classified', 'Target'),
            'about_me' => Yii::t('classified', 'About Me'),
            'about_you' => Yii::t('classified', 'About You'),
            'image' => Yii::t('classified', 'Image'),
            'category' => Yii::t('classified', 'Category'),
            'promotion' => Yii::t('classified', 'Promotion'),
            'status' => Yii::t('classified', 'Status'),
            'creator' => Yii::t('classified', 'Creator'),
            'create_time' => Yii::t('classified', 'Create Time'),
            'editor' => Yii::t('classified', 'Editor'),
            'update_time' => Yii::t('classified', 'Update Time'),
            'seo_url' => Yii::t('classified', 'Seo Url'),
            'seo_title' => Yii::t('classified', 'Seo Title'),
            'seo_desc' => Yii::t('classified', 'Seo Desc'),
        ];
    }
}
