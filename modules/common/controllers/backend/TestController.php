<?php

namespace app\modules\common\controllers\backend;

use Yii;
use app\components\BackendController;
//use app\modules\sms\helpers\SmsBrandname;

class TestController extends BackendController
{
    public function actionIndex()
    {
        $model = new \app\modules\sms\models\Sms;
        $model->phone = '8498684907';
        $model->message = 'Nhan tin cho khach hang';
        $model->sent();
    }
    
    public function actionImagecache(){
        echo Yii::$app->imageCache->img('@webroot/uploads/film/2015/05/08/thieu-nien-tu-dai-danh-bo.jpg','500x');
//        echo Yii::$app->imageCache->img('/var/www/html/letyii/letyii/uploads/list_cat.png','x91');
    }
    
    public function actionSendmail(){
        $mail = Yii::$app->mailer->compose()
        ->setFrom(['cskh@email-bibomart.com' => 'Bibo Mart'])
        ->setTo(['phongnv0710@gmail.com'])
        ->setSubject('Test send mail yii 2')
        ->setHtmlBody('send mail <strong style="color: red;">Minion</strong>')
        ->send();
        var_dump($mail);die;
    }
}
