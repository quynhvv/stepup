<?php

namespace letyii\cropper;

class CropperAssets extends \yii\web\AssetBundle
{
	public $sourcePath = '@vendor/bower/cropper/dist';
	public $js = [
        'cropper.min.js',
	];
	public $css = [
        'cropper.min.css',
	];
	public $depends = [
        'yii\web\JqueryAsset',
	];
}
