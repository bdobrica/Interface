<?php
function kx () {
	$stamp = floor(time()/5);
	return sha1($stamp);
	}

function px ($text, $comm = '#') {
	$l = rand (5,50);
	$pre = '';
	for ($c = 0; $c<$l; $c++) $pre .= $comm . ' ' . sha1(rand()) . "\n";
	$l = rand (5,50);
	$pos = '';
	for ($c = 0; $c<$l; $c++) $pos .= $comm . ' ' . sha1(rand()) . "\n";
	return $pre . $text . $pos;
	}

function tx ($text, $key) {
	$td = mcrypt_module_open('des', '', 'ecb', '');
	$key = substr($key, 0, mcrypt_enc_get_key_size($td));
	$iv_size = mcrypt_enc_get_iv_size($td);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	$c_t = FALSE;	

	if (mcrypt_generic_init($td, $key, $iv) != -1) {
		/* Encrypt data */
		$c_t = mcrypt_generic($td, $text);
		mcrypt_generic_deinit($td);
		}

	mcrypt_module_close($td);
	
	return $c_t;
	}

function rx ($text, $key) {
	$td = mcrypt_module_open('des', '', 'ecb', '');
	$key = substr($key, 0, mcrypt_enc_get_key_size($td));
	$iv_size = mcrypt_enc_get_iv_size($td);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	$p_t = FALSE;	

	if (mcrypt_generic_init($td, $key, $iv) != -1) {
		$p_t = mdecrypt_generic($td, $text);

		/* Clean up */
		mcrypt_generic_deinit($td);
		}
	mcrypt_module_close($td);

	return $p_t;
	}
?>
