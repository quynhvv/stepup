<?php

namespace app\helpers;

class StringHelper extends \yii\helpers\StringHelper {

    public static function asUrl($str = '') {
        $str = self::asAscii($str);
        $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '-', $str);
        $str = strtolower($str);
        $str = preg_replace("/[\/_|+ -]+/", '-', $str);

        $str = trim($str, '-');
        return $str;
    }

    public static function asAscii($str = '') {
        $str = str_replace(array("à", "á", "ạ", "ả", "ã", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ"), "a", $str);
        $str = str_replace(array("À", "Á", "Ạ", "Ả", "Ã", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ"), "A", $str);
        $str = str_replace(array("è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ"), "e", $str);
        $str = str_replace(array("È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ"), "E", $str);
        $str = str_replace("đ", "d", $str);
        $str = str_replace("Đ", "D", $str);
        $str = str_replace(array("ỳ", "ý", "ỵ", "ỷ", "ỹ"), "y", $str);
        $str = str_replace(array("Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ"), "Y", $str);
        $str = str_replace(array("ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ"), "u", $str);
        $str = str_replace(array("Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ"), "U", $str);
        $str = str_replace(array("ì", "í", "ị", "ỉ", "ĩ"), "i", $str);
        $str = str_replace(array("Ì", "Í", "Ị", "Ỉ", "Ĩ"), "I", $str);
        $str = str_replace(array("ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ"), "o", $str);
        $str = str_replace(array("Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ"), "O", $str);
        return $str;
    }
    
    /**
     * Function to make URLs into links
     * @param string The url string
     * @return string
     **/
    public static function makeLinkFromString($string){
    	/*** make sure there is an http:// on all URLs ***/
    	$string = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$string);
    	/*** make all URLs links ***/
    	$string = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\">$1</a>",$string);
    	/*** make all emails hot links ***/
    	$string = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<a href=\"mailto:$1\">$1</a>",$string);
    	return $string;
    }
    
    /**
     * Tra ve 1 so dien thoai co so 84 o dau tien, neu co so 0 o dau thi cat bo so 0 va them so 84
     * @param integer $phone So dien thoai can xu ly
     * @return integer So dien thoai co so 84 dau tien
     */
    public static function asPhone ($phone) {
        $phone = trim($phone);
        if (!preg_match('/^84/', $phone) AND preg_match('/^0/', $phone)) {
            $phone = '84' . substr($phone, 1);
        }
        return $phone;
    }

    public static function parseYoutubeId($url) {
        $result = null;
        $matches = array();
        preg_match('#(\.be/|/embed/|/v/|/vi/|/1/|/5/|/watch\?v=|/?v=|/watch\?vi=|/?vi=)([A-Za-z0-9_-]{5,11})#', $url, $matches);
        if (isset($matches[2]) && $matches[2] != '') {
            $result = $matches[2];
        }

        return $result;
    }

}
