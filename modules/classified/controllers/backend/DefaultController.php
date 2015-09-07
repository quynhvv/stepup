<?php

namespace app\modules\classified\controllers\backend;

use Yii;
use app\components\BackendController;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\modules\classified\models\Classified;

class DefaultController extends BackendController {

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

    public function actionIndex() {
        $queryParams = Yii::$app->request->getQueryParams();
        $searchModel = new Classified;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams);

        Yii::$app->view->title = Yii::t($this->module->id, ucfirst($this->module->id));
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    public function actionCreate(){
        $model = new Classified;
        if ($model->load(Yii::$app->request->post()) AND $model->save()) {

            if ($model->validate()) {
                if (Yii::$app->request->post('save_type') == 'apply')
                    return $this->redirect(['update', 'id' => (string) $model->_id]);
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            } else {
                var_dump($model->getErrors());
                die;
            }
        } else {

            Yii::$app->view->title = Yii::t($this->module->id, 'Create classified');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Classified'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

            return $this->render('form', [
                    'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing Classified model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            return $this->redirect(['update', 'id' => (string) $model->_id]);
        } else {

            Yii::$app->view->title = Yii::t($this->module->id, 'Edit "{title}"', ['title' => $model->title]);
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Classified'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

            return $this->render('form', [
                'model' => $model,
            ]);
        }
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
    protected function findModel($id) {
        if (($model = Classified::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
