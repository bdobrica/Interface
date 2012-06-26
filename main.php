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
/* includes */
include (dirname(__FILE__).'/libs/class_xtpl.php');
include (dirname(__FILE__).'/include/basic.php');
include (dirname(__FILE__).'/include/aaa.php');
/* define */
define ('CRYPTO_PATH', dirname(__FILE__));
define ('CRYPTO_URL', 'http://t.xuri.ro');

list ($uri, $urq) = explode ('?', trim($_SERVER['REQUEST_URI']));
$uri = trim ($uri, '/');
$urp = explode ('/', $uri);

/* global */
if (defined(CRYPTO_USE_SQLITE3))
$dbu = new Crypto_DB ('/tmp/user');
else
$dbu = new Crypto_DB ('crypto', 'cryusr', 'crypwd');

$t = new XTemplate (CRYPTO_PATH . '/template/un.html');
/* session */
session_start ();
?>
