<?php
function crypto_logout ($arg) {
	extract ($arg);
	$_SESSION = array ();
	header ('Location: /');
	exit (1);
	}
?>
