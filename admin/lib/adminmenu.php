
<!DOCTYPE html>

<html lang="en">
<head>
	<title><?= $title ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<?= $css ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="shortcut icon" type="../image/x-icon" href="../images/favicon.ico">
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="../js/validate.js"></script>
</head>

<body>
	
<header>
	<h2>Lucid Kart</h2>
</header>


<!-- Navigation menu -->
<nav id="nav" class="topnav">
	
	<a href='../index.php' id="home"><img src="../images/logo.png" height="20px"></a>

	<?php

	echo "<div class='dropdown'>
		<button class='dropbtn'>
			<a>SHOP</a>
			<i class='fa fa-caret-down'></i>
		</button>
		<div class='dropdown-content'>";
			
		$list = mysqli_query($conn, "SELECT * FROM category ORDER BY categoryName");
		while($menu = mysqli_fetch_assoc($list))
		{
			echo "<a href='index.php?category=".$menu['categoryId']."'>".$menu['categoryName']."</a>";
		}
			
	echo "  </div>
		</div>
		<div class='dropdown'>
			<button class='dropbtn'>
				<a href='index.php'>ADMIN</a>
				<i class='fa fa-caret-down'></i>
			</button>
			<div class='dropdown-content'>
				<a href='itemmaintenance.php'>Item Maintenance</a>
				<a href='categorymaintenance.php'>Category Maintenance</a>
				<a href='ordermanagement.php'>Order Management</a>
				<a href='stockmanagement.php'>Stock Management</a>
				<a href='adminlogout.php'>Admin Logout</a>
			</div>
		</div>";

	?>
	
	<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction2()">&#9776;</a>

</nav>
	
	
<script>
	window.onscroll = function() {myFunction()};
	
	var nav = document.getElementById("nav");
	var sticky = nav.offsetTop;
	
	function myFunction() {
		if (window.pageYOffset >= sticky) {
		nav.classList.add("sticky")
		} else {
		nav.classList.remove("sticky");
		}
	}
	
	function myFunction2() {
		
	var x = document.getElementById("nav");
	
		if (x.className === "topnav") 
		{
			x.className += " responsive";
		}
		else if (x.className === "topnav sticky") 
		{
			x.className += " responsive";
		}
		else if (x.className === "topnav sticky responsive") 
		{
			x.className = "topnav sticky";
		}
		else 
		{
			x.className = "topnav";
		}
	}
	
	function expand() {
		$(".search").toggleClass("close");
		$(".input").toggleClass("square");
		if ($('.search').hasClass('close')) {
		$('input').focus();
		} else {
		$('input').blur();
		}
	}
	$('.search').on('click', expand);
	
</script>

<hr>

<main>