<?php
	session_start();
	require_once('class/connectdb.php');
	$open = new ConnectDB();
	$conn = $open->Connect();
	
	// require("config/config.php");
	// require("lib/db.php");
	// $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);

	if(isset($_SESSION['create']))
		unset($_SESSION['create']);
?>