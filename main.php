<?php
/* database */
define ('CRYPTO_USE_SQLITE3', FALSE);
if (defined(CRYPTO_USE_SQLITE3)) {
class Crypto_DB extends SQLite3 {
	private $Crypto_Q;
	private $Crypto_R;

	public function __construct ($file) {
		parent::__construct ($file);
		}

	public function q ($sql) {
		$this->Crypto_Q = parent::query ($sql);
		if ($this->Crypto_Q === FALSE) return -1;
		$this->Crypto_R = array ();
		while ($row = $this->Crypto_Q->fetchArray(SQLITE3_ASSOC)) {
			$this->Crypto_R[] = $row;
			}
		return $this->Crypto_R;
		}
	};
	}
else {
class Crypto_DB extends mysqli {
	private $Crypto_Q;
	private $Crypto_R;

	public function __construct ($name, $user = '', $pass = '') {
		parent::__construct ('localhost', $user, $pass, $name);
		}

	public function q ($sql) {
		$this->Crypto_Q = parent::query ($sql);
		if ($this->Crypto_Q === FALSE) return -1;
		$this->Crypto_R = array ();
		while ($row = $this->Crypto_Q->fetch_array(MYSQLI_ASSOC)) {
			$this->Crypto_R[] = $row;
			}
		return $this->Crypto_R;
		}
	};
	}

class Crypto_Widgets {
	private $path;
	private $widgets;

	public function __construct ($path = '') {
		$path = rtrim($path, '/');
		if (!$path)
			$this->path = dirname(__FILE__).'/widgets';
		else {
			if (!is_dir($path))
				$this->path = dirname(__FILE__).'/widgets';
			else
				$this->path = $path;
			}

		$d = opendir($this->path);
		if ($d !== FALSE) {
			while (($f = readdir($d)) !== FALSE) {
				if (preg_match('/\.php$/', $f))
					include ($this->path . '/' . $f);
				}
			closedir($d);
			}
		}

	public function register ($widget) {
		$this->widgets[] = $widget;
		}

	public function view ($args) {
		foreach ($this->widgets as $widget)
			if (function_exists($widget)) call_user_func($widget, $args);
		}
	};
/* includes */
include (dirname(__FILE__).'/libs/class_xtpl.php');
include (dirname(__FILE__).'/include/basic.php');
include (dirname(__FILE__).'/include/aaa.php');
include (dirname(__FILE__).'/include/sms.php');
include (dirname(__FILE__).'/include/server.php');
/* define */
define ('CRYPTO_PATH', dirname(__FILE__));
define ('CRYPTO_URL', 'http://t.xuri.ro');
define ('CRYPTO_ETC', dirname(__FILE__).'/etc');

list ($uri, $urq) = explode ('?', trim($_SERVER['REQUEST_URI']));
$uri = trim ($uri, '/');
$urp = explode ('/', $uri);

/* global */
if (defined(CRYPTO_USE_SQLITE3))
$dbu = new Crypto_DB ('/tmp/user');
else
$dbu = new Crypto_DB ('crypto', 'cryusr', 'crypwd');

$w = new Crypto_Widgets ();

$t = new XTemplate (CRYPTO_PATH . '/template/un.html');
/* session */
session_start ();
?>
