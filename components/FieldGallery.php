<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\LetHelper;

class FieldGallery extends \kartik\widgets\FileInput {

    public function init() {
        if (!empty($this->model->gallery)) {
            $gallery = explode(',', $this->model->gallery);
            foreach ($gallery as $image) {
                $this->pluginOptions['initialPreview'][] = Html::img(LetHelper::getFileUploaded($image), ['class' => 'file-preview-image']);
                $this->pluginOptions['initialPreviewConfig'][] = [
                    'caption' => end(explode('/', $image)),
                    'url' => Url::to(['/common/upload/remove', 'id' => Yii::$app->request->get('id'), 'key' => $image, 'model' => get_class($this->model)]),
                    'key' => $image,
//                    'extra' => 'function(key) { 
//                        alert(key);
//                    }',
                ];
            }
        }
        $this->model->gallery = $this->model->gallery;
        parent::init();
    }

}
