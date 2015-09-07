<?php

namespace app\modules\category\controllers\backend;

use Yii;
use app\components\BackendController;
use app\modules\category\models\Category;
use yii\helpers\Url;
use yii\filters\VerbFilter;

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
        $module = Yii::$app->request->get('module');
        $modules = Category::getModules();
        $model = new Category;
        if ($module) {
            $tree = Category::findOne(['module' => $module, $model->leftAttribute => 1]);
            if ($tree) {
                $tree = $tree->buildTreeHtml([], [], [
                    'actions' => '<div class="btn-group pull-right">
                        <span class="btn btn-success btn-xs" onclick="createCategory(\'{_id}\')"><i class="glyphicon glyphicon-plus"></i></span>
                        <a class="btn btn-info btn-xs" href="' . Url::to(['/category/backend/default/update']) . '?id={_id}"><i class="glyphicon glyphicon-pencil"></i></a>
                        <span class="btn btn-danger btn-xs" onclick="deleteCategory(\'{_id}\')"><i class="glyphicon glyphicon-trash"></i></span>
                        </div>',
                    'id' => 'nestable_category',
                ]);
            }
        } else
            $tree = null;

        Yii::$app->view->title = Yii::t($this->module->id, ucfirst($this->module->id));
        if ($module)
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($module, ucfirst($module)), 'url' => ['/' . $module . '/default']];
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('index', [
            'tree' => $tree,
            'modules' => $modules,
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id){
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            if (Yii::$app->request->post('save_type') == 'apply')
                return $this->redirect(['update', 'id' => (string) $model->_id]);
            return $this->redirect(['index', 'module' => $model->module]);
        } else {
            Yii::$app->view->title = Yii::t($this->module->id, 'Edit "{title}"', ['title' => $model->name]);
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($model->module, ucfirst($model->module)), 'url' => ['/' . $model->module . '/default']];
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('category', 'Category'), 'url' => ['/category/default', 'module' => $model->module]];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
            
            return $this->render('form', [
                'model' => $model,
            ]);
        }
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
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
