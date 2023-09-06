<?php
	if(!defined('__MAIN__')) exit('!^_^!');
	$idx = $_GET['idx'];

	if($_SESSION['is_admin'] == 1) {
		$row = fetch_row('board', array('idx' => $idx));
	} else if(!isset($_GET['pass'])) {
		die("<script nonce='".$GLOBALS['nonce']."'>
			var pass = prompt('password');
			location.href='/board.php?p=read&idx=".$idx."&pass='+pass;
		</script>");
	} else {
		$password = md5($_GET['pass']);
		$row = fetch_row('board', array('idx' => $idx, 'password' => $password), 'and');
	}
	if(!$row) alert('Not Found', './board.php');
	if(intval($row['require_level']) > intval($_SESSION['level'])) alert('no permisson', 'back');

	include(__TEMPLATE__ . 'head.php');

?>
	<style type="text/css">
		.wrap { margin:auto; text-align:center; margin-top: 50px;}
		.box { vertical-align:middle; display:inline-block; }
		.box .in { width:500px; height:30px; background-color:#FFF; text-align: left;}
	</style>

	<div class="wrap">
		<div class="box">
			<div class="in">
				Writer : <b><?=clean_html($row['username'])?></b>
				<hr>
				<?=clean_html($row['title'])?>
				<hr>
				<?=clean_html(str_replace("\n", '<br/>', $row['content']))?>
				<hr>
				<?php
					if($row['file_path']){
						echo '<a id="download" href="/download.php?idx='.$row['idx'].'&pass='.$_GET['pass'].'">Download</a>';
					}
				?>
				<hr>
				<?php 
					if($_SESSION['username'] === $row['username']) echo '<a href="./board.php?p=delete&idx='.$row['idx'].'">Delete</a>';
				?>
			</div>
		</div>
	</div>

<?php
	include(__TEMPLATE__ . 'tail.php');
?>

