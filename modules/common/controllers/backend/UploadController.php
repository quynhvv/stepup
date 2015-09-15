<?php

namespace app\modules\common\controllers\backend;

use Yii;
use app\components\BackendController;
use yii\filters\VerbFilter;
use app\helpers\FileHelper;

class UploadController extends BackendController {

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
        $id = Yii::$app->request->get('id');
        $modelName = Yii::$app->request->get('model');
        if (!empty($id)) {
            $model = $modelName::findOne($id);
            if ($model) {
//                $model->gallery = \yii\web\UploadedFile::getInstance($model, 'gallery');
                $image = \yii\web\UploadedFile::getInstance($model, 'gallery');
                $ext = FileHelper::getExtention($image);
                if (!empty($ext)) { // Thêm validate ext ____________________________
                    $file_id = uniqid();
                    $fileDir = Yii::$app->controller->module->id . '/' . date('Y/m/d/');
                    $fileName = $file_id . '.' . $ext;
                    $folder = Yii::$app->params['uploadPath'] . '/' . Yii::$app->params['uploadDir'] . '/' . $fileDir;

                    FileHelper::createDirectory($folder);
                    $image->saveAs($folder . $fileName);

                    $output = [
                        "out" => [
                            'file_id' => $file_id,
                            'item_id' => Yii::$app->controller->module->id,
                        ]
                    ];

                    if (empty($model->gallery))
                        $model->gallery = $fileDir . $fileName;
                    else
                        $model->gallery .= ',' . $fileDir . $fileName;

                    $model->save();

                    echo json_encode($output);
                }
            }
        }
    }

    public function actionRemove() {
        $path = Yii::$app->request->get('key');
        $id = Yii::$app->request->get('id');
        $modelName = Yii::$app->request->get('model');
        $model = $modelName::findOne($id);

        // check empty gallery
        if (!empty($model->gallery)) {
            $gallery = explode(',', $model->gallery);
            $key = array_search($path, $gallery);
            
            $path = Yii::$app->params['uploadPath'] . '/' . Yii::$app->params['uploadDir'] . '/' .$gallery[$key];
            // Check item have exits, if isset then delete
            if (isset($gallery[$key]) && file_exists($path)){
                unset($gallery[$key]);
                unlink($path);
            }
        } else {
            $gallery = '';
        }

        $model->gallery = implode(',', $gallery);
        $model->save();
        echo json_encode('');
    }

}
