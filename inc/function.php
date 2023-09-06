<?php
	if(!defined('__MAIN__')) exit('!^_^!');

	function render_page($page) {
		$template = __TEMPLATE__ . $page  . '_page.php';

		if(!is_file($template)){
			alert('Not Found, Plz contact admin', 'back');
		}

		include($template);
		exit;
	}

	function alert($msg, $location) {

		$msg = htmlspecialchars($msg, ENT_QUOTES);
		$location = htmlspecialchars($location, ENT_QUOTES);

		if($location === 'back'){
			exit('<script>alert("' . $msg. '"); history.go(-1);</script>');
		}

		exit('<script>alert("' . $msg . '"); location.href="' . $location . '";</script>');
	}

	function valid_str($str, $type) {
		switch (trim($type)) {
			case 'username':
				if(strlen($str) > 30 || preg_match('/[^a-z0-9_]/', $str)) return false;
				break;
			case 'email':
				if(strlen($str) > 50 || !filter_var($str, FILTER_VALIDATE_EMAIL)) return false;
				break;
			default:
				return false;
				break;
		}
		return true;
	}

	function is_login() {
		if($_SESSION['idx']) return true;
		return false;
	}

	function clean_html($str) {
		return htmlspecialchars($str, ENT_QUOTES);
	}

	function clean_sql($str) {
		return addslashes($str);
	}

	function now() {
		return date("Y-m-d H:i:s");
	}

?>