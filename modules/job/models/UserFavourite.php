<?php

namespace app\modules\job\models;

use Yii;

/**
 * This is the model class for collection "user_favourite".
 *
 * @property \MongoId|string $_id
 * @property mixed $object_id
 * @property mixed $object_type // seeker/job
 * @property mixed $created_by
 * @property mixed $created_time
 */
class UserFavourite extends BaseUserFavourite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id','object_type','created_by','created_time'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['object_id', 'object_type', 'created_by', 'created_time']
        ];
    }
    
    public static function isFavourite($objectId, $objectType, $createdBy){
        $model = UserFavourite::findOne(['object_id' => $objectId, 'object_type' => $objectType, 'created_by' => $createdBy]);
        return ($model) ? true : false;
    }
}
