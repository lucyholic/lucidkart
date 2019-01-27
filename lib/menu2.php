
<!DOCTYPE html>

<html lang="en">
	<head>
		<title><?= $title ?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/header.css">
		<link rel="stylesheet" type="text/css" href="css/footer.css">
		<?= $css ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="js/validate.js"></script>
	</head>
	
	<body>
	    
	<header>
      <h2>Lucid Kart</h2>
	</header>
	

	<!-- Navigation menu -->
    <nav id="nav" class="topnav">
        
	    
        <!--<a href='index.php'>Home</a>-->
        
        <a href='index.php' id="home"><img src="images/logo.png" height="20px"></a>
    	
    	<form id="content">
          <input type="text" name="input" class="input">
          <button type="reset" class="search"></button>
        </form>
    	
        
    	
		<?php
			$list = mysqli_query($conn, "SELECT * FROM category ORDER BY categoryName");
			while($menu = mysqli_fetch_assoc($list))
			{
				echo "<a href='index.php?category=".$menu['categoryId']."'>".$menu['categoryName']."</a>";
			}
			
    		if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
    		{
    			echo "<a href='login.php'>Sign in</a>";
    		}
    		
    		else
    		{
    			echo "<a href='logout.php'>Sign out</a>";
    		}
    		
    	?>
	    
    	<?php
    	    echo "<a href='cart.php'>Cart</a>";
    	?>
        <a href="javascript:void(0);" class="icon" onclick="myFunction2()"><i class="fa fa-bars"></i></a>
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
        $('button').on('click', expand);
        
    </script>
	
	<hr>
	
	<main>