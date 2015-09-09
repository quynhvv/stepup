<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

use app\components\FrontendController;
use app\modules\job\models\Job;
use app\modules\job\models\User;
use app\modules\job\models\UserJob;
use app\modules\job\models\UserJobSeekerResume;
use app\modules\job\models\UserJobSeekerEmployment;

class SeekerController extends FrontendController
{

    public function beforeAction($action)
    {
        // check logined & role
        UserJob::checkAccess('seeker');

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        // Có thể sẽ dùng widget chỗ này, vì nó ko cần phân trang
        $searchModel = new Job;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search([], 10);

        Yii::$app->view->title = Yii::t($this->module->id, 'Seeker');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionJobSearch()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/job/account/login', 'role' => 'seeker']);
        }

        $searchModel = new Job;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), 20);

        Yii::$app->view->title = Yii::t($this->module->id, 'Seeker');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('job-search', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Job model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionJobDetail($id)
    {
        $model = Job::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        Yii::$app->view->title = $model->title;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, ucfirst($this->module->id)), 'url' => ['index']];

        return $this->render('job-detail', [
            'model' => $model
        ]);
    }

    public function actionResume() {
        // Xu ly avatar
        $modelUser = User::findOne(Yii::$app->user->id);
        if ($modelUser == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $modelUserJob = UserJob::findOne(Yii::$app->user->id);
        if ($modelUserJob == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = UserJobSeekerResume::findOne(Yii::$app->user->id);
        if ($model == null) {
            $model = new UserJobSeekerResume();
            $model->_id = Yii::$app->user->id;
            $model->nationality = $modelUserJob->seeker_nationality;
            $model->salary = $modelUserJob->seeker_salary;
        }
        
        $employments = UserJobSeekerEmployment::find()->where(['seeker_id' => Yii::$app->user->id])->indexBy('_id')->all();
        if ($employments == null) {
            $employments = new UserJobSeekerEmployment;
            $employments->seeker_id = $model->_id;
        }

        if ($model->load(Yii::$app->request->post()) && $modelUser->load(Yii::$app->request->post())) {
            $modelValidate = $model->validate();
            $modelUserValidate = $modelUser->validate();

            if (!is_array($employments)) {
                $employments->load(Yii::$app->request->post());
                $employmentsValidate = $employments->validate();
            } else {
                $employmentsValidate = Model::loadMultiple($employments, Yii::$app->request->post()) && Model::validateMultiple($employments);
            }

            if ($employmentsValidate && $modelValidate && $modelUserValidate && $model->save(false) && $modelUser->save(false)) {
                $modelUserJob->seeker_nationality = $model->nationality;
                $modelUserJob->seeker_salary = $model->salary;
                $modelUserJob->save();

                if (!is_array($employments)) {
                    $employments->save();
                } else if (isset($employmentsValidate) && $employmentsValidate == true) {
                    foreach ($employments as $employment) {
                        $employment->save(false);
                    }
                }

                Yii::$app->getSession()->setFlash('flash', [
                    'type' => 'success',
                    'title' => Yii::t('common', 'Message'),
                    'message' => Yii::t('common', 'Your data has been successfully saved'),
                    'duration' => 10000
                ]);

                return $this->refresh();
            }
        }

        Yii::$app->view->title = Yii::t($this->module->id, 'Resume');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('resume', [
            'model' => $model,
            'modelUser' => $modelUser,
            'employments' => $employments
        ]);
    }

    public function actionResumeEmploymentForm($id) {
        Yii::$app->response->format = 'json';

        $model = UserJobSeekerResume::findOne($id);
        if ($model === null) {
            return ['status' => 'error'];
        }

        $employment = new UserJobSeekerEmployment(['scenario' => 'create']);
        $employment->seeker_id = $model->_id;
        if ($employment->save()) {
            return [
                'status' => 'success',
                'content' => $this->renderAjax('resume-employment', ['model' => $model, 'employment' => $employment, 'index' => $employment->_id])
            ];
        }

        return ['status' => 'error'];
    }

    public function actionEmploymentRemove($id) {
        Yii::$app->response->format = 'json';

        $model = UserJobSeekerEmployment::findOne($id);
        if ($model != null && $model->delete()) {
            return ['status' => 'success'];
        }

        return ['status' => 'error'];
    }

    public function actionInformation() {
        $model = UserJobSeekerResume::findOne(Yii::$app->user->id);
        if ($model == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        Yii::$app->view->title = Yii::t($this->module->id, 'Information');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('information', ['model' => $model]);
    }
    
    public function actionViewProfile()
    {
        return $this->redirect(['/job/seeker/information']);
    }

    public function actionDashboard() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Dashboard');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('dashboard');
    }

    public function actionPricing() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Pricing – Job Seeker');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('pricing');
    }

}
