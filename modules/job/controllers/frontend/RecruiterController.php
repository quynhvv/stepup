<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use app\components\FrontendController;
use yii\filters\VerbFilter;
use app\modules\job\models\User;
use app\modules\job\models\UserJob;
use app\modules\job\models\Project;


class RecruiterController extends FrontendController
{

    public function beforeAction($action)
    {
        // check logined & role
        UserJob::checkAccess('recruiter');

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->view->title = Yii::t($this->module->id, 'Recruiter');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('index');
    }

    public function actionDashboard() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Dashboard');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('dashboard');
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
        $this->render('projects', ['model'=>$model, 'searchModel'=> $searchModel, 'dataProvider' => $dataProvider]);
    }
    
    public function actionViewProfile()
    {
        $userJob = UserJob::findOne(['_id' => Yii::$app->user->identity->_id]);
        
        Yii::$app->view->title = Yii::t($this->module->id, 'My Profile');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        $this->render('view-profile', ['userJob' => $userJob]);
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
        
        $this->render('edit-profile', ['model'=> $model, 'jobModel' => $jobModel]);
    }
}
