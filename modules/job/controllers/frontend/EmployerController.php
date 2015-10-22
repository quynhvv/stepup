<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use app\components\FrontendController;
use yii\filters\VerbFilter;
use app\modules\job\models\UserJob;
use app\modules\job\models\Job;
use yii\helpers\Html;

class EmployerController extends FrontendController {

    public function behaviors()
    {
        $data = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-job' => ['post'],
                ],
            ],
        ];
        return array_merge(parent::behaviors(), $data);
    }
    
    public function beforeAction($action) {
        // check logined & role
        UserJob::checkAccess('employer');

        return parent::beforeAction($action);
    }

    public function actionIndex() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Employer Home');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('index');
    }

    public function actionDashboard() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Dashboard');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('dashboard');
    }

    public function actionPostJob() {
        $model = new Job;
        $model->setScenario('post');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //job functions
                $jobFunctions = (array) $model->functions;
                if ($model->function2 && !in_array($model->function2, $jobFunctions)) {
                    array_push($jobFunctions, $model->function2);
                }
                if ($model->function3 && !in_array($model->function3, $jobFunctions)) {
                    array_push($jobFunctions, $model->function3);
                }
                $model->functions = $jobFunctions;

                //job industry
                $jobIndustry = (array) $model->industry;
                if ($model->industry2 && !in_array($model->industry2, $jobIndustry)) {
                    array_push($jobIndustry, $model->industry2);
                }
                $model->industry = $jobIndustry;

                $model->status = Job::STATUS_NEW;
                $model->created_by = Yii::$app->user->getId();
                $model->created_time = new \MongoDate();
                $model->updated_time = new \MongoDate();

                try {
                    if ($model->save()) {
                        //set success flash message
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                            'duration' => 5000,
                            'icon' => 'fa fa-users',
                            'message' => Yii::t($this->module->id, Html::encode('Post job successfully.')),
                            'title' => Yii::t('app', Html::encode('Success')),
                        ]);
                        //redirect to list
                        return $this->redirect(['list-job']);
                    }
                } catch (CDbException $e) {
                    throw new \yii\web\HttpException(405, Yii::t('app', 'Error saving data'));
                } catch (Exception $e) {
                    throw new \yii\web\HttpException(405, Yii::t('app', 'Error saving data'));
                }
            } else {
                $error_messages = array();
                foreach ($model->errors as $attribute => $errors) {
                    foreach ($errors as $error_message) {
                        $error_messages[] = "- " . Yii::t($this->module->id, $error_message);
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
        } else {
            Yii::$app->view->title = Yii::t($this->module->id, 'Post New Job');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Jobs'), 'url' => ['list-job']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        }

        return $this->render('post-job', [
            'model' => $model,
        ]);
    }
    
    public function actionListJob()
    {
        $searchModel = new Job();
        $searchModel->setScenario('search');

        $params = Yii::$app->request->getQueryParams();
        $params['Job']['created_by'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params, 20);

        //update breadcrubs
        Yii::$app->view->title = Yii::t($this->module->id, 'Currently Posted');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
            
        return $this->render('list-job', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    /**
     * Displays a single Job model.
     * @param string $id
     * @return mixed
     */
    public function actionViewJob($id) {
        $model = $this->findJobModel($id);

        //update breadcrumbs
        Yii::$app->view->title = $model->title;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Jobs'), 'url' => ['list-job']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('view-job', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateJob($id) {
        $model = $this->findJobModel($id);
        $model->setScenario('post');
        
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
                        return $this->redirect(['list-job']);
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
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Jobs'), 'url' => ['list-job']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        }

        return $this->render('update-job', [
            'model' => $model,
        ]);
    }
    
     /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteJob($id) {
        $this->findJobModel($id)->delete();
        return $this->redirect(['list-job']);
    }
    
    protected function findJobModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
