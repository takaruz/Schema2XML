<?php 
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$host = $_POST['hostname'];
	$dbname = $_POST['database'];
	$dbms = $_POST['dbms'];
	$port = $_POST['port'];
	
	

	require_once('lib/schema2XML.inc.php');
	$dbcon = new DBDetail($dbms, $host, $user, $pass, $dbname);
	$dbcon->init();

	$dbcon->exportXML();

	// echo json_encode(array("name"=>$user,"time"=>"2pm")); 

?>
