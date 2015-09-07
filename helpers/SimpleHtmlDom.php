<?php
namespace app\helpers;
require 'simple_html_dom.php';

class SimpleHtmlDom {

    // get html dom form file
    static public function file_get_html() {
        return call_user_func_array ( 'file_get_html' , func_get_args() );
    }

    // get html dom form string
    static public function str_get_html() {
        return call_user_func_array ( 'str_get_html' , func_get_args() );
    }
}