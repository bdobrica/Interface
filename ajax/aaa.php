<?php
include (dirname(dirname(__FILE__)).'/main.php');

if ($_POST['uadd'] == 1) {
	if (!preg_match('/^[A-z0-9.]+$/',$_POST['ulogin'])) die ('error:Invalid username!');
	if (strlen($_POST['uclear']) < 6) die ('error:Password too short!');
	if (strlen($_POST['uclear']) > 32) die ('error:Password too long!');
	if (!preg_match('/^[0-9]{10}$/', $_POST['uphone'])) die ('error:Invalid phone number!');

	$dbu->q ("insert into users (login,clear,phone) values ('".$_POST['ulogin']."','".$_POST['uclear']."','".$_POST['uphone']."');");
	}
?>
