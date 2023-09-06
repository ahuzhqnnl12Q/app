<?php
	include('./config.php');

	if(is_login()) alert('Already Login', './');

	$require_params = array('username', 'pw', 'email');

	if($_POST){
		foreach ($require_params as $key){
			if(!trim($_POST[$key])){
				alert('Empty value provided', 'back');
			}

			$$key = trim($_POST[$key]);
		}

		if(!valid_str($username, 'username') || !valid_str($email, 'email')){
			alert('Invalid Value', 'back');
		}
		$pw = md5($pw . __SALT__);

		$query = array(
			'username' => $username
		);

		$dup_check = fetch_row('user', $query, 'or');
		if($dup_check) alert('already exists', 'back');

		$query = array(
			'username' => $username,
			'pw' => $pw,
			'email' => $email,
			'level' => '1',
			'point' => '0',
			'is_admin' => '0'
		);

		if(!insert('user', $query)){
			alert('Fail', 'back');
		}

		alert('Register success', './');
		exit;
	}	
	render_page('register');
?>