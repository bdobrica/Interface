<?php
function crypto_basic_check_alias ($alias) {
	$pieces = explode (' ', $alias);

	$ip = ip2long ($pieces[0]);
	if ($ip === FALSE) return FALSE;
	$nm = ip2long ($pieces[1]);
	if ($nm === FALSE) return FALSE;
	$bc = ip2long ($pieces[2]);
	if ($bc === FALSE) return FALSE;

	if (($ip & $nm)	!= ($bc & $nm)) return FALSE;
	if (strpos(decbin(~$nm & $bc), '0') !== FALSE) return FALSE;

	return TRUE;
	}

function crypto_basic_date ($arg) {
	extract ($arg);
	}

function crypto_basic_network ($arg) {
	extract ($arg);

	/*** parse etc/conf.d/net ***/
	$conf = CRYPTO_ETC . '/conf.d/net';
	$conf_fh = fopen ($conf, 'r');
	$ifs = array ();
	$if_name = '';
	$if_opts = array ();
	$if_type = 'opts';

	while ($line = fgets ($conf_fh)) {	
		$line = trim($line);
		if (preg_match ('/config_([A-z0-9]+)=/', $line, $match)) {
			$if_name = $match[1];
			$if_type = 'opts';
			}
		if (preg_match ('/routes_([A-z0-9]+)=/', $line, $match)) {
			$if_name = $match[1];
			$if_type = 'route';
			}
		if (preg_match_all ('/"[^"]+"/', $line, $match)) {
			if (!empty($match))
				foreach ($match as $opts)
					$if_opts[] = trim($opts[0], '"');
			}
		if (strpos($line, ')') !== FALSE) {
			if (isset($ifs[$if_name][$if_type]))
				$ifs[$if_name][$if_type] = array_merge($ifs[$if_name][$if_type], $if_opts);
			else
				$ifs[$if_name][$if_type] = $if_opts;

			$if_type = 'opts';
			$if_name = '';
			$if_opts = array ();
			}
		}


	/*** regenerate etc/conf.d/net ***/
	$conf_fh = fopen ($conf, 'w');
	if (!empty($ifs))
		foreach ($ifs as $if => $opts) {
			if (!empty($opts['opts'])) {
				fwrite ($conf_fh, 'config_'.$if.'=( "');
				fwrite ($conf_fh, implode ('"'."\n".'"', $opts['opts']));
				fwrite ($conf_fh, '" )'."\n");
				}
				
			if (!empty($opts['route'])) {
				fwrite ($conf_fh, 'routes_'.$if.'=( "');
				fwrite ($conf_fh, implode ('"'."\n".'"', $opts['route']));
				fwrite ($conf_fh, '" )'."\n");
				}
			}

	fclose ($conf_fh);
	}

function crypto_logout ($arg) {
	extract ($arg);
	$_SESSION = array ();
	header ('Location: /');
	exit (1);
	}
?>
