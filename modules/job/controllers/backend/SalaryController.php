<?php

namespace app\modules\job\controllers\backend;

use Yii;
use app\modules\job\models\JobSalary;
use yii\data\ActiveDataProvider;
use app\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalaryController implements the CRUD actions for JobSalary model.
 */
class SalaryController extends BackendController
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

    public function actions()
    {
        return [
            'status' => [
                'class' => 'app\components\actions\AjaxBooleanAction',
                'modelClass' => '\app\modules\job\models\JobSalary'
            ],
        ];
    }

    /**
     * Lists all JobSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->getQueryParams();

        $searchModel = new JobSalary;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams);

        Yii::$app->view->title = Yii::t($this->module->id, 'Job Salary');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Salary'), 'url' => ['index']];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single JobSalary model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        Yii::$app->view->title = $model->title;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Salary'), 'url' => ['index']];

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new JobSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobSalary();
        $model->setDefaultValues();

        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->save()) {
                if (Yii::$app->request->post('save_type') == 'apply')
                    return $this->redirect(['update', 'id' => (string) $model->_id]);
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        } else {
            Yii::$app->view->title = Yii::t($this->module->id, 'Create');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Salary'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

            return $this->render('form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing JobSalary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->save() && Yii::$app->request->post('save_type') !== 'apply')
                return $this->redirect(['view', 'id' => (string) $model->_id]);
        }

        Yii::$app->view->title = Yii::t('yii', 'Update');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Manage Salary'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => (string) $model->primaryKey]];

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing JobSalary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can(JobSalary::moduleName() . ':delete'))
            return $this->render('//message', ['messages' => ['danger' => Yii::t('yii', 'You are not allowed to perform this action.')]]);

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the JobSalary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return JobSalary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JobSalary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
