<?php
	date_default_timezone_set('UTC');

	if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    	die("Request is not secure.");
	}

	if($_SERVER['REQUEST_METHOD']!='POST'){
    	die("Request method is not valid.");
	}
	
	if($HTTP_SERVER_VARS["CF-Connecting-IP"]){
    	$ip = $HTTP_SERVER_VARS["CF-Connecting-IP"];
	}
	elseif($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]){
    	$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
	}
	elseif($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]){
    	$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
	}
	elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]){
    	$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
	}
	elseif (getenv("HTTP_X_FORWARDED_FOR")){
    	$ip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif (getenv("HTTP_CLIENT_IP")){
    	$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif (getenv("REMOTE_ADDR")){
    	$ip = getenv("REMOTE_ADDR");
	}
	else{
    	$ip = "Unknown";
    	die("Client data incorrect.");
	}	
?>