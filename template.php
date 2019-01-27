<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	
	// if the page requires log in, keep below codes
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}

	
	// sql setting
	
	// title setting
    $title = "::LUCIDKART::";
    
    // include css
	// if it doesn't include any css other than home.css,
	// declare it as an empty string ($css = "")
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	// menu
	require_once('lib/menu.php');
	
	// body contents
	echo "<h2>title comes here</h2>";

	// footer
	require_once('lib/footer.php');

?>
	