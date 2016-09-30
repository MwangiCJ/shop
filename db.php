<?php
$host =  "localhost";
$database = "pointdb";
$user = "root";
$password = "";
date_default_timezone_set("Africa/Nairobi");

@$db = new mysqli($host, $user, $password, $database);

if($db->connect_errno){
	//echo $db->connect_error;
	die('Sorry! Unable to connect');
}



?>