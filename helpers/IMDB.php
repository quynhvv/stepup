<?php

namespace app\helpers;

use app\helpers\ClientHelper;

class IMDB {

	private static $baseUrl = 'https://app.imdb.com/';

	private static $params = [ 
		'api' => 'v1',
		'appid' => 'iphone1_1',
		'apiPolicy' => 'app1_1',
		'apiKey' => '2wex6aeu6a8q9e49k7sfvufd6rhh0n',
		'locale' => 'en_US',
		'timestamp' => '0' 
	];

	private static $anonymiser = 'http://anonymouse.org/cgi-bin/anon-www.cgi/'; // URL that will be prepended to the generated API URL.

	public static $anonymise = false;

	public static $summary = true; // Set to true to return a summary of the film's details. Set to false to return everything.

	public static $titlesLimit = 0; // Limit the number of films returned by find_by_title() when summarised. 0 = unlimited (NOTE: IMDb returns a maximum of 50 results).
	                         
	// You can prevent certain types of titles being returned. IMDb classifies titles under one of the following categories:
    // feature, short, documentary, video, tv_series, tv_special, video_game
    // Titles whose category is in the $ignoreTypes array below will be removed from your results
	public static $ignoreTypes = array (
		'tv_series',
		'tv_special',
		'video_game' 
	);
	
	// By default, X rated titles and titles in the genre 'Adult' will also be ignored. Set to false to allow them.
	public static $ignoreAdult = true;
	
	// Setting the following option to true will allow you to override any ignore options and force the title to be returned with find_by_id()
	public static $forceReturn = false;
	
	/*
	* Build URL based on the given parameters
	* User: IMDB::build_url('title/maindetails', $id, 'tconst');
	*/
	public static function build_url($method, $query = "", $parameter = "") {
		
		// Set timestamp parameter to current time
		self::$params['timestamp'] = $_SERVER['REQUEST_TIME'];
		
		// Build the URL and append query if we have one
		$unsignedUrl = self::$baseUrl . $method . '?' . http_build_query(self::$params);
		if (!empty($parameter) and !empty($query))
			$unsignedUrl .= '&' . $parameter . '=' . urlencode($query);
			
			// Generate a signature and append to unsignedUrl to sign it.
		$sig = hash_hmac('sha1', $unsignedUrl, self::$params['apiKey']);
		$signedUrl = $unsignedUrl . '&sig=app1-' . $sig;

		ClientHelper::msgToConsole(' - builded url');
		return $signedUrl;
	}
	
	// Search IMDb by ID of film
	function find_by_id($id) {
		if (strpos($id, "tt") !== 0)
			$id = "tt" . $id;
		$requestURL = self::build_url('title/maindetails', $id, 'tconst');
		$json = self::fetchJSON($requestURL);

		if (isset($json['error'])) {
			$data = self::errorResponse($json['error']);
		} else {
			$data = self::$summary ? self::summarise($json['data']) : $json['data'];
		}
		
		return $data;
	}
	
	// Check if a title should be ignored. Returns true for yes, false for no.
	function is_ignored($type, $cert="", $genre=array()){
		if(self::$forceReturn) return false;
		if(in_array($type, self::$ignoreTypes)) return true;
		if(self::$ignoreAdult AND ($cert=="X" OR (!empty($genre) AND in_array("Adult",$genre)))) return true;
	
		return false;
	}
	
	// Summarise - only return the most pertinent data (when returning data from IMDb ID)
	// private static function summarise($obj) {
	// 	ClientHelper::msgToConsole(' - Summarise:');
	// 	$s = [];
	// 	// If this is not an ignored type...
	// 	if (!self::is_ignored($obj->type, $obj->certificate->certificate, $obj->genres)) {
	// 		// ID with and without 'tt' prefix
	// 		$s['id'] = substr($obj->tconst, 2);
	// 		$s['tconst'] = $obj->tconst;
			
	// 		// Title
	// 		$s['title'] = $obj->title;
			
	// 		// Year
	// 		$s['year'] = $obj->year;
			
	// 		// Plot and Tagline
	// 		$s['plot'] = $obj->plot->outline;
	// 		$s['tagline'] = $obj->tagline;
			
	// 		// Votes + Rating
	// 		$s['rating'] = $obj->rating;
	// 		$s['votes'] = $obj->num_votes;
			
	// 		// Genres
	// 		if (is_array($obj->genres)) {
	// 			$s['genre'] = implode(", ", $obj->genres);
	// 			$s['genres'] = $obj->genres;
	// 		} else {
	// 			$s['genre'] = "";
	// 			$s['genres'] = "";
	// 		}
			
	// 		// Writers
	// 		if (is_array($obj->writers_summary)) {
	// 			$i = 0;
	// 			foreach ( $obj->writers_summary as $writers ) {
	// 				$writer[$i] = $writers->name->name;
	// 				$s['writers_summary[$i]['nconst']'] = $writers->name->nconst;
	// 				$s['writers_summary[$i]['name']'] = $writers->name->name;
	// 				$s['writers_summary[$i]['attr']'] = $writers->attr;
	// 				$i ++;
	// 			}
	// 			$s['writer'] = implode(", ", $writer);
	// 		} else {
	// 			$s['writer'] = "";
	// 			$s['writers_summary'] = "";
	// 		}
			
	// 		// Directors
	// 		if (is_array($obj->directors_summary)) {
	// 			$i = 0;
	// 			foreach ( $obj->directors_summary as $directors ) {
	// 				$director[] = $directors->name->name;
	// 				$s['directors_summary[$i]['nconst']'] = $directors->name->nconst;
	// 				$s['directors_summary[$i]['name']'] = $directors->name->name;
	// 				$i ++;
	// 			}
	// 			$s['director'] = implode(", ", $director);
	// 		} else {
	// 			$s['director'] = "";
	// 			$s['directors_summary'] = "";
	// 		}
			
	// 		// Cast
	// 		if (is_array($obj->cast_summary)) {
	// 			$i = 0;
	// 			foreach ( $obj->cast_summary as $cast ) {
	// 				$actor[] = $cast->name->name;
	// 				$s['cast_summary[$i]['nconst']'] = $cast->name->nconst;
	// 				$s['cast_summary[$i]['name']'] = $cast->name->name;
	// 				$s['cast_summary[$i]['char']'] = $cast->char;
	// 				$i ++;
	// 			}
	// 			$s['actors'] = implode(", ", $actor);
	// 		} else {
	// 			$s['actors'] = "";
	// 			$s['cast_summary'] = "";
	// 		}
			
	// 		// Shorthand release date in the format of 'd MMM YYYY' and datestamp
	// 		$s['released'] = !empty($obj->release_date->normal) ? date('j M Y', strtotime($obj->release_date->normal)) : "";
	// 		$s['release_datestamp'] = $obj->release_date->normal;
			
	// 		// Runtime
	// 		// $s['runtime'] = round($obj->runtime->time / 60);
	// 		$s['runtime'] = $obj->runtime;
			
	// 		// Certificate
	// 		$s['certificate'] = $obj->certificate->certificate;
			
	// 		// Poster
	// 		$s['poster'] = $obj->image->url;
			
	// 		// Type
	// 		$s['type'] = $obj->type;
			
	// 		// Response messages
	// 		$s['response'] = 1;
	// 		$s['response_msg'] = "Success";
	// 		ClientHelper::msgToConsole($s->response_msg);
	// 	} else {
	// 		// Response messages
	// 		$s['response'] = 0;
	// 		$s['response_msg'] = "Fail";
	// 		$s['message'] = "Film type is ignored.";
	// 		ClientHelper::msgToConsole($s->response_msg . '-' . $s->message);
	// 	}
		
	// 	return $s;
	// }
	
	// Basic error handling
	private static function errorResponse($obj, $returnArray = false) {
		$s = [];
		$s['status'] = $obj->status;
		$s['code'] = $obj->code;
		$s['message'] = $obj->message;
		$s['response'] = 0;
		$s['response_msg'] = "Fail";
		if ($returnArray)
			return $s;
		else
			return (object) $s;
	}
	
	// Perform CURL request on the API URL to fetch the JSON data
	private static function fetchJSON($apiUrl) {
		ClientHelper::msgToConsole(' - fetchJSON:');
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		// curl_setopt($ch, CURLOPT_POST, TRUE); // Use POST method
		// curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=1&var2=2&var3=3"); // Define POST values
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$json = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);
		// return $json;
		// Errors?
		if ($curl_errno > 0) {
			$data['error']['message'] = 'cURL Error ' . $curl_errno . ': ' . $curl_error;
			ClientHelper::msgToConsole('FAIL');
		} else {
			// Decode the JSON response
			$data = json_decode($json, TRUE);
			ClientHelper::msgToConsole('Success');
		}
		return $data;
	}
}
