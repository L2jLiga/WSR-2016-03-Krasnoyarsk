<?PHP
session_start();

require_once 'db.class.php';

if (isset($_GET['cat'])) {
	$act = $_GET['cat'];
} else {
	$act = 1;
}


$db_host = '127.0.0.1';
$db_user = 'root';
$db_password = 'wsk';
$db_name = 'site';

$db = new db($db_host,$db_user,$db_password,$db_name);

if(isset($_COOKIE['login']) & isset($_COOKIE['hash']) & !empty($_COOKIE['login']) & !empty($_COOKIE['hash'])) {
	$query = 'SELECT `login` FROM `users` WHERE `hash` = "'.$_COOKIE['hash'].'"';
	$check = $db->query($query);
	if($check[0]['login'] == $_COOKIE['login']){
		$in_log=1;
	} else {
		$in_log=0;
	}
} else {
	$errs = array();
	$login = $_POST['login'];
	$password = $_POST['password'];
	if(isset($_POST['submit'])) {
		$res = $db->query('select * from `users` WHERE `login` = "'.$login.'"');
		if($res[0]['password'] == $password) {
			$hash = md5(rand(0,15435));
			setcookie("login", $login, time()+100600);
			setcookie("hash", $hash, time()+100600);
			$db->query("UPDATE `users` set `hash` = '$hash' WHERE `login` = '$login'");
			$in_log=1;
		} else {
			$errs[] = 'Неверная пара логин-пароль';
		}
	}
}
?>
