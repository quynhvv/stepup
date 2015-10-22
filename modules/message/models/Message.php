<?php

namespace app\modules\message\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\helpers\ArrayHelper;

use app\modules\account\models\User;

class Message extends BaseMessage
{

    const CATEGORY_GENERAL = 1;
    const CATEGORY_SCOUTS = 2;
    const CATEGORY_APPLICATIONS = 3;

    const TYPE_INBOX = 1;
    const TYPE_SENT = 2;

    public static $typeAllows = [
        self::TYPE_INBOX,
        self::TYPE_SENT,
    ];

    public static $categoryAllows = [
        self::CATEGORY_GENERAL,
        self::CATEGORY_SCOUTS,
        self::CATEGORY_APPLICATIONS,
    ];

    public static function moduleName(){
        return 'message';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['content', 'string', 'min' => 10],
            [['users', 'subject', 'content'], 'required', 'on' => 'new'],
            [['users', 'content', 'message_id'], 'required', 'on' => 'reply'],
        ]);
    }

    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'new' => ['users', 'subject', 'content', 'content', 'category_id'],
            'reply' => ['content', 'message_id'],
            'search' => ['_id', 'users', 'subject', 'content', 'created_at', 'created_by', 'message_id', 'category_id'],
        ]);
    }

    public function beforeSave($insert) {
        $this->created_at = new \MongoDate();
        $this->created_by = Yii::$app->user->id;
        $this->category_id = (int) $this->category_id;

        return parent::beforeSave($insert);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'created_by']);
    }

    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['_id' => 'message_id']);
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
        $query->andFilterWhere(['like', 'users', $this->users])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'message_id', $this->message_id])
            ->andFilterWhere(['like', 'category_id', $this->category_id]);


        return $dataProvider;
    }

    // Danh sach cac user chon de gui mail
    public function getUserOptions() {
        return ArrayHelper::map(User::find()->where(['status' => '1'])->andWhere(['NOT', '_id', Yii::$app->user->id])->orderBy('email')->all(), '_id', 'email');
    }

    public static function getCategoryOptions() {
        return [
            self::CATEGORY_GENERAL => Yii::t('messsage', 'General Messages'),
            self::CATEGORY_SCOUTS => Yii::t('messsage', 'Scouts'),
            self::CATEGORY_APPLICATIONS => Yii::t('messsage', 'Applications'),
        ];
    }
    public static function getCategoryText($type) {
        if (array_key_exists($type, self::getCategoryOptions())) {
            return self::getCategoryOptions()[$type];
        }
    }

    public static function getTypeOptions() {
        return [
            self::TYPE_INBOX => Yii::t('message', 'TYPE_INBOX'),
            self::TYPE_SENT => Yii::t('message', 'TYPE_SENT'),
        ];

    }
    public static function getTypeText($type) {
        if (array_key_exists($type, self::getTypeOptions())) {
            return self::getTypeOptions()[$type];
        }
    }

    public static function countMessageUnread() {
        return MessageUser::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0])->count();
    }

    public static function countMessageByType($type) {
        return MessageUser::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0, 'type_id' => (int) $type])->count();
    }

    public static function countMessageByCategory($category) {
        return MessageUser::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0, 'category_id' => (int) $category])->count();
    }

}
