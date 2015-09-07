<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use app\components\FrontendController;
use app\modules\job\models\Job;
use app\modules\job\models\UserJob;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;


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
    
    public function beforeAction($action)
    {
        // check logined & role
        UserJob::checkAccess('recruiter');

        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->getQueryParams();
        $searchModel = new Job();
        $searchModel->created_by = Yii::$app->user->getId();
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams);

        //update breadcrubs
        Yii::$app->view->title = Yii::t($this->module->id, 'Currently Posted');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
            
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
   
    public function actionPost()
    {
        $model = new Job;
        $model->scenario = 'post';
        
        if ($model->load(Yii::$app->request->post())){
            if ($model->validate()){
                //job functions
                $jobFunctions = (array)$model->functions;
                if ($model->function2 && !in_array($model->function2, $jobFunctions)){
                    array_push($jobFunctions, $model->function2);
                }
                if ($model->function3 && !in_array($model->function3, $jobFunctions)){
                    array_push($jobFunctions, $model->function3);
                }
                $model->functions = $jobFunctions;
                
                //job industry
                $jobIndustry = (array)$model->industry;
                if ($model->industry2 && !in_array($model->industry2, $jobIndustry)){
                    array_push($jobIndustry, $model->industry2);
                }
                $model->industry = $jobIndustry;
                
                $model->status = Job::STATUS_NEW;
                $model->created_by = Yii::$app->user->getId();
                $model->created_time = new \MongoDate();
                $model->updated_time = new \MongoDate();
                
                try {
                    if($model->save()){
                        //set success flash message
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                            'duration' => 5000,
                            'icon' => 'fa fa-users',
                            'message' => Yii::t($this->module->id, Html::encode('Post job successfully.')),
                            'title' => Yii::t('app', Html::encode('Success')),
                        ]);
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
                
                //set error flash message
                Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger',
                    'duration' => 5000,
                    'icon' => 'fa fa-users',
                    'message' => $error_messages,
                    'title' => Yii::t('app', Html::encode('Errors')),
                ]);
            }
        }else{
            Yii::$app->view->title = Yii::t($this->module->id, 'Post New Job');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Jobs'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        }
        
        return $this->render('post', [
            'model' => $model,
        ]);
    }
    
    /**
     * Displays a single Job model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        //update hits
//        $cookieName = "job_".Yii::$app->user->getId()."_{$id}";
//        if (!Yii::$app->request->cookies->has($cookieName)){
//            //update hits
//            $model->hits = ++$model->hits;
//            $model->update();
//
//            //make a cookie
//            $cookies = Yii::$app->response->cookies;
//            $cookies->add(new \yii\web\Cookie([
//                'name' => $cookieName,
//                'value' => $model->hits,
//                'expire' => time() + 86400 * 1, // one day
//            ]));
//        }
        
        //update breadcrumbs
        Yii::$app->view->title = $model->title;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Jobs'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'post';
        
        //tuning data
        if (sizeof($model->functions) === 3){
            list($model->functions, $model->function2, $model->function3) = $model->functions;
        }
        else if (sizeof($model->functions) === 2){
            list($model->functions, $model->function2) = $model->functions;
        }
        //industry
        if (sizeof($model->industry) === 2){
            list($model->industry, $model->industry2) = $model->industry;
        }
        
        if ($model->load(Yii::$app->request->post())){
            if ($model->validate()){
                //job functions
                $jobFunctions = (array)$model->functions;
                if ($model->function2 && !in_array($model->function2, $jobFunctions)){
                    array_push($jobFunctions, $model->function2);
                }
                if ($model->function3 && !in_array($model->function3, $jobFunctions)){
                    array_push($jobFunctions, $model->function3);
                }
                $model->functions = $jobFunctions;
                
                //job industry
                $jobIndustry = (array)$model->industry;
                if ($model->industry2 && !in_array($model->industry2, $jobIndustry)){
                    array_push($jobIndustry, $model->industry2);
                }
                $model->industry = $jobIndustry;

                $model->updated_time = new \MongoDate();
                
                try {
                    if($model->save()){
                        //set success flash message
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                            'duration' => 5000,
                            'icon' => 'fa fa-users',
                            'message' => Yii::t($this->module->id, Html::encode('Updated job information successfully.')),
                            'title' => Yii::t('app', Html::encode('Success')),
                        ]);
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
                
                //set error flash message
                Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger',
                    'duration' => 5000,
                    'icon' => 'fa fa-users',
                    'message' => $error_messages,
                    'title' => Yii::t('app', Html::encode('Errors')),
                ]);
            }
        }else{
            Yii::$app->view->title = Yii::t($this->module->id, 'Update Job Information');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Jobs'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
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
