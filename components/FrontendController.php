<?php
/**
 * @link http://www.letyii.com/
 * @copyright Copyright (c) 2014 Let.,ltd
 * @license https://github.com/letyii/cms/blob/master/LICENSE
 * @author Ngua Go <nguago@let.vn>, CongTS <congts.vn@gmail.com>
 */

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\web\Cookie;

class FrontendController extends Controller
{

    public function beforeAction($action)
    {
        if (isset($_GET['lang']) && in_array($_GET['lang'], Yii::$app->params['languageSupport'])) {
            $lang = $_GET['lang'];
            Yii::$app->language = $lang;

//            Yii::$app->session->set('lang', $lang);
//            Yii::$app->response->cookies->add(new Cookie(['name' => 'lang', 'value' => $lang]));
        }
//        else if (Yii::$app->request->cookies->has('lang')) {
//            Yii::$app->language = Yii::$app->request->cookies->getValue('lang');
//        } else if (Yii::$app->session->has('lang')) {
//            Yii::$app->language = Yii::$app->session->get('lang');
//        }

        return parent::beforeAction($action);
    }
}
