<?php

namespace app\components;

use Yii;


class UrlManager extends \yii\web\UrlManager {

    public $languageParam = 'lang';

    public function createUrl($params)
    {
        if (Yii::$app->params['multilingual'] == 0) {
            unset($params['lang']);
        }

        if (Yii::$app->params['multilingual'] && !isset($params['lang'])) {

//            if (Yii::$app->request->cookies->has('lang')) {
//                Yii::$app->language = Yii::$app->request->cookies->getValue('lang');
//            } else if (Yii::$app->session->has('lang')) {
//                Yii::$app->language = Yii::$app->session->get('lang');
//            }

            $params[$this->languageParam] = Yii::$app->language;
        }

        return str_replace('%2F', '/', parent::createUrl($params));
        //return parent::createUrl($params);
    }

}