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
use app\modules\sms\models\Sms;
use app\modules\sms\models\SmsStats;
use app\modules\sms\models\SmsStatsWeek;
use app\modules\sms\models\SmsStatsMonth;
use app\helpers\ArrayHelper;

class SmsstatsController extends Controller {

    /**
     * Tong hop du lieu SMS theo thoi gian
     * @param date $from_time
     * @param date $to_time
     * @param string $dateInterval P1D: từng ngày | P1W: từng tuần | P1M: từng tháng
     * Use: php yii smsstats
     */
    public function actionIndex($from_time = '', $to_time = '', $dateInterval = 'P1D') {
//        SmsStats::deleteAll();
//        SmsStatsWeek::deleteAll();
//        SmsStatsMonth::deleteAll();

//        echo "Xoa du lieu thanh cong!\n";
        // Get ra danh sach ma loi
        $responseList = Sms::find()->where(['_id' => ['$ne' => null]])->distinct('status');

        if (empty($from_time) AND empty($to_time)) { // Chay ngay hom qua
            $from_time = date('Y/m/d 00:00:00', strtotime("-1 days"));
            $to_time = date('Y/m/d 23:59:59', strtotime("-1 days"));
        } elseif (empty($from_time)) { // Chay tu dau den $to_time
            $from_time = date('Y/m/d 00:00:00', SmsStats::find()->min('date_time')->sec);
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
        $numDays = iterator_count($daterange);
        
        // Day la khai bao du lieu cho truong hop cap nhat du lieu cho tuan va thang
        $typeTimer = [
            'week' => [
                'model' => null,
                'modelName' => 'app\modules\sms\models\SmsStatsWeek',
                'currentTime' => null,
                'previousTime' => null,
            ],
            'month' => [
                'model' => null,
                'modelName' => 'app\modules\sms\models\SmsStatsMonth',
                'currentTime' => null,
                'previousTime' => null,
            ],
        ];

        foreach ($daterange as $key => $date) {
            // UPDATE DU LIEU VAO BANG SMS_STATS //
            $currentDate = new MongoDate($date->getTimestamp());
            $model = SmsStats::find()->where(['date_time' => $currentDate])->one();
            if (!$model) {
                $model = new SmsStats;
                $model->date_time = $currentDate;
            }

            // Tu danh sach ma loi, count xem trong ngay co bao nhieu tin nhan
            foreach ($responseList as $response) {
                $countStatus = Sms::find()->where([
                    'create_time' => [
                        '$gte' => new MongoDate(strtotime($date->format("Y-m-d 00:00:00"))),
                        '$lte' => new MongoDate(strtotime($date->format("Y-m-d 23:59:59"))),
                    ],
                    'status' => $response
                ])->count('status');
                $data[$response] = $countStatus;
            }
            $model->data = $data;
            $model->save();
            echo 'tao bao cao sms ngay ' . $date->format("Y-m-d");

            // UPDATE DU LIEU VAO BANG SMS_STATS_WEEK //
            $typeTimer['week']['currentTime'] = (int) $date->format('W');
            $typeTimer['month']['currentTime'] = (int) $date->format('m');
            
            foreach ($typeTimer as $type => $timer) {
                $currentYear = (int) $date->format('Y');

                // Neu khong ton tai previousTime thi gan cho previousTime = currentTime
                if (empty($timer['previousTime']))
                    $typeTimer[$type]['previousTime'] = $timer['previousTime'] = $timer['currentTime'];

                // Neu currentTime khong bang previousTime thi co nghia la da sang tuan moi, vay du lieu truoc do phai duoc luu lai
                if ($timer['currentTime'] !== $timer['previousTime']) {
                    $typeTimer[$type]['model']->save();
                    $typeTimer[$type]['model'] = null;
                    $typeTimer[$type]['previousTime'] = $timer['previousTime'] = $timer['currentTime'];
                }

                // Neu khong ton tai $modelWeek (ngay dau tien) hoac $currentWeek khong bang $previousWeek thi khoi tao model moi
                if (!isset($typeTimer[$type]['model']) OR empty($typeTimer[$type]['model']) OR $timer['currentTime'] !== $timer['previousTime']) {
                    // Khoi tao Model
                    $typeTimer[$type]['model'] = $timer['modelName']::find()->where([$type => $timer['currentTime'], 'year' => $currentYear])->one();
                    if (!$typeTimer[$type]['model']) {
                        $typeTimer[$type]['model'] = new $timer['modelName'];
                        $typeTimer[$type]['model']->$type = $timer['currentTime'];
                        $typeTimer[$type]['model']->year = $currentYear;
                        $typeTimer[$type]['model']->data = [];
                    }
                }

                // Neu $currentWeek bang $previousWeek, tuc la ngay hien tai van thuoc tuan nay nen chung ta cong them du lieu cua ngay vao tuan
                if ($timer['currentTime'] == $timer['previousTime']) {
                    $typeTimer[$type]['model']->data = ArrayHelper::sumArray($typeTimer[$type]['model']->data, $model->data);
                }

                // Truong hop phan tu cuoi cung can phai duoc save
                if (!empty($typeTimer[$type]['model']) AND ($key + 1) == $numDays) {
                    $typeTimer[$type]['model']->save();
                }
            }
            echo "\n";
        }
    }

    /**
     * Convert du lieu sms theo dung dinh dang
     * Use: php yii smsstats/convert
     */
    public function actionConvert() {
        $count = 0;
        $limit = 500;
        for ($i = 0; $i <= 20; $i++) {
            $models = Sms::find()->orderBy('create_time')->limit($limit)->offset($i * $limit)->all();
            foreach ($models as $model) {
                $count++;
                echo $count . ':';
                $model->status = (string) $model->status;
                $model->status = (int) $model->status;

    //            $model->_id = uniqid();
                if ($model->type == '1')
                    $model->type == 'CSKH';

                if ($model->campaign === 'LTS')
                    $model->campaign = 'LHTS';

                $newModel = new Sms;
                $newModel->phone = $model->phone;
                $newModel->message = $model->message;
                $newModel->type = $model->type;
                $newModel->campaign = $model->campaign;
                $newModel->status = $model->status;
                $newModel->checknum = $model->checknum;
                $newModel->create_time = $model->create_time;
                $newModel->save();
                echo ' - Tao model moi';
                $model->delete();
                echo ' - Xoa model cu';
                echo "\n";
            }
        }
        
        
    }

}
