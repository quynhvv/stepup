<?php

namespace app\modules\category\models;

use Yii;

/**
 * This is the model class for collection "category".
 *
 * @property \MongoId|string $_id
 * @property mixed $name
 * @property mixed $tree
 * @property mixed $lft
 * @property mixed $rgt
 * @property mixed $depth
 * @property mixed $module
 * @property mixed $image
 * @property mixed $class
 * @property mixed $skin
 * @property mixed $description
 * @property mixed $seo_url
 * @property mixed $seo_title
 * @property mixed $seo_desc
 * @property mixed $seo_keyword
 * @property mixed $promotion
 * @property mixed $status
 */
class BaseCategory extends \app\components\ActiveRecord
{
    
    public $moduleName = 'category';
        
    public static $collectionName = 'category';
    
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
            'name',
            'tree',
            'lft',
            'rgt',
            'depth',
            'module',
            'image',
            'class',
            'skin',
            'description',
            'seo_url',
            'seo_title',
            'seo_desc',
            'seo_keyword',
            'promotion',
            'status',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'tree', 'lft', 'rgt', 'depth', 'module', 'image', 'class', 'skin', 'description', 'seo_url', 'seo_title', 'seo_desc', 'seo_keyword', 'promotion', 'status'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('category', 'ID'),
            'name' => Yii::t('category', 'Name'),
            'tree' => Yii::t('category', 'Tree'),
            'lft' => Yii::t('category', 'Lft'),
            'rgt' => Yii::t('category', 'Rgt'),
            'depth' => Yii::t('category', 'Depth'),
            'module' => Yii::t('category', 'Module'),
            'image' => Yii::t('category', 'Image'),
            'class' => Yii::t('category', 'Class'),
            'skin' => Yii::t('category', 'Skin'),
            'description' => Yii::t('category', 'Description'),
            'seo_url' => Yii::t('category', 'Seo Url'),
            'seo_title' => Yii::t('category', 'Seo Title'),
            'seo_desc' => Yii::t('category', 'Seo Desc'),
            'seo_keyword' => Yii::t('category', 'Seo Keyword'),
            'promotion' => Yii::t('category', 'Promotion'),
            'status' => Yii::t('category', 'Status'),
        ];
    }
}
