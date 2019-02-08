<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	
	// title setting
    $title = "::LUCIDKART:: - ABOUT";
    
    // include css
	// if it doesn't include any css other than home.css,
	// declare it as an empty string ($css = "")
	$css = '';
	
	// menu
    require_once('lib/menu.php');
    
?>
<h2>about lucidkart</h2>
<p>
<pre>
A mock shopping mall site

Lucy Kim
PHP and MySQL
2nd year of Computer Programmer/Analyst Program, Conestoga College

Karen Gallego
Graphic Design and JavaScript
2nd year of IT Innovation and Design Program, Conestoga College

GitHub: https://github.com/lucyholic/lucidkart.git
</pre>
</p>

<?php

	// footer
	require_once('lib/footer.php');

?>
	