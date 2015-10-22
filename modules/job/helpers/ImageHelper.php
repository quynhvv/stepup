<?php

namespace app\modules\job\helpers;

use yii\helpers\Html;

class ImageHelper extends \app\helpers\LetHelper
{
    public static function getAvatar($user_id, $type = self::URL, $origin = false, $size = 48, $options = []) {
        $dir = self::getAvatarDir($user_id);
        $fileName = $origin ? $user_id . '.original.jpg' : $user_id . '.jpg';
        $file = $dir . '/' . $fileName;
        if ($type == self::URL OR $type == self::PATH)
            return self::getFileUploaded($file, $type);
        elseif ($type == self::IMAGE) {
            $options['style'] = isset($options['style']) ? (string) $options['style'] : '';
            $options['style'] .= 'width:' . $size . 'px';
            $path = self::getFileUploaded($file, self::PATH);
            $imageUrl = file_exists($path) ? self::getFileUploaded($file, self::URL) : Yii::getAlias('@web') . '/statics/images/noavatar_' . $size . '.png';
            return Html::img($imageUrl, $options);
        }
        return false;
    }
}