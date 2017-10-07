<?PHP
session_start();
require_once 'config.php';
$id = $_POST['id'];

$_SESSION['cart'][$id] = null;

// Подсчет товаров:
$t_cost = 0;
$cnt = 0;
foreach($_SESSION['cart'] AS $key => $value) {
	$query = "SELECT `price` FROM `goods` WHERE `id` = '".$key."'";
	$res = $db->query($query);
	$res = $res[0]['price'];
	$cost = $res * $value;
	$t_cost = $t_cost + $cost;
	$cnt = $cnt + $value;
}
// Итого: в $cnt - кол-во товаров всего
// 		  в $t_cost - общая сумма корзины
?>
<div><a href="index.php">Главная</a> ||| <a href="cart.php">Корзина</a></div>
			<div>Общее количество позиций: <?PHP echo $cnt; ?> шт.</div>
			<div>Общая стоимость заказа: <b><?PHP echo $t_cost; ?></b> руб.</div>
