<?php

namespace letyii\jstree;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/components/font-awesome/css';

    public $css = [
        'font-awesome.min.css',
    ];
}
