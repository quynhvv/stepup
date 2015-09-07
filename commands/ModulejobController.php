<?php

namespace app\commands;

use yii\console\Controller;

use app\modules\account\models\UserJob;

class ModulejobController extends Controller
{

    public function actionDeactivevip()
    {
        echo 'Deactive VIP' . "\n";

        $ids = [];
        $exec = 0;
        $model = UserJob::find()->where(['vip' => '1', 'vip_to' => ['$lt' => new \MongoDate(strtotime(date('Y-m-d') . ' 00:00:00'))]])->all();

        foreach ($model as $data) {
            $ids[] = (string) $data->_id;
        }

        if (!empty($ids)) {
            $exec = UserJob::updateAll(['vip' => '0'], ['in', '_id', $ids]);
        }

        echo $exec . "\n";
    }
}
