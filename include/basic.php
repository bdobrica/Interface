<?php
function crypto_date ($arg) {
	extract ($arg);
	}

function crypto_network ($arg) {
	extract ($arg);
	}

function crypto_logout ($arg) {
	extract ($arg);
	$_SESSION = array ();
	header ('Location: /');
	exit (1);
	}
?>
