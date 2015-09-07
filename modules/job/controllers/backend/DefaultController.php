<?php

namespace app\modules\job\controllers\backend;

use Yii;
use app\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\job\models\Job;
//use app\modules\category\models\Category;
use yii\helpers\Url;

class DefaultController extends BackendController
{
    public function behaviors() {
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

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->getQueryParams();
        $searchModel = new Job;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams);
        
        Yii::$app->view->title = Yii::t("app", "Manage {$this->module->id}s");
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t("app", "Manage {$this->module->id}s"), 'url' => ['index']];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new Job;
  
        Yii::$app->view->title = $model->title;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, ucfirst($this->module->id)), 'url' => ['index']];
        
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
        ]);
    }
    
    /**
     * Updates Status of a Job Model
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateStatus($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())){
            if ($model->validate()){
                $model->updated_time = new \MongoDate();
                try {
                    if($model->save()){
                        //redirect to list
                        return $this->redirect(['index']);
                    }
                } catch (CDbException $e) {
                    throw new \yii\web\HttpException(405, Yii::t('app', 'Error saving data'));
                } catch (Exception $e) {
                    throw new \yii\web\HttpException(405, Yii::t('app', 'Error saving data'));
                }
            }else{
                $error_messages = array();
                foreach($model->errors as $attribute => $errors){
                    foreach ($errors as $error_message){
                        $error_messages[] = "- ". Yii::t($this->module->id, $error_message);
                    }
                }
                $error_messages = implode('<br/>', $error_messages);
                var_dump($error_messages);die();
            }
        }else{
            Yii::$app->view->title = Yii::t($this->module->id, 'Update Job Status');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Jobs'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        }

        return $this->render('update_status', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
