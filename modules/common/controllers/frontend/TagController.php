<?php

namespace app\modules\common\controllers\frontend;

use Yii;
use app\components\FrontendController;

class TagController extends FrontendController
{
    public function actionIndex($keyword) {
        return $this->render('index', [
        	'keyword' => $keyword,
    	]);
    }
}
