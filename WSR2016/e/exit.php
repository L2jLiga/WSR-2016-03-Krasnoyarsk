<?PHP
require_once 'config.php';


$db->query("update `users` set `hash` = NULL where `login` = '$login'");
setcookie('login','',time()-100);
setcookie('hash','',time()-100);


header('location: index.php');
?>