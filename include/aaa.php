<?php
function crypto_aaa_users ($arg) {
	extract ($arg);
	$users = $dbu->q ('select * from users;');
	$ukeys = array (
		'login' => 'Username',
		'clear' => 'Password',
		'phone' => 'Phone No.',
		'otp'	=> 'OTP',
		'expire'=> 'OTP Expire',
		'active'=> 'Active?',
		);
	$keys = array_keys ($ukeys);

	if (is_array($users) && !empty($users)) {
		$c = 0;
		foreach ($users as $user) {
			$t->assign ('cell', (++$c).'.');
			$t->parse ('main.logged.content.table.body.row.cell');
			foreach ($user as $key => $val) {
				if ($key == 'active')
					$t->assign ('cell', '<input type="checkbox" value="1" class="uactive" '.($val ? 'checked ' : '').'/>');
				else
				if ($key == 'clear')
					$t->assign ('cell', '<input type="password" name="upwd" value="'.$val.'" />');
				else
					$t->assign ('cell', $val);
				$t->parse ('main.logged.content.table.body.row.cell');
				}
			$t->assign ('cell', '<img src="/images/edit.png" class="uedit" /> <img src="/images/delete.png" class="udelete"/>');
			$t->parse ('main.logged.content.table.body.row.cell');
			$t->parse ('main.logged.content.table.body.row');
			}
		}
	$t->assign ('cell', '+');
	$t->parse ('main.logged.content.table.body.row.cell');
	foreach ($keys as $key) {
		if ($key == 'otp' || $key == 'expire')
			$t->assign ('cell', '');
		else
		if ($key == 'active')
			$t->assign ('cell', '<input type="checkbox" value="1" class="utoggle u'.$key.'" '.($val ? 'checked ' : '').'/>');
		else
		if ($key == 'clear')
			$t->assign ('cell', '<input type="password" name="u'.$key.'" value="" />');
		else
			$t->assign ('cell', '<input type="text" value="" name="u'.$key.'" />');
		$t->parse ('main.logged.content.table.body.row.cell');
		}
	$t->assign ('cell', '<img src="/images/add.png" class="uadd" />');
	$t->parse ('main.logged.content.table.body.row.cell');
	$t->parse ('main.logged.content.table.body.row');

	$t->assign ('cell', '#');
	$t->parse ('main.logged.content.table.head.row.cell');
	foreach ($keys as $key) {
		$t->assign ('cell', $ukeys[$key]);
		$t->parse ('main.logged.content.table.head.row.cell');
		}
	$t->assign ('cell', 'Action');
	$t->parse ('main.logged.content.table.head.row.cell');
	$t->parse ('main.logged.content.table.head.row');

	$t->parse ('main.logged.content.table.head');
	$t->parse ('main.logged.content.table.body');
	$t->parse ('main.logged.content.table');
	}

function crypto_aaa_clients ($arg) {
	extract ($arg);
	$ukeys = array (
		'name'		=> 'Client Name',
		'ipaddr'	=> 'IP Addr',
		'netmask'	=> 'Net Mask',
		'secret'	=> 'Secret',
		'shortname'	=> 'Short Name',
		'nastype'	=> 'NAS Type',
		);
	$keys = array_keys ($ukeys);

	$nas_types = array (
		'cisco',
		'computone',
		'livingston',
		'max40xx',
		'multitech',
		'netserver',
		'pathras',
		'patton',
		'portslave',
		'tc',
		'usrhiper',
		'other',
		);

	/*** parse clients.conf ***/
	$conf = CRYPTO_ETC . '/raddb/clients.conf';
	$conf_fh = fopen ($conf, 'r');
	$clients = array ();
	$client_name = '';
	$client_opts = array ();
	while ($line = fgets ($conf_fh)) {	
		$line = trim($line);
		if (preg_match ('/^client\s+(\S+)/', $line, $match))
			$client_name = $match[1];
		if (preg_match ('/(\S+)\s*=\s*(\S+)/', $line, $match))
			$client_opts[$match[1]] = $match[2];
		if (strpos ($line, '}') !== FALSE) {
			$clients[$client_name] = $client_opts;
			$client_name = '';
			$client_opts = array ();
			}
		}
	fclose ($conf_fh);
	
	$c = 1;
	foreach ($clients as $client_name => $client_opts) {
		$t->assign ('cell', ($c++).'.');
		$t->parse ('main.logged.content.table.body.row.cell');
		foreach ($ukeys as $key => $name) {
			if ($key == 'name')
				$t->assign ('cell', $client_name);
			else
				$t->assign ('cell', $client_opts[$key]);
			$t->parse ('main.logged.content.table.body.row.cell');
			}
		$t->assign ('cell', '<img src="/images/edit.png" class="uedit" /> <img src="/images/delete.png" class="udelete"/>');
		$t->parse ('main.logged.content.table.body.row.cell');
		$t->parse ('main.logged.content.table.body.row');
		}

	$t->assign ('cell', '#');
	$t->parse ('main.logged.content.table.head.row.cell');
	foreach ($ukeys as $key => $name) {
		$t->assign ('cell', $name);
		$t->parse ('main.logged.content.table.head.row.cell');
		}
	$t->assign ('cell', 'Action');
	$t->parse ('main.logged.content.table.head.row.cell');
	$t->parse ('main.logged.content.table.head.row');

	$t->assign ('cell', '+');
	$t->parse ('main.logged.content.table.body.row.cell');
	foreach ($ukeys as $key => $name) {
		if ($key == 'ipaddr')
			$t->assign ('cell', '<input type="text" name="" value="" size="3" style="width: 2em;" />.<input type="text" name="" value="" size="3" style="width: 2em;" />.<input type="text" name="" value="" size="3" style="width: 2em;" />.<input type="text" name="" value="" size="3" style="width: 2em;" />');
		else
		if ($key == 'netmask')
			$t->assign ('cell', '<input type="text" name="" value="" style="width: 2em;" />');
		else
		if ($key == 'nastype')
			$t->assign ('cell', '<select name=""><option value="">'.implode('</option><option value="">', $nas_types).'</option></select>');
		else
			$t->assign ('cell', '<input type="text" name="" value="" />');
		$t->parse ('main.logged.content.table.body.row.cell');
		}
	$t->assign ('cell', '<img src="/images/add.png" class="uadd" />');
	$t->parse ('main.logged.content.table.body.row.cell');
	$t->parse ('main.logged.content.table.body.row');

	$t->parse ('main.logged.content.table.head');
	$t->parse ('main.logged.content.table.body');
	$t->parse ('main.logged.content.table');


	/*** regenerate clients.conf ***/
	$conf_fh = fopen ($conf, 'w');
	foreach ($clients as $client_name => $client_opts) {
		if (!empty($client_opts)) {
			fwrite ($conf_fh, "client ".$client_name." {\n");
			foreach ($client_opts as $client_key => $client_val)
				fwrite ($conf_fh, "\t".$client_key."\t=\t".$client_val."\n");
			fwrite ($conf_fh, "\t}\n");
			}
		}
	fclose ($conf_fh);
	}
?>
