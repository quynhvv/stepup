<?php

namespace app\helpers;

class ClientHelper {
	
	// Function to get the client IP address
	public static function getIp() {
		$ipaddress = '';
		if (getenv ('HTTP_CLIENT_IP'))
			$ipaddress = getenv ('HTTP_CLIENT_IP');
		else if (getenv ('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv ('HTTP_X_FORWARDED_FOR');
		else if (getenv ('HTTP_X_FORWARDED'))
			$ipaddress = getenv ('HTTP_X_FORWARDED');
		else if (getenv ('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv ('HTTP_FORWARDED_FOR');
		else if (getenv ('HTTP_FORWARDED'))
			$ipaddress = getenv ('HTTP_FORWARDED');
		else if (getenv ('REMOTE_ADDR'))
			$ipaddress = getenv ('REMOTE_ADDR');
		else
			$ipaddress = FALSE;
		return $ipaddress;
	}
	
	public static function isCommandLine() {
		if(php_sapi_name() == 'cli' || empty($_SERVER['REMOTE_ADDR']))
			return TRUE;
		else
			return FALSE;
	}
	
	public static function msgToConsole($msg = '') {
		if (self::isCommandLine())
			echo $msg;
	}
}
