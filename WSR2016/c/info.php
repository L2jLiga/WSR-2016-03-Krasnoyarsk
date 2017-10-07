<?PHP
require_once 'config.php';
$id = $_GET['id'];
$res = $db->query("SELECT * FROM `goods` WHERE `id` = '$id'");
$good = $res[0];

function add_goods($good) {
	global $db,$id;
	$errs = array();
	
	if(strtolower($_POST['captcha']) != $_COOKIE['captcha']) {
		$errs[] = 'Неправильно введена капча';
	}
	
	foreach($good AS $key => $val) {
		if(empty($val)) {
			$errs[] = "No attr: ".$key;
		}
	}

	if(!empty($errs) ) return $errs;

	$good['text'] = nl2br(htmlspecialchars($good['text']));
	$good['text'] = str_replace('[','<',$good['text']);
	$good['text'] = str_replace(']','>',$good['text']);

	$query = "INSERT INTO `comms`(`author`,`mail`,`text`,`id_goods`) VALUES('".$good['author']."','".$good['mail']."','".$good['text']."','".$id."')";

	$db->query($query);
	
	return 'Товар добавлен';
}

if(isset($_POST['adds'])) {
	$com = $_POST['Add'];

	$rez = add_goods($com);
}
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
		<img src="./res/logo.png" onclick="history.back(1)" alt="Бирюса" />
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
			<a href="info.php" ><img alt="Бирюса 8" src="./res/goods/Biryusa_8.jpg" /></a>
			<img src="./res/eco.jpg" title="Новейшие технологии энергосбережения и охлаждения позволяют спасти озоновый слой и замедлить наступление глобального потепления" alt="Повышенная энергоэффективность" />
			<p>8765</p>
			<p>13</p>
		</article>
		<article>
			<h1>125</h1>
			<a href="info.php" ><img alt="Бирюса 125 KLSSEA" src="./res/goods/Biryusa_125_KLSSEA.jpg" /></a>
			<p>6300</p>
			<p>13</p>
		</article>
		<article>
			<h1>133D</h1>
			<a href="info.php" ><img alt="Бирюса 133D" src="./res/goods/Biryusa_133D_m.jpg" /></a>
			<img src="./res/eco.jpg" title="Новейшие технологии энергосбережения и охлаждения позволяют спасти озоновый слой и замедлить наступление глобального потепления" alt="Повышенная энергоэффективность" />
			<p>6645</p>
			<p>12</p>
		</article>
	</section>
	<content>
		<img alt="Бирюса <?PHP echo $good['name']; ?>" src="./res/goods/<?PHP echo $good['foto']; ?>.png" />
		<h1>Бирюса <?PHP echo $good['name']; ?></h1>
		<p><?PHP echo $good['price']; ?> руб.</p>
		<p><?PHP echo $good['desc']; ?></p>
			<?PHP 
				if($in_log) {
					echo '<a href="modify.php?id='.$good['id'].'" >Редактировать</a>';
					echo '<a href="del.php?id='.$good['id'].'" >Удалить</a>';
				}
				?>
		<aside>
			<form method="POST" action="">
				<h1>Ваше мнение:</h1>
					<?PHP foreach($rez AS $er) {
						echo $er.'<br/>';
					} ?>
				<input name="Add[author]" type="text" value="" placeholder="Ваш никнейм" />
				<input name="Add[mail]" type="mail" value="" placeholder="E-Mail" />
				<img src="captcha.php" />
				<input name="captcha" type="text" value="" placeholder="Введите изображение с картинки" />
				<textarea name='Add[text]' placeholder="Текст вашего сообщения"></textarea>
				<input name="adds" type="submit" value="добавить" />
			</form>
			<h1>Коментарии: </h1>
			<?PHP
				$query = "SELECT * FROM `comms` WHERE `id_goods` = '$id'";
				$res = $db->query($query);
				if(!empty($res))
					foreach($res AS $com):
			?>
			<div>
				<time><?PHP echo $com['date']; ?></time>
				<h1><?PHP echo $com['author']; ?> (<?PHP echo $com['mail']; ?>):</h1>
				<p><?PHP echo $com['text']; ?></p>
			</div>
			<?PHP
				endforeach;
			?>
		</aside>
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
