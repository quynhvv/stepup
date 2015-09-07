<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use DateInterval;
use DatePeriod;
use DateTime;
use MongoDate;
use Yii;
use yii\console\Controller;
use app\helpers\ArrayHelper;
use app\modules\job\models\UserJob;
use app\modules\job\models\UserJobStats;

class UserJobStatsController extends Controller {

    /**
     * Tong hop du lieu theo thoi gian
     *
     * @param string $from_time
     * @param string $to_time
     * @param string $dateInterval P1D: từng ngày | P1W: từng tuần | P1M: từng tháng
     * @throws \yii\mongodb\Exception
     *
     * Use: php yii user-job-stats
     *      php yii user-job-stats 2015/08/01
     *      php yii user-job-stats 2015/08/01 2015/08/30
     */
    public function actionIndex($from_time = '', $to_time = '', $dateInterval = 'P1D') {
//        UserJobStats::deleteAll();

//        if (empty($from_time) AND empty($to_time)) { // Chay ngay hom qua
//            $from_time = date('Y/m/d 00:00:00', strtotime("-1 days"));
//            $to_time = date('Y/m/d 23:59:59', strtotime("-1 days"));
//        }
        if (empty($from_time) AND empty($to_time)) { // Chay ngay hien tai
            $from_time = date('Y/m/d 00:00:00');
            $to_time = date('Y/m/d 23:59:59');
        } elseif (empty($from_time)) { // Chay tu dau den $to_time
            $from_time = date('Y/m/d 00:00:00', UserJobStats::find()->min('date_time')->sec);
            $to_time = date('Y/m/d 23:59:59', strtotime($to_time));
        } elseif (empty($to_time)) { // Chay tu $from_time den ngay hien tai
            $from_time = date('Y/m/d 00:00:00', strtotime($from_time));
            $to_time = date('Y/m/d 23:59:59');
        } else { // Chay trong khoang $from_time den $to_time
            $from_time = date('Y/m/d 00:00:00', strtotime($from_time));
            $to_time = date('Y/m/d 23:59:59', strtotime($to_time));
        }

        // Create range date
        $data = [];
        $interval = new DateInterval($dateInterval);
        $daterange = new DatePeriod(new DateTime($from_time), $interval, new DateTime($to_time));
        $roleList = UserJob::$roleAllows;

        foreach ($daterange as $key => $date) {
            // Update du lieu vao bang user_job_stats
            $currentDate = new MongoDate($date->getTimestamp());
            $model = UserJobStats::find()->where(['date_time' => $currentDate])->one();
            if (!$model) {
                $model = new UserJobStats;
                $model->date_time = $currentDate;
            }

            // Tu danh sach ma loi, count xem trong ngay co bao nhieu tin nhan
            foreach ($roleList as $role) {
                $count = UserJob::find()->where([
                    'create_time' => [
                        '$gte' => new MongoDate(strtotime($date->format("Y-m-d 00:00:00"))),
                        '$lte' => new MongoDate(strtotime($date->format("Y-m-d 23:59:59"))),
                    ],
                    'role' => $role
                ])->count('role');
                $data[$role] = $count;
            }
            $model->data = $data;
            $model->save();
            echo 'Tao bao cao thong ke Member ngay ' . $date->format("Y-m-d");

            echo "\n";
        }
    }

}
