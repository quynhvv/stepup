<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\modules\product\models\ProductOutOfStock;

class SendmailController extends Controller {

    /**
     * Gui mail cho khach hang khi san pham khach hang dang ky co hang va update lai trang thai khach hang da nhan email
     * Use: php yii sendmail/daily
     */
    public function actionSendmaildaily() {
        $count = 0;
        $limit = 100;
        for ($i = 0; $i < 10000; $i++) {
            $models = ProductOutOfStock::find()->where(['status' => "0"])->limit($limit)->all();
            if ($models) {
                foreach ($models as $model) {
                    // Check san pham da co hang hay chua
                    $productStock = $model->product;
                    
                    // Neu ton tai san pham va san pham con hang 1 trong 2 mien hoac ca 2
                    if (!empty($productStock) && ($productStock->inventory > 0)) {
                        $region = '';
                        // Xem hang con o vung nao
                        if ($productStock->inventory == 3)
                            $region = 'Cả 2 miền';
                        else if ($productStock->inventory == 1)
                            $region = 'Hà Nội';
                        else 
                            $region = 'Hồ Chí Minh';
                        
                        //Send mail
                        $mailer = Yii::$app->mailer->compose()
                            ->setFrom(['sendmail0193@gmail.com' => 'Bibo Mart'])
                            ->setTo($model->email)
                            ->setHtmlBody('Sản phẩm: ' . $productStock->title . ' Đã có hàng tại: ' . $region)
                            ->setSubject('Thông báo sản phẩm: ' . $productStock->title . ' Đã có hàng')
                            ->send();
                        
                        // Neu gui mail thanh cong thi update trang thai vao bang product_out_of_stock
                        if ($mailer){
                            $model->status = "1";
                            if ($model->save())
                                $count++;
                        }
                    }
                }
            } else
                break;
        }
        
        echo 'Send ' . $count . " mail thành công\n";
    }

}
