<?php
	include('./config.php');

	if(!is_login()) alert('Login Plz', 'back');

	session_destroy();
	alert('Logout success. Bye~', 'back');
?>