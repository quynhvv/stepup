<?php

namespace app\modules\message\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\modules\account\models\User;

class MessageUser extends BaseMessageUser
{

    public static function moduleName(){
        return 'message';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['message_id', 'user_id'], 'required']
        ]);
    }

    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'search' => ['_id', 'type_id', 'user_id', 'message_id', 'is_read', 'is_follow', 'updated_at'],
        ]);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'user_id']);
    }

    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['_id' => 'message_id']);
    }

    public function beforeSave($insert) {
        $this->updated_at = new \MongoDate();
        $this->category_id = (int) $this->category_id;

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

        $query->andWhere(['user_id' => Yii::$app->user->id]);
        $query->andWhere(['user_id' => Yii::$app->user->id]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // condition here
        $query->andFilterWhere(['like', 'type_id', $this->type_id])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'message_id', $this->message_id])
            ->andFilterWhere(['like', 'is_read', $this->is_read])
            ->andFilterWhere(['like', 'is_delete', $this->is_delete])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }

}
