<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for collection "import".
 *
 * @property \MongoId|string $_id
 * @property mixed $file_path
 * @property mixed $model_namespace
 * @property mixed $map
 */
class BaseImport extends \app\components\ActiveRecord
{
    public $moduleName = 'import';
        
    public static $collectionName = 'import';
    
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
            'file_path',
            'model_namespace',
            'map',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_path', 'model_namespace', 'map'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('common', 'ID'),
            'file_path' => Yii::t('common', 'File Path'),
            'model_namespace' => Yii::t('common', 'Model'),
            'map' => Yii::t('common', 'Map'),
        ];
    }
}
