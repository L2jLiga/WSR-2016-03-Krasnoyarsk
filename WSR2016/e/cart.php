<?PHP
session_start();

require_once 'config.php';


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
?>

<!DOCTYPE html>
<html lang="ru" >
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Бирюса</title>
	<script src="./jquery-2.1.4.min.js"></script>

</head>
<body>
				<div id="cart"><div><a href="index.php">Главная</a> ||| <a href="cart.php">Корзина</a></div>
			<div>Общее количество позиций: <?PHP echo $cnt; ?> шт.</div>
			<div>Общая стоимость заказа: <b><?PHP echo $t_cost; ?></b> руб.</div></div>
			<hr>
			<?PHP foreach($_SESSION['cart'] AS $key => $value):
				if($value != 0):
				$query = "SELECT * FROM `goods` WHERE `id` = '".$key."'";
				$res = $db->query($query);
				$res = $res[0];
				$cost = $res['price'] * $value;
			 ?>
			<div good='<?PHP echo $res['id'] ?>' style="display:inline-block;border: 3px solid;">
				<a href="info.php?id=<?PHP echo $res['id']; ?>" title="Нажмите для просмотра описания" ><img alt="Бирюса <?PHP echo $res['name']; ?>" src="./res/goods/mini_<?PHP echo $res['foto']; ?>.png" /></a>
				<h1><?PHP echo $res['name']; ?></h1>
				<p>Количество: <fb><?PHP echo $value; ?></fb></p>
				<p>Цена: <i><?PHP echo $res['price']; ?></i></p>
				<p>Итоговая стоимость: <b><?PHP echo $cost; ?></b></p>
				<a class="del_cart" good="<?PHP echo $res['id'] ?>">Удалить из корзины</a>
				<input good="<?PHP echo $res['id'] ?>" value="<?PHP echo $value; ?>" /><button good="<?PHP echo $res['id'] ?>" >Изменить количество</button>
			</div>
			<?php endif;endforeach; ?>
				<script>
					$(".del_cart").click(function(){
						var id = $(this).attr("good");
						
						$.post('cart_del.php',{'id':id}).done(function(data){
							$('div[good='+id+']').remove();
							$("div#cart").html(data);
						});
					});
					
					$("button").click(function(){
						var id = $(this).attr("good");
						var cnt = $("input[good="+id+"]").val();
						$.post('cart_edit.php',{'id':id,'cnt':cnt}).done(function(data){
							$('div[good='+id+'] fb').html(cnt);
							var costs = $('div[good='+id+'] p i').html();
							costs = costs * cnt;
							$('div[good='+id+'] b').html(costs);
							$("div#cart").html(data);
						});
					});
				</script>
</body>
</html>
