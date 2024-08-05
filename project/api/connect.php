<?php
	date_default_timezone_set('UTC');
	
	$servername = "sql453.main-hosting.eu";
	$username = "u355282244_uneme";
	$password = "Koino_Yukue_10120";
	$dbname = "u355282244_emenu";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection establishment.
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	function anti_injection($value=null) {
    	$ai_filter_str = '#select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile#i';
    	if(!isset($value)) {
        	return NULL;
		}elseif(preg_match($ai_filter_str, $value)==1) {
        	return NULL;
    	}
    	return $value;
	}
	
	function anti_injection_alter($value = null){
	    $aia_filter_str = '#select|insert| and | or |update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile#i';
    	if(!isset($value)) {
        	return NULL;
		}elseif(preg_match($aia_filter_str, $value)==1) {
        	return NULL;
    	}
    	return $value;
	}
?>