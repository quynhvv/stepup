<?php

namespace app\modules\common\controllers\backend;

use Yii;
use app\components\BackendController;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use app\modules\common\models\Setting;
use app\helpers\ArrayHelper;

class SettingController extends BackendController
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

    public function actionIndex()
    {
        Yii::$app->view->title = Yii::t('common', 'Setting');
        $module = Yii::$app->request->get('module', '');
        if (!empty($module)){
            $label = Yii::t($module, ucfirst($module));
            Yii::$app->view->params['breadcrumbs'][] = ['label' => $label, 'url' => ['/'.$module.'/default']];
        }
        $models = Setting::find()->where(['module' => Yii::$app->request->get('module', 'common')])->all();
        
        if (Yii::$app->request->post()) {
            foreach ($models as $model) {
                $settingPosted = Yii::$app->request->post('setting');
                $model->value = ArrayHelper::getValue($settingPosted, (string) $model->_id, '');
                $model->save();
            }
        }
        
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
        
        return $this->render('index', ['models' => $models]);
    }
    
    public function actionCreate()
    {
        $model = new Setting;
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                if (Yii::$app->request->post('save_type') == 'apply'){
                    return $this->redirect(['update', 'id' => (string)$model->_id]);
                } else { 
                    $createUrl = ['/common/setting'];
                    $module = Yii::$app->request->get('module');
                    if (!empty($module))
                        $createUrl['module'] = $module;
                    
                    return $this->redirect($createUrl);
                }
            }
        } else {
            Yii::$app->view->title = Yii::t($this->module->id, 'Create a setting');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Setting'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
            
            return $this->render('form', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdate($id){
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                if (Yii::$app->request->post('save_type') == 'apply'){
                    return $this->redirect(['update', 'id' => (string)$model->_id]);
                } else { 
                    $createUrl = ['/common/setting'];
                    $module = Yii::$app->request->get('module');
                    if (!empty($module))
                        $createUrl['module'] = $module;
                    
                    return $this->redirect($createUrl);
                }
            }
        } else {
            
            Yii::$app->view->title = Yii::t($this->module->id, 'Update setting');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t($this->module->id, 'Setting'), 'url' => ['index']];
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
    protected function findModel($id) {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
