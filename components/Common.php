<?php
namespace app\components;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class Common {

    public static function getModules() {
        return array_keys(Yii::$app->modules);
    }
}