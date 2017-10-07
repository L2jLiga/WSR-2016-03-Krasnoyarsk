<?PHP
require_once 'config.php';

function add_goods($good) {
	global $db;
	$errs = array();
	
	foreach($good AS $key => $val) {
		if(empty($val)) {
			$errs[] = "No attr: ".$key;
		}
	}

	if(!empty($errs) ) return $errs;

	
	$good['desc'] = nl2br(htmlspecialchars($good['desc']));
	$good['desc'] = str_replace('[','<',$good['desc']);
	$good['desc'] = str_replace(']','>',$good['desc']);

	$query = "INSERT INTO `goods`(`name`,`foto`,`price`,`cat`,`desc`) VALUES('".$good['name']."','".$good['foto']."','".$good['price']."','".$good['cat']."','".$good['desc']."')";

	$db->query($query);
	
	return 'Товар добавлен';
}

function resize($foto) {
	$img_name = $foto['tmp_name'];
	
	list($widx, $widy) = getimagesize($img_name);

	if($foto['type'] == "image/jpeg") {
		$src = imagecreatefromjpeg($img_name);
	}
	elseif($foto['type'] == "image/jpg") {
		$src = imagecreatefromjpeg($img_name);
	}
	elseif($foto['type'] == "image/png") {
		$src = imagecreatefrompng($img_name);
	} else {
		echo 'Поддерживаются только JPEG/PNG изображения';
	}
	
	$min_dst = imagecreatetruecolor(200,200);
	@imagecopyresized($min_dst,$src,0,0,0,0,200,200,$widy,$widx);
	
	$name = rand(1000,100000000);
	
	imagepng($src,'./res/goods/'.$name.'.png');
	imagepng($min_dst,'./res/goods/mini_'.$name.'.png');
	return $name;
}

if(isset($_POST['add_goods'])) {
	$good = $_POST['good'];

	$good['foto'] = resize($_FILES['foto']);

	$rez = add_goods($good);
	foreach($rez AS $er) {
		echo $er;
	}
}

?>
<!DOCTYPE html>
<html>
<head><meta charset='utf-8'/><title>Добавление товара</title></head>
<body>

<form enctype="multipart/form-data" method="POST" action="" >
<input name="good[name]" placeholder="Имя товара" />
<input name="foto" type="file" placeholder="Фото товара" />
<input name="good[price]" placeholder="цена" />
<select name="good[cat]" >
		<?PHP 
			$res = $db->query("SELECT * FROM `cats`;");
			foreach($res AS $cat):
		?>
		<option value="<?PHP echo $cat['id']; ?>" ><?PHP echo $cat['name']; ?></option>
		<?PHP endforeach; ?>
</select>
<textarea name="good[desc]" placeholder="" ></textarea>


<input type="submit" name="add_goods" value="Добавить" />
<a href="index.php">ОТМЕНА</a>
</form>
</body>

</html>