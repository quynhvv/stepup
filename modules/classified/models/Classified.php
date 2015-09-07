<?php

namespace app\modules\classified\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;

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
 * @property mixed $creator
 * @property mixed $create_time
 * @property mixed $editor
 * @property mixed $update_time
 * @property mixed $seo_url
 * @property mixed $seo_title
 * @property mixed $seo_desc
 */
class Classified extends BaseClassified
{
    public static $options = [
        'target' => [
            'Người yêu',
            'Người tình',
            'Bạn nói chuyện'
        ]
    ];
    
    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'search' => ['title', 'description', 'target', 'about_me', 'about_you', 'image', 'category', 'creator', 'create_time', 'editor', 'update_time', 'seo_url', 'seo_title', 'seo_desc', 'status', 'promotion'],
            'default' => ['title', 'description', 'target', 'about_me', 'about_you', 'image', 'category', 'creator', 'create_time', 'editor', 'update_time', 'seo_url', 'seo_title', 'seo_desc', 'status', 'promotion']
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
        
        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'create_time' => $this->create_time,
            'target' => $this->target,
            'status' => $this->status,
            'about_me' => $this->about_me,
            'about_you' => $this->about_you,
            'category' => $this->category,
            'creator' => $this->creator,
        ]);

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'title', $this->title]);

        if (\app\helpers\ArrayHelper::getValue($params, 'sort') == NULL)
            $query->orderBy('create_time DESC');
        
        return $dataProvider;
    }
    
    public function getCreatorby(){
        return $this->hasOne(\app\modules\account\models\User::className(), ['_id' => 'creator']);
    }
}
