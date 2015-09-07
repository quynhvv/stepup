<?php

namespace app\modules\common\controllers\backend;

use Yii;
use app\components\BackendController;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use app\modules\common\models\Import;
use app\helpers\FileHelper;
use app\helpers\StringHelper;

class ImportController extends BackendController {

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
//        if (!Yii::$app->user->can(Product::moduleName() . ':view'))
//            $queryParams['Product']['creator'] = Yii::$app->user->id;
        $searchModel = new Import;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams);

        Yii::$app->view->title = Yii::t($this->module->id, 'Import');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Import'), 'url' => ['index']];

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate() {
        $model = new Import;

        if ($model->load(Yii::$app->request->post())) {
            $file_path = \yii\web\UploadedFile::getInstance($model, 'file_path');
            if (!empty($file_path)) {
                $model->file_path = \yii\web\UploadedFile::getInstance($model, 'file_path');
                $ext = FileHelper::getExtention($model->file_path);
                if (!empty($ext)) {
                    $fileDir = Yii::$app->controller->module->id . '/' . date('Y/m/d/');
                    $fileName = uniqid() . StringHelper::asUrl(Yii::$app->controller->module->id) . '.' . $ext;
                    $folder = Yii::$app->params['uploadPath'] . '/' . Yii::$app->params['uploadDir'] . '/' . $fileDir;
                    FileHelper::createDirectory($folder);
                    $model->file_path->saveAs($folder . $fileName);
                    $model->file_path = $fileDir . $fileName;
                }
            }
            if ($model->save()) {
                return $this->redirect(['update', 'id' => (string) $model->_id]);
            }
        }
        Yii::$app->view->title = Yii::t($this->module->id, 'Create');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Import'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->post('save_type') == 'apply')
                return $this->redirect(['update', 'id' => (string) $model->_id]);
            else if (Yii::$app->request->post('save_type') == 'import')
                return $this->redirect(['import/import', 'id' => (string) $model->_id]);
            else
                return $this->redirect(['index', 'id' => (string) $model->_id]);
        }
        
        Yii::$app->view->title = Yii::t($this->module->id, 'Update');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, ucfirst($this->module->id)), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionImport($id) {
        $model = $this->findModel($id);
        
        $model->importDataExcel();
        
        $this->redirect(['update', 'id' => (string) $model->_id]);
    }
    
    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can((new Import)->moduleName . ':delete'))
            return $this->render('//message', ['messages' => ['danger' => Yii::t('yii', 'You are not allowed to perform this action.')]]);

        $model = $this->findModel($id);
        if ($model->delete()){ // Neu xoa du lieu thanh cong thi xoa file cua du lieu do.
            unlink(Yii::$app->params['uploadPath'] . Yii::$app->params['uploadDir'] . '/' . $model->file_path);
        }
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
        if (($model = Import::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
