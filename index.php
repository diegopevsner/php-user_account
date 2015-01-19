<?php

require('includes/config.php');

$sOutput .= '<div id="index-body">';
if (loggedIn()) {
	$sOutput .= '<h2>restricted access!</h2>
		Hello, ' . $_SESSION['username'] . ' how are you today?<br />
		<h4><a href="login.php?action=logout">Logout?</a></h4>';
}else {
	$sOutput .= '<h2>Welcome to index</h2><br />
		<h4>Would you like to <a href="login.php">login</a>?</h4>
		<h4>Create a new <a href="register.php">account</a>?</h4>';

}
$sOutput .= '</div>';

echo $sOutput;
?>
