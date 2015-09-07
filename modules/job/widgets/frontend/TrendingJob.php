<?php

namespace app\modules\job\widgets\frontend;

use yii;
use yii\base\Widget;
use app\modules\job\models\Job;
use yii\helpers\Url;

class TrendingJob extends Widget{
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        $model = new Job();
        
        //will get limit value from config later
        $limit = 5;
        $dataProvider = $model->search(Yii::$app->request->getQueryParams(), $limit);
        
        return $this->render('TrendingJob', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
    
}

