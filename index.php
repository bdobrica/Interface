<?php
include (dirname(__FILE__).'/main.php');

$pages = array (
	'basic' => array (
		'basic' => 'Basic Configuration',
		'date' => 'Date &amp; Time',
		'network' => 'Network',
		),
	'aaa' => array (
		'aaa' => 'AAA',
		'users' => 'User Management',
		'clients' => 'Client Management',
		),
	'sms' => array (
		'sms' => 'SMS',
		'settings' => 'SMS Settings',
		'status' => 'SMS Status',
		'test' => 'SMS Test',
		),
	'server' => array (
		'server' => 'Server',
		'control' => 'Control Panel',
		'status' => 'Server Status',
		'log' => 'Event Log',
		),
	'logout' => 'Log out',
	);

if (!$_SESSION['u']) {
	if ($_POST['query']) {
		$user = $_POST['username'];
		$pass = $_POST['password'];

		$err = 0;
		$msg = array ();

		if ($user == '') {
			$err = 1;
			$msg[] = 'Invalid username!';
			}
		if ($pass == '') {
			$err = 1;
			$msg[] = 'Invalid password!';
			}
		if ($user != 'admin' || $pass != 'admin') {
			$err = 1;
			$msg[] = 'Authentication failed!';
			}

		if (!$err) {
			$_SESSION['u'] = 1;
			header ('Location: /');
			exit (1);
			}
		else {
			$t->assign ('error_message', '<ul><li>'.implode('</li><li>', $msg).'</li></ul>');
			$t->parse ('main.login.error');
			}
		}
	$t->parse ('main.login');
	}
else {
	$run = '';
	foreach ($pages as $handle => $page) {
		if (is_array ($page)) {
			foreach ($page as $shandle => $spage) {
				if ($shandle == $handle) continue;
				$t->assign ('item_name', $spage);
				$t->assign ('item_url', '/'.$handle.'/'.$shandle);
				$t->parse ('main.logged.menu.item.sub.item');

				if ($handle.'/'.$shandle == $uri) $run = 'crypto '.$handle.' '.$shandle;
				}
			$t->parse ('main.logged.menu.item.sub');
			}
		
		$t->assign ('item_name', is_array($page) ? $page[$handle] : $page);
		$t->assign ('item_url', '/'.$handle);
		$t->parse ('main.logged.menu.item');

		if ($handle == $uri) $run = 'crypto '.$handle;
		}
	$t->parse ('main.logged.menu');

	if ($run) {
		$run = preg_replace ('/[^a-z]+/', '_', strtolower($run));
		if (function_exists ($run)) call_user_func ($run, array (
			't' => $t,
			'dbu' => $dbu,
			));
		}
	$t->parse ('main.logged.content');
	$t->parse ('main.logged');
	}

$t->parse ('main');
$t->out ('main');
?>
