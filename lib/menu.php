
<!DOCTYPE html>

<html lang="en">
	<head>
		<title><?= $title ?></title>
		<meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/header.css">
		<link rel="stylesheet" type="text/css" href="css/footer.css">
		<?= $css ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="shortcut icon" type="../image/x-icon" href="images/favicon.ico">
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
        <a href='admin/index.php' id="home">tempadmin</a>
        <a href='about.php'>about</a>
    	
    	<?php
    	    echo "<a href='cart.php' id='cart'><img src='images/cart1.png' height='25px'></a>";
    	?>
    	
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
            
            // if user is not logged in, display 'sign in' menu
			if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
    		{                
    			echo "<a data-toggle='modal' data-target='#loginModal' data-whatever='@mdo'>Sign in</a>";
            }
            
            // otherwise, display profile, order history, logout menu
            else
    		{   
                $name = $_SESSION['userName'];
    			echo "<div class='dropdown'>
                		<button class='dropbtn'>
                			<a href='profile.php'>$name's profile</a>
                			<i class='fa fa-caret-down'></i>
                		</button>
                		<div class='dropdown-content'>
                			<a href='orderhistory.php'>order history</a>
            			    <a href='logout.php'>Sign out</a>
        		        </div>
        		    </div>";
    		}
			
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
	
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    
    <div class="modal-dialog" role="document" style="width:330px;height:400px;">
        <div class="modal-content" style="height:100%;">
            <div class="modal-header">
                <h5 class="modal-title" >Sign In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
            <form name="login" action="processlogin.php" method="post" onsubmit="return LoginCheck();">
                    <input type="text" class="signin" name="txtUserId" placeholder="User ID"><br /><br />
                    <input type="password" class="signin" name="txtPassword" placeholder="Password"><br /><br />
                    <input type="submit" class="submit" id="submit" value="Login"><br /><br />
                    
                    <a href="create.php">Create a new account</a>
                </form>
            </div>
        </div>
    </div>

    </div>
	<main>