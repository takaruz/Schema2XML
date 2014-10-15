<?php 
	require_once('lib/schema2XML.inc.php');
	session_start();

	if(isset($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case 'login' : login(); break;
	        case 'getxml' : getXML(); break;
	    	}
	}

	function login() {
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$host = $_POST['hostname'];
		$dbname = $_POST['database'];
		$dbms = $_POST['dbms'];
		$port = $_POST['port'];
		$dbcon = new DBDetail($dbms, $host, $user, $pass, $dbname);
		$result = $dbcon->init();
		// print($result);
		showSchemaTable($dbcon);
	}

	function showSchemaTable($dbcon) {
		$schemas = $dbcon->getResultArray($dbcon->getSchemas());
		$result = array();
		for ($i=0; $i < sizeof($schemas); $i++) { 
			$name = $schemas[$i]['schema_name'];
			$tables = $dbcon->getNumTables($name);
			// $tables = $dbcon->getResultArray($dbcon->getTables($schema['schema_name']));
			// echo json_encode($tables);
			$result[] = array($i, $name, $tables);
		}
		echo json_encode($result);
		// echo json_encode($schemas);
	}

	function getXML() {
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$host = $_POST['hostname'];
		$dbname = $_POST['database'];
		$dbms = $_POST['dbms'];
		$port = $_POST['port'];
		$dbcon = new DBDetail($dbms, $host, $user, $pass, $dbname);
		$result = $dbcon->init();
		$dbcon->exportXML();
	}

?>
