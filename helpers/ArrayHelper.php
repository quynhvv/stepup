<?php

namespace app\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper {

    public static function map($array, $from, $to, $group = null)
    {
        $result = [];
        foreach ($array as $element) {
            $key = (string) static::getValue($element, $from);
            $value = static::getValue($element, $to);
            if ($group !== null) {
                $result[static::getValue($element, $group)][$key] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
    
    /**
     * Cong gia tri cua cac phan tu trong 2 mang boi key
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function sumArray($array1, $array2) {
        $result = [];

        foreach ($array1 as $key => $value) {
            if (isset($array2[$key])) {
                $result[$key] = $value + $array2[$key];
                unset($array2[$key]);
            } else {
                $result[$key] = $value;
            }
        }
        
        $result += $array2;
        return $result;
    }

}
