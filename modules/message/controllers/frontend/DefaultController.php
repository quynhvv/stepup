<?php

namespace app\modules\message\controllers\frontend;

use app\helpers\ArrayHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use app\components\FrontendController;

use app\modules\account\models\User;
use app\modules\message\models\Message;
use app\modules\message\models\MessageUser;



/**
 * DefaultController implements the CRUD actions for Message model.
 */
class DefaultController extends FrontendController
{

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/job/frontend/account/login', 'return' => Yii::$app->request->url]);
        }

        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $paramType = (int) Yii::$app->request->getQueryParam('type', 0);
        $paramCategory = (int) Yii::$app->request->getQueryParam('category', 0);

        if (($paramType != 0 && !in_array($paramType, Message::$typeAllows)) || ($paramCategory != 0 && !in_array($paramCategory, Message::$categoryAllows))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $query = MessageUser::find()->with(['message', 'message.user']);
        $query->andWhere(['is_delete' => 0, 'user_id' => Yii::$app->user->id]);
        $query->orderBy(['is_read' => SORT_ASC, 'updated_at' => SORT_DESC]);

        if ($paramCategory != 0) {
            $query->andWhere(['category_id' => $paramCategory]);
        } else if ($paramType != 0) {
            $query->andWhere(['type_id' => $paramType]);
        } else {
            $paramType = Message::TYPE_INBOX;
            $query->andWhere(['type_id' => $paramType]);
        }

        $keyword = filter_var(Yii::$app->request->get('keyword'), FILTER_SANITIZE_SPECIAL_CHARS);
        if (!empty($keyword)) {
            $paramUserIds = [];
            $paramMessageIds = [];

            $modelUser = User::find()
                ->select(['_id'])
                ->orFilterWhere(['like', 'email', $keyword])
                ->orFilterWhere(['like', 'display_name', $keyword])
                ->asArray()
                ->all();

            if (!empty($modelUser)) {
                foreach ($modelUser as $user) {
                    $paramUserIds[] = $user['_id'];
                }
            }


            $modelMessage = Message::find()
                ->select(['_id'])
                ->orFilterWhere(['created_by' => $paramUserIds])
                ->orFilterWhere(['like', 'subject', $keyword])
                ->asArray()
                ->all();

            if (!empty($modelMessage)) {
                foreach ($modelMessage as $message) {
                    $paramMessageIds[] = $message['_id'];
                }
            }


            if (!empty($paramMessageIds)) {
                $query->andWhere(['in', 'message_id', $paramMessageIds]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        Yii::$app->view->title = Yii::t('message', 'Message');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('message', 'Message'), 'url' => ['index']];

        return $this->render('index', [
            'paramType' => $paramType,
            'paramCategory' => $paramCategory,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSent()
    {
        $query = Message::find()->with(['user']);
        $query->andWhere(['created_by' => Yii::$app->user->id]);
        $query->orderBy(['created_at' => SORT_DESC]);

        $modelSearch = new Message(['scenario' => 'search']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $modelSearch->load(Yii::$app->request->getQueryParams());
        if ($modelSearch->validate()) {
            $query->andFilterWhere(['like', 'subject', $modelSearch->subject])
                ->andFilterWhere(['like', 'content', $modelSearch->content])
                ->andFilterWhere(['like', 'created_at', $modelSearch->created_at]);
        }

        Yii::$app->view->title = Yii::t('message', 'Message');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('message', 'Message'), 'url' => ['index']];

        return $this->render('sent', [
            'modelSearch' => $modelSearch,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var $model \app\modules\message\models\Message */
        /** @var $modelUser \app\modules\message\models\MessageUser */

        if (($model = Message::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // Cap nhat trang thai tin nhan da doc
        MessageUser::updateAll(['is_read' => 1], ['message_id' => $model->primaryKey, 'user_id' => Yii::$app->user->id]);

        // Khoi tao form tra loi tin nhan
        $modelReply = new Message(['scenario' => 'reply']);
        $modelReply->message_id = $model->primaryKey;

        if ($modelReply->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;


            if (!$modelReply->validate()) {
                return [
                    'status' => 0,
                    'errors' => $modelReply->errors
                ];
            }

            if ($modelReply->save()) {
                // Cap nhat trang thai chua doc cho tat ca cac user
                $users = $model->users;
                if (($key = array_search(Yii::$app->user->id, $users)) !== false)
                    unset($users[$key]);
                $users = array_values($users); // Reset key
                MessageUser::updateAll(['is_delete' => 0, 'is_read' => 0, 'type_id' => Message::TYPE_INBOX ,'updated_at' => new \MongoDate()], ['message_id' => $model->primaryKey, 'user_id' => $users]);

                foreach ($users as $userId) {
                    $modelMessageUser = MessageUser::find()->where(['message_id' => $model->primaryKey, 'user_id' => $userId])->one();
                    if ($modelMessageUser != null) {
                        // Send email
                        $mailer = \Yii::$app->mailer;
                        $mailer->viewPath = '@app/modules/message/mail';

                        $mailer->compose(['html' => 'messageReply-html', 'text' => 'messageReply-text'], ['model' => $model, 'modelMessageUser' => $modelMessageUser])
                            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                            ->setTo($modelMessageUser->user->email)
                            ->setSubject(Yii::t('message', 'Message notifications'))
                            ->send();
                    }
                }

                return [
                    'status' => 1,
                    'content' => $this->renderAjax('viewItem', [
                        'model' => $modelReply
                    ])
                ];
            }
        }

        $query = Message::find()->with('user');
        $query->orWhere(['_id' => $model->primaryKey]);
        $query->orWhere(['message_id' => $model->primaryKey]);
        $query->orderBy(['created_at' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        Yii::$app->view->title = $model->subject;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('message', 'Message'), 'url' => ['index']];

        return $this->render('view', [
            'model' => $model,
            'modelReply' => $modelReply,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message(['scenario' => 'new']);

        if ($model->load(Yii::$app->request->post())) {

            // Danh sach cac user(s) tuong tac voi tin nhan nay
            $users = $model->users;
            $users[] = Yii::$app->user->id;
            $users = array_unique($users);
            $model->users = $users;

            if ($model->save()) {
                // Cap nhat thon tin nguoi nhan. Nen chuyen sang batch chay cho nhanh
                foreach ($model->users as $userId) {
                    $modelMessageUser = new MessageUser();
                    $modelMessageUser->user_id = $userId;
                    $modelMessageUser->message_id = $model->_id;
                    $modelMessageUser->category_id = $model->category_id;
                    $modelMessageUser->is_delete = 0;

                    $modelMessageUser->type_id = Message::TYPE_INBOX;
                    $modelMessageUser->is_read = 0;

                    if ($userId == $model->created_by) {
                        $modelMessageUser->type_id = Message::TYPE_SENT;
                        $modelMessageUser->is_read = 1;
                    }

                    if ($modelMessageUser->save()) {
                        if ($userId != $model->created_by && !empty($modelMessageUser->user->email)) {
                            // Send email
                            $mailer = \Yii::$app->mailer;
                            $mailer->viewPath = '@app/modules/message/mail';

                            $mailer->compose(['html' => 'messageNew-html', 'text' => 'messageNew-text'], ['model' => $model, 'modelMessageUser' => $modelMessageUser])
                                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                                ->setTo($modelMessageUser->user->email)
                                ->setSubject(Yii::t('message', 'Message notifications'))
                                ->send();
                        }
                    }
                }

                return $this->redirect(['index']);
            }
        }

        Yii::$app->view->title = Yii::t('yii', 'Create');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('message', 'Message'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        /** @var $model \app\modules\message\models\Message */
        $userId = Yii::$app->user->id;

        if (($model = Message::find()->where(['_id' => $id, 'users' => [$userId]])->one()) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // Neu day chi la nguoi nhan
        if ($model->created_by != $userId) {
            MessageUser::updateAll(['is_delete' => 1], ['message_id' => $model->primaryKey, 'user_id' => $userId]);
            return $this->redirect(['index']);
        }

        // Neu day la nguoi tao message
        // Xoa du lieu lien quan
        Message::deleteAll(['message_id' => $model->primaryKey]);
        MessageUser::deleteAll(['message_id' => $model->primaryKey]);

        // Xoa message chinh
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionBulkDelete() {
        /** @var $model \app\modules\message\models\Message */

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!isset($_POST['keys'])) {
            return ['status' => 0];
        }

        $keys = Yii::$app->request->getBodyParam('keys');
        if (!is_array($keys) || empty($keys)) {
            return ['status' => 0];
        }

        $messageIds = [];
        if (($modelMessageUser = MessageUser::find()->where(['_id' => $keys])->all()) != null) {
            foreach ($modelMessageUser as $dataMessageUser) {
                $messageIds[] = $dataMessageUser->message_id;
            }
        }
        if (empty($messageIds)) {
            return ['status' => 0];
        }

        $userId = Yii::$app->user->id;
        if (($modelMessage = Message::find()->where(['_id' => $messageIds])->all()) == null) {
            return ['status' => 0];
        }

        foreach ($modelMessage as $model) {
            // Neu day chi la nguoi nhan
            if ($model->created_by != $userId) {
                MessageUser::updateAll(['is_delete' => 1], ['message_id' => $model->primaryKey, 'user_id' => $userId]);
                continue;
            }

            // Neu day la nguoi tao message
            // Xoa du lieu lien quan
            Message::deleteAll(['message_id' => $model->primaryKey]);
            MessageUser::deleteAll(['message_id' => $model->primaryKey]);

            // Xoa message chinh
            $model->delete();
        }

        return ['status' => 1];
    }

    public function actionUserList($q = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {
            $q = filter_var($q, FILTER_SANITIZE_SPECIAL_CHARS);

            $query = User::find();
            $query->where(['status' => '1']);
            $query->andWhere(['NOT', '_id', Yii::$app->user->id]);
            $query->andWhere(['LIKE', 'email', $q]);
            $query->orderBy('email');
            $query->limit(100);

            $data = [];
            if (($models = $query->all()) != null) {
                foreach ($models as $model) {
                    $data[] = [
                        'id' => $model->primaryKey,
                        'text' => "$model->display_name ({$model->email})",
                    ];
                }
            }

            $out['results'] = $data;
        }

        return $out;
    }

}
