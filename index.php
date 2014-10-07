<?php

	require_once('lib/schema2XML.inc.php');

	$dbcon = new DBDetail('hostname', 'username', 'password', 'dbname');
	$dbcon->init();

	header('Content-Type: application/xhtml+xml; charset=utf-8');
	$dbcon->exportXML();

?>
