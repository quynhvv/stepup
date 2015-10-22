<?php

namespace app\modules\account\controllers\frontend;

use Yii;
use app\components\FrontendController;
use app\modules\account\models\User;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DefaultController extends FrontendController {
    
    public function behaviors()
    {
        $data = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
        return array_merge(parent::behaviors(), $data);
    }
    
//    public function actionIndex()
//    {
//        $queryParams = Yii::$app->request->getQueryParams();
//        $searchModel = new User;
//        $searchModel->scenario = 'search';
//        $dataProvider = $searchModel->search($queryParams);
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//            'searchModel' => $searchModel,
//        ]);
//    }

//    public function actionSignup()
//    {
//        $model = new User;
//        $model->scenario = 'signup';
//        if ($model->load(Yii::$app->request->post()) and $model->validate()){
//            $model->status = User::STATUS_ACTIVE;
//            if($model->save())
//                $this->redirect($this->goBack());
//        }
//        else
//            var_dump ($model->errors);
//    }
    
//    public function actionLogin(){
//        $model = new User();
//        $model->scenario = 'login';
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            $this->redirect($this->goBack());
//        }
//    }
    
//    public function actionLogout()
//    {
//        Yii::$app->user->logout();
//
//        return $this->redirect($this->goHome());
//    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
//    protected function findModel($id)
//    {
//        if (($model = User::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }

}
