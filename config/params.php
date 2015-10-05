<?php
$host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
if (in_array($host, ['stepup.local', '70.39.250.20'])) {
	$uploadUrl = "http://{$host}";
} else {
    $uploadUrl = "http://localhost/letyii";
}

return [
    'params' => [
        // Avatar
        'avatar_default' => '',
        
        // Upload
        'uploadUrl' => $uploadUrl, // http://phimle.vn //http://192.168.12.17/letyii
        'uploadDir' => 'uploads', // uploads
        'uploadPath' => dirname(__FILE__) . '/..', // dirname(__FILE__) . '/../'
        
        'icon-framework' => 'bsg',

        'supportEmail' => 'sendmail0193@gmail.com',
    ],
];