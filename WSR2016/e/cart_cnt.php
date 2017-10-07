<?PHP
session_start();
require_once 'config.php';
$id = $_POST['id'];

// Механизм добавления товара в корзину
if(empty($_SESSION['cart'])) {
	$_SESSION['cart'] = array();
}

if(empty($_SESSION['cart'][$id])) {
	$_SESSION['cart'][$id] = 1;
} else {
	$_SESSION['cart'][$id]++;
}

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
			<div><a href="cart.php">Корзина</a></div>
			<div>Количество: <?PHP echo $cnt; ?></div>
			<div>Цена: <?PHP echo $t_cost; ?></div>
