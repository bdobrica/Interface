<?php
function _crypto_widget_free () {
	$lines = explode ("\n", `free`);
	preg_match_all ('/[0-9]+/', $lines[1], $mem);
	preg_match_all ('/[0-9]+/', $lines[3], $swap);
	return array ('mem' => $mem[0], 'swap' => $swap[0]);
	}

function _crypto_widget_cpu () {
	$uptime = `uptime`;
	preg_match_all ('/[0-9]+\.[0-9]+/', $uptime, $cpu);
	return $cpu[0];
	}

function _crypto_widget_hdd () {
	$lines = explode ("\n", `df -h`);
	preg_match_all ('/[0-9.]+%/', $lines[1], $hdd);
	return $hdd[0];
	}

function crypto_widget_load ($args) {
	extract ($args);
	$free = _crypto_widget_free();
	$cpu = _crypto_widget_cpu();
	$hdd = _crypto_widget_hdd();
	$t->assign ('widget_title', 'Resources');
	$t->parse ('main.logged.menu.widget.title');
	$t->assign ('slider_label', 'MEM');
	$t->assign ('slider_bar', round(100*$free['mem'][1]/$free['mem'][0], 2)); 
	$t->parse ('main.logged.menu.widget.content.slider');
	$t->assign ('slider_label', 'CPU');
	$t->assign ('slider_bar', round(100*$cpu[1], 2)); 
	$t->parse ('main.logged.menu.widget.content.slider');
	$t->assign ('slider_label', 'HDD');
	$t->assign ('slider_bar', round($hdd[0], 2)); 
	$t->parse ('main.logged.menu.widget.content.slider');
	$t->parse ('main.logged.menu.widget.content');
	$t->parse ('main.logged.menu.widget');
	}

$this->register ('crypto_widget_load');
?>
