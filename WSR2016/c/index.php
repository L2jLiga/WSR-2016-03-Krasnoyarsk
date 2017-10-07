<?PHP
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ru" >
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Бирюса</title>
	<link rel="stylesheet" type="text/css" href="./res/style.css" />
	<link rel="stylesheet" type="text/css" href="./res/adaptive.css" />
</head>
<body>
	<div></div>
	<header>
		<img src="./res/logo.png" alt="Бирюса" />
		<aside>
			<div>Корзина</div>
			<div>Количество: 0</div>
			<div>Цена: 0</div>
		</aside>
		<nav>
			<a class="active" href="" >Каталог</a>
			<a href="" >история</a>
			<a href="" >партнеры</a>
			<a href="" >контакты</a>
		</nav>
	</header>
	<nav>
		<?PHP 
			$res = $db->query("SELECT * FROM `cats`;");
			foreach($res AS $cat):
		?>
		<a <?PHP if($act == $cat['id']) {echo 'class="active"'; $cat_name=$cat['name'];}?> href="index.php?cat=<?PHP echo $cat['id']; ?>" ><?PHP echo $cat['name']; ?></a>
		<?PHP endforeach; ?>
	</nav>
	<aside>
		Баннер
	</aside>
	<section>
		<h1>Новинки</h1>
		<article>
			<h1>8</h1>
			<a href="info.php" title="Нажмите для просмотра описания" ><img alt="Бирюса 8" src="./res/goods/Biryusa_8.jpg" /></a>
			<img src="./res/eco.jpg" title="Новейшие технологии энергосбережения и охлаждения позволяют спасти озоновый слой и замедлить наступление глобального потепления" alt="Повышенная энергоэффективность" />
			<p>8765</p>
			<p>13</p>
		</article>
		<article>
			<h1>125</h1>
			<a href="info.php" title="Нажмите для просмотра описания" ><img alt="Бирюса 125 KLSSEA" src="./res/goods/Biryusa_125_KLSSEA.jpg" /></a>
			<p>6300</p>
			<p>13</p>
		</article>
		<article>
			<h1>133D</h1>
			<a href="info.php" title="Нажмите для просмотра описания" ><img alt="Бирюса 133D" src="./res/goods/Biryusa_133D_m.jpg" /></a>
			<img src="./res/eco.jpg" title="Новейшие технологии энергосбережения и охлаждения позволяют спасти озоновый слой и замедлить наступление глобального потепления" alt="Повышенная энергоэффективность" />
			<p>6645</p>
			<p>12</p>
		</article>
	</section>
	<content>
		<h1><?PHP echo $cat_name; ?></h1>
		<?PHP 
			$query = "SELECT * FROM `goods` WHERE `cat` = '$act' ORDER by `name` ASC";
			$goods = $db->query($query);
		
			foreach($goods AS $good):
				$query = "SELECT * FROM `comms` WHERE `id_goods` = '".$good['id']."'";
				$count = $db->query($query);
		?>
		<article>
			<h1><?PHP echo $good['name']; ?></h1>
			<a href="info.php?id=<?PHP echo $good['id']; ?>" title="Нажмите для просмотра описания" ><img alt="Бирюса <?PHP echo $good['name']; ?>" src="./res/goods/mini_<?PHP echo $good['foto']; ?>.png" /></a>
			<p><?PHP echo $good['price']; ?></p>
			<p>Коментарии: <?PHP
			echo sizeof($count); ?></p>
			<?PHP 
				if($in_log) {
					echo '<a href="modify.php?id='.$good['id'].'" >Редактировать</a>';
					echo '<a href="del.php?id='.$good['id'].'" >Удалить</a>';
				}
				?>
		</article>
		<?PHP endforeach; ?>
	</content>
	<footer>
		<nav>		
			<div><a href="">Каталог</a></div>
			<div><a href="">История</a></div>
			<div><a href="">партнеры</a></div>
			<div><a href="">контакты</a></div>
			<div><a href="">вход</a></div>
		</nav>
		<?PHP
			if($in_log):
		?>
		<h3>ПРИВЕТ, admin!</h3>
		<a href="add.php">Добавление товара</a> <br>
		<a href="exit.php">Деавторизация</a>
		<?PHP
			endif;
			if(!$in_log):
		?>
		<form method="POST" action="?">
			<?PHP
				if(!empty($errs))
				foreach($errs AS $err) {
					echo '<b>Ошибка!</b> $err <br/>';
				}
			?>
			<input name="login" type="text" value="<?PHP echo $login; ?>" placeholder="Логин" />
			<input name="password" type="password" value="<?PHP echo $password; ?>" placeholder="Пароль" />
			<input name="submit" type="submit" value="Войти" />
		</form>
		<?PHP
			endif;
		?>
	</footer>
</body>
</html>
