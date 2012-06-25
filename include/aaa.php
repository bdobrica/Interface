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

	if (!empty($users)) {
		$c = 0;
		$keys = null;


		foreach ($users as $user) {
			if (!$c) $keys = array_keys ($user);
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

		$t->assign ('cell', '+');
		$t->parse ('main.logged.content.table.body.row.cell');
		foreach ($keys as $key) {
			if ($key == 'otp' || $key == 'expire')
				$t->assign ('cell', '');
			else
			if ($key == 'active')
				$t->assign ('cell', '<input type="checkbox" value="1" class="uactive" '.($val ? 'checked ' : '').'/>');
			else
			if ($key == 'clear')
				$t->assign ('cell', '<input type="password" name="upwd" value="" />');
			else
				$t->assign ('cell', '<input type="text" value="" name="new_user_'.$key.'" />');
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
	}

function crypto_aaa_clients ($arg) {
	extract ($arg);

	
	}
?>
