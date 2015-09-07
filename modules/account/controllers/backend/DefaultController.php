<?php

namespace app\modules\account\controllers\backend;

use Yii;
use app\components\BackendController;
use app\modules\account\models\User;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\common\controllers\backend\CropImageController;
use app\helpers\LetHelper;

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
        $searchModel = new User;
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams);

        Yii::$app->view->title = Yii::t($this->module->id, ucfirst($this->module->id));
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate() {
        // Set gia tri va check validate cho model User
        $model = new User;
        if ($model->load(Yii::$app->request->post()) AND $model->validate() AND ($modelAdditionBlocks = \app\helpers\LetHelper::saveAdditionBlocks($model))) {
            if ($model->save() AND is_array($modelAdditionBlocks)) {
                foreach($modelAdditionBlocks as $modelAdditionBlock) {
                    $modelAdditionBlock->_id = $model->_id;
                    $modelAdditionBlock->save();
                }
            }
        }

        Yii::$app->view->title = Yii::t($this->module->id, 'Create account');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Account'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) AND $model->validate() AND ($modelAdditionBlocks = \app\helpers\LetHelper::saveAdditionBlocks($model))) {
            if ($model->save() AND is_array($modelAdditionBlocks)) {
                foreach($modelAdditionBlocks as $modelAdditionBlock) {
                    $modelAdditionBlock->_id = $model->_id;
                    $modelAdditionBlock->save();
                }
            }
        }

        Yii::$app->view->title = Yii::t($this->module->id, 'Edit "{title}"', ['title' => $model->email]);
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Account'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('form', [
                'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        Yii::$app->view->title = $model->email;
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Account'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    public function actionEditinformation() {
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            return $this->redirect(['editinformation']);
        } else {

            Yii::$app->view->title = Yii::t($this->module->id, 'Edit Information "{title}"', ['title' => $model->email]);
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Account'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

            return $this->render('editinformation', [
                'model' => $model,
            ]);
        }
    }

    public function actionEditavatar() {
        $model = Yii::$app->user->identity;
        if (Yii::$app->request->post('submit')) {
            $imageUploaded = \yii\web\UploadedFile::getInstanceByName('avatar');
            $cropper = new \letyii\cropper\Cropper;
            $cropper->src = Yii::$app->request->post('src');
            $cropper->data = Yii::$app->request->post('data');
            $cropper->fileName = Yii::$app->user->id;
            $cropper->file = ($imageUploaded) ? $imageUploaded : LetHelper::getAvatar(Yii::$app->user->id, LetHelper::URL, true, 48);
            
            $md5FileName = md5(Yii::$app->user->id);
            $folder = substr($md5FileName, 0, 2) . DIRECTORY_SEPARATOR . substr($md5FileName, 2, 2) . DIRECTORY_SEPARATOR . substr($md5FileName, 4, 2);
            $cropper->folder = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . $model->moduleName . DIRECTORY_SEPARATOR . $folder;

            $cropper->crop();
        }
        
        Yii::$app->view->title = Yii::t($this->module->id, 'Edit Avatar "{title}"', ['title' => $model->email]);
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Account'), 'url' => ['index']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('editavatar', [
            'model' => $model,
        ]);


//        $model = $this->findModel(Yii::$app->user->id);
//        $submit = Yii::$app->request->post('cropImage');
//        $image = \yii\web\UploadedFile::getInstance($model, 'avatar');
//
//        Yii::$app->view->title = Yii::t($this->module->id, 'Edit Avatar "{title}"', ['title' => $model->email]);
//        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Account'), 'url' => ['index']];
//        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
//
//        if (isset($submit) && !empty($image)) {
//            $crop = new CropHelper(Yii::$app->request->post('avatar_src'), Yii::$app->request->post('avatar_data'), $image, Yii::$app->user->id);
//            $message = $crop->getMsg();
//            if (!empty($crop->getResult())) {
//                $model->avatar = $crop->getResult();
//                $model->save();
//            }
//
//            return $this->render('editavatar', [
//                'model' => $model,
//                'message' => $message
//            ]);
//        } else {
//
//        }
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
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
