<?php
	include('./config.php');

	if(is_login()) alert('Already Login', './');

	$require_params = array('username', 'pw');

	if($_POST){
		foreach ($require_params as $key){
			if(!trim($_POST[$key])){
				alert('Parameter is empty', 'back');
			}

			$$key = trim($_POST[$key]);
		}

		if(!valid_str($username, 'username')){
			alert('Invalid Value', 'back');
		}
		$pw = md5($pw . __SALT__);

		$query = array(
			'username' => $username,
		);
		$id_check = fetch_row('user', $query);
		if(!$id_check) alert('Login Fail', 'back');

		if($id_check['pw'] !== $pw) alert('Login Fail', 'back');

		foreach ($id_check as $key => $value) {
			$_SESSION[$key] = $value;
		}

		alert('Success', './');
		exit;
	}	
	render_page('login');
?>