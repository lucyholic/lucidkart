<?php
	session_start();
	require_once('class/connectdb.php');
	$open = new ConnectDB();
	$conn = $open->Connect();

	if(isset($_SESSION['create']))
		unset($_SESSION['create']);
?>