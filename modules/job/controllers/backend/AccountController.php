<?php

namespace app\modules\job\controllers\backend;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\job\models\User;
use app\modules\job\models\UserJob;
use app\modules\job\models\UserJobSeekerResume;

/**
 * AccountController implements the CRUD actions for UserJob model.
 */
class AccountController extends BackendController
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
     * Lists all UserJob models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->getQueryParams();

        $searchModel = new UserJob;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams);

        Yii::$app->view->title = Yii::t($this->module->id, 'Manage Members');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Members'), 'url' => ['index']];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single UserJob model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        Yii::$app->view->title = $model->user->email;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Members'), 'url' => ['index']];

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing UserJob model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelUser = User::findOne($id);
        $modelUserJob = UserJob::findOne($id);

        if (!isset($modelUser, $modelUserJob)) {
            throw new NotFoundHttpException("The user was not found.");
        }

        if ($modelUser->load(Yii::$app->request->post()) && $modelUserJob->load(Yii::$app->request->post())) {
            $modelUserValidate = $modelUser->validate();
            $modelUserJobValidate = $modelUserJob->validate();

            if ($modelUserValidate && $modelUserJobValidate) {
                $modelUserJob->email = $modelUser->email;

                if ($modelUser->save(false) && $modelUserJob->save(false)) {
                    if ($modelUserJob->role == 'seeker') {
                        UserJobSeekerResume::updateAll(['nationality' => $modelUserJob->seeker_nationality, 'salary' => $modelUserJob->seeker_salary], ['_id' => $modelUserJob->_id]);
                    }

                    if (Yii::$app->request->post('save_type') !== 'apply') {
                        return $this->redirect(['view', 'id' => (string) $modelUser->_id]);
                    }
                }
            }
        }

        Yii::$app->view->title = Yii::t('yii', 'Update');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Members'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('form', [
            'modelUser' => $modelUser,
            'modelUserJob' => $modelUserJob,
        ]);
    }

    /**
     * Deletes an existing UserJob model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can(UserJob::moduleName() . ':delete'))
            return $this->render('//message', ['messages' => ['danger' => Yii::t('yii', 'You are not allowed to perform this action.')]]);

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserJob model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return UserJob the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserJob::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
