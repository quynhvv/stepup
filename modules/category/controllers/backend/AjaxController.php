<?php

/**
 * @link http://www.letyii.com/
 * @copyright Copyright (c) 2014 Let.,ltd
 * @license https://github.com/letyii/cms/blob/master/LICENSE
 * @author Ngua Go <nguago@let.vn>
 */

namespace app\modules\category\controllers\backend;

use Yii;
use yii\mongodb\Query;
use app\modules\category\models\Category;
use yii\filters\VerbFilter;

class AjaxController extends \app\components\BackendController {

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
     * Update list category when move category position
     */
    public function actionUpdatelist() {
        try {
            // Nhận mảng biến đầu vào
            $data = json_decode(Yii::$app->request->post('data'), true);
            // Xử lý từng hành động của mảng biến
            if (!empty($data)) { // Kiem tra su ton tai cua data
                $result = Category::updateTreeStructure($data, null, Yii::$app->request->post('module'));
                if ($result)
                    echo json_encode(['ok']);
                else
                    echo json_encode(['fail']);
            }
            
        } catch (ErrorException $e) {
            echo json_encode(['0']);
        }
    }

    public function actionUpdatecategory() {
        // Add role
        $parent_id = Yii::$app->request->post('id', NULL);
        $module = Yii::$app->request->post('module', NULL);
        $name = Yii::$app->request->post('name');

        // Neu khong ton tai tieu de thi bao loi
        if (empty($name)) {
            $result = [
                'status' => 0,
                'message' => 'Bạn chưa nhập tên của danh mục',
            ];
            echo json_encode($result);
            die;
        }

        if (!empty($module)) {
            if (empty($parent_id)) {
                $category = new Category;
                $root = Category::findOne(['name' => $module,'module' => $module, $category->leftAttribute => 1]);
                $status = 2;
                if (empty($root)){
                    $root = new Category(['name' => $module, 'module' => $module, $category->leftAttribute => 1]);
                    $root->makeRoot();
                    $status = 3;
                }
                $model = new Category(['name' => $name]);
                $model->module = $module;
                $model->status = '1';
                $model->appendTo($root);
                $result = [
                    'status' => $status,
                    'message' => 'Tạo category thành công',
                    'name' => $name,
                    'id' => $model->_id
                ];
            } else {
                $parent = Category::findOne($parent_id);
                $model = new Category(['name' => $name]);
                $model->module = $module;
                $model->status = '1';
                $model->appendTo($parent);
                $result = [
                    'status' => 2,
                    'message' => 'Tạo category thành công',
                    'name' => $name,
                    'id' => $model->_id
                ];
            }
        } else {
            $result = [
                'status' => 0,
                'message' => 'Bạn chưa chọn module',
            ];
        }
        echo json_encode($result);
    }
    
    public function actionDeletecategory(){
        $id = Yii::$app->request->post('id', NULL);
        $category = Category::findOne(['_id' => $id]);
        $category->deleteWithChildren();
        echo json_encode(1);
    }

}

?>