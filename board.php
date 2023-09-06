<?php
	include('./config.php');

	if(!is_login()) alert('Login Plz', './login.php');

	if($_POST){
		$page = trim($_GET['p']);
		
		if($page === 'write'){
			
			$insert = array();

			$require_params = array('title', 'content', 'level', 'password');
			foreach ($require_params as $key) {
				if(!trim($_POST[$key])) alert('Empty value provided', 'back');

				$$key = $_POST[$key];
			}

			if(mb_strlen($title) > 200 || mb_strlen($content) > 200) alert('Too Long', 'back');
 			if(intval($_SESSION['level']) < intval($level)) alert('You cannot set a value above your level', 'back');

 			$insert['title'] = $title;
 			$insert['content'] = $content;
 			$insert['username'] = $_SESSION['username'];
			$insert['require_level'] = $level;
			$insert['date'] = now();
			$insert['password'] = md5($password);

			if($_FILES['file']['tmp_name']){
				if($_FILES['file']['size'] > 2097152){
					alert('File is too big', 'back');
				}
				$file_name = $_FILES['file']['name']

				if(!move_uploaded_file($_FILES['file']['tmp_name'], '/tmp/upload/' . basename($file_name))) alert('Upload Fail', 'back');

				$insert['file_path'] = '/tmp/upload/' . $file_name;
				$insert['file_name'] = $_FILES['file']['name'];
			}

			if(!insert('board', $insert)) alert('Fail', 'back');

			$replace = array('point' => intval($_SESSION['point']) + 1);
			$query   = array('username' => $_SESSION['username']);

			if(!update('user', $replace, $query)) alert('Error', 'back');

			$_SESSION['point'] = intval($_SESSION['point']) + 1;

			alert('Success', './board.php');
		}
		exit;
	}
	switch (trim($_GET['p'])){
		case 'write':
			render_page('article_write');
			break;
		case 'delete':
			if(!trim($_GET['idx'])) alert('Not Found', 'back');

			$query = array(
				'idx' => trim($_GET['idx']),
				'username' => $_SESSION['username']
			);

			if(!fetch_row('board', $query, 'and')) alert('Not Found', 'back');
			if(!delete('board', $query, 'and')) alert('Delete failed', 'back');

			alert('Success', './board.php');

			break;
		case 'read':
			render_page('article_read');
			break;
		default:
			render_page('board');
			break;
	}
	
?>