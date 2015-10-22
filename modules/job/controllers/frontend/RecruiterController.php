<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use app\components\FrontendController;
use yii\filters\VerbFilter;
use app\modules\job\models\User;
use app\modules\job\models\UserJob;
use app\modules\job\models\Project;
use app\modules\job\models\UserJobSeekerResume;
use app\modules\job\models\UserFavourite;
use app\modules\job\models\Job;
use yii\helpers\Html;

class RecruiterController extends FrontendController
{
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

    public function beforeAction($action)
    {
        // check logined & role
        UserJob::checkAccess('recruiter');

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->view->title = Yii::t($this->module->id, 'Recruiter Home');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        $searchModel = new UserJobSeekerResume();
        $dataProvider1 = UserJob::getHighPotentialCandidate(Yii::$app->user->identity->_id);
        $dataProvider2 = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider1' => $dataProvider1, 'dataProvider2' => $dataProvider2]);
    }
    
    public function actionHighPotentialCandidate()
    {
        Yii::$app->view->title = Yii::t($this->module->id, 'High Potential Candidates');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        $searchModel = new UserJobSeekerResume();
        $dataProvider = UserJob::getHighPotentialCandidate(Yii::$app->user->identity->_id);

        return $this->render('high-potential-candidate', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }
    
    public function actionNewCandidate()
    {
        Yii::$app->view->title = Yii::t($this->module->id, 'Newest Candidates');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        $searchModel = new UserJobSeekerResume();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), 20);

        return $this->render('new-candidate', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }
    
    public function actionSearchSeeker()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/job/account/login', 'role' => 'seeker']);
        }

        Yii::$app->view->title = Yii::t($this->module->id, 'Search Seekers');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        $searchModel = new UserJobSeekerResume();
        $searchModel->setScenario('search');
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), 20);

        return $this->render('search-seeker', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }
    
    public function actionFavouritesCandidate()
    {
        Yii::$app->view->title = Yii::t($this->module->id, 'Favourite Candidates');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        $dataProvider = UserJob::getFavouriteCandidate(Yii::$app->user->id);

        return $this->render('favourites-candidate', ['dataProvider' => $dataProvider]);
    }

    public function actionDashboard() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Dashboard');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('dashboard');
    }
    
    public function actionProjects()
    {
        $model = new Project();
        $model->setScenario('create');
        
        $searchModel = new Project();
        $searchModel->setScenario('search');
        
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), 20);
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()){
                $model->status = Project::STATUS_OFF;
                if ($model->save(false)){
                    Yii::$app->getSession()->setFlash('flash', [
                        'type' => 'success',
                        'title' => Yii::t('common', 'Message'),
                        'message' => Yii::t('common', 'Created succesfully.'),
                        'duration' => 10000
                    ]);
                    return $this->redirect(['projects']);
                }
            }
        }
        
        Yii::$app->view->title = Yii::t($this->module->id, 'Projects');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        return $this->render('projects', ['model'=>$model, 'searchModel'=> $searchModel, 'dataProvider' => $dataProvider]);
    }
    
    public function actionViewProfile()
    {
        $userJob = UserJob::findOne(['_id' => Yii::$app->user->identity->_id]);
        
        Yii::$app->view->title = Yii::t($this->module->id, 'My Profile');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('view-profile', ['userJob' => $userJob]);
    }
    
    public function actionEditProfile()
    {
        $jobModel = UserJob::findOne(['_id' => Yii::$app->user->identity->_id]);
        $jobModel->scenario = "edit_recruiter";
        
        $model = User::findOne(['_id' => Yii::$app->user->identity->_id]);
        $model->scenario = "edit_recruiter";
        
        if ($model->load(Yii::$app->request->post()) && $jobModel->load(Yii::$app->request->post())) {
            $modelValidate = $model->validate();
            $jobModelValidate = $jobModel->validate();

            if ($modelValidate && $jobModelValidate) {
                if ($model->save(false)) {
                    if ($jobModel->save(false)){
                        Yii::$app->getSession()->setFlash('flash', [
                            'type' => 'success',
                            'title' => Yii::t('account', 'Message'),
                            'message' => Yii::t('account', 'Updated succesfully.'),
                            'duration' => 10000
                        ]);
                        
                        return $this->redirect(['view-profile']);
                    }
                }
            }
        }
        
        Yii::$app->view->title = Yii::t($this->module->id, 'Edit Profile');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('edit-profile', ['model'=> $model, 'jobModel' => $jobModel]);
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
                        return $this->redirect(['index']);
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
        $searchModel->created_by = Yii::$app->user->id;
        
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
    
    public function actionUpgradeAccount()
    {
        Yii::$app->view->title = Yii::t($this->module->id, 'Upgrade Account');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('upgrade-account', []);
    }
}
