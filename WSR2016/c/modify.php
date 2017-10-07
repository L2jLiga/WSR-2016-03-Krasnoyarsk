<?PHP
require_once 'config.php';
$id = $_GET['id'];
$res = $db->query("SELECT * FROM `goods` WHERE `id` = '$id'");
$good = $res[0];

$fofka = $good['foto'];

function add_goods($good) {
	global $db,$id;
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
	$query = "UPDATE `goods` SET `name`='".$good['name']."', `foto`='".$good['foto']."', `price`='".$good['price']."', `cat`='".$good['cat']."', `desc`='".$good['desc']."' WHERE `id` = ".$id;

	$db->query($query);
	
	return 'Товар отредактирован';
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
	
	if(isset($_FILES['foto']['tmp_name']) and !empty($_FILES['foto']['tmp_name'])) {
		unlink('res/goods/mini_'.$fofka.'.png');
		unlink('res/goods/'.$fofka.'.png');
		$good['foto'] = resize($_FILES['foto']);
	} else {
		$good['foto'] = $fofka;
	}
	
	echo add_goods($good);
}

?>
<!DOCTYPE html>
<html>
<head><meta charset='utf-8'/><title>Редактирование товара</title></head>
<body>
<form enctype="multipart/form-data" method="POST" action="" >
<input name="good[name]" placeholder="Имя товара" value="<?PHP echo $good['name'] ?>" />
<img src="./res/goods/mini_<?PHP echo $good['foto'] ?>.png" />
<input name="foto" type="file" />
<input name="good[price]" placeholder="цена" value="<?PHP echo $good['price'] ?>" />
<select name="good[cat]" >
		<?PHP 
			$res = $db->query("SELECT * FROM `cats`;");
			foreach($res AS $cat):
		?>
		<option value="<?PHP echo $cat['id']; ?>" <?PHP if($good['cat'] == $cat['id']) echo 'selected'; ?> ><?PHP echo $cat['name']; ?></option>
		<?PHP endforeach; ?>
</select>
<textarea name="good[desc]" placeholder="" ><?PHP echo $good['desc'] ?></textarea>


<input type="submit" name="add_goods" value="Редактировать" />
<a href="index.php">ОТМЕНА</a>
</form>
</body>

</html>