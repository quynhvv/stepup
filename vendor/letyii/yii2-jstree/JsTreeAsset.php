<?php

namespace letyii\jstree;

use yii\web\AssetBundle;

class JsTreeAsset extends AssetBundle
{

    public $sourcePath = '@bower/jstree/dist';

    public $depends = [
        'yii\web\JqueryAsset',
        'letyii\jstree\FontAwesomeAsset',
    ];
    
    public $js = [
        'jstree.min.js',
    ];

    public $css = [
        'themes/default/style.min.css',
    ];
}
