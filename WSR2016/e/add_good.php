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
	
	echo 'Товар добавлен';
}
/*
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
}*/


	//$good = $_POST['good'];
	//$good['foto'] = resize($_FILES['foto']);
	$good = array(
		"name" => $_POST['name'],
		'price' => $_POST['price'],
		'cat' => $_POST['cat'],
		"desc" => $_POST['desc'],
		'foto' => 54
	);

	$rez = add_goods($good);
	foreach($rez AS $er) {
		echo $er;
	}


?>
<form method="POST" action="" >
<input name="name" placeholder="Имя товара" required />
<!--input name="foto" type="file" /-->
<input name="price" placeholder="цена" required />
<select name="cat" required >
		<option selected></option>
		<?PHP 
			$res = $db->query("SELECT * FROM `cats`;");
			foreach($res AS $cat):
		?>
		<option value="<?PHP echo $cat['id']; ?>" ><?PHP echo $cat['name']; ?></option>
		<?PHP endforeach; ?>
</select>
<textarea name="desc" placeholder="Введите описание товара"  required ></textarea>


<input type="submit" name="add_goods" value="Добавить" />
<a href="index.php">ОТМЕНА</a>
</form>
		<script>
			$("input[name=add_goods]").click(function () {
				var name = $("input[name=name]").val();
				var price = $("input[name=price]").val();
				var cat = $("select[name=cat]").val();
				var desc = $("textarea[name=desc]").val();

				$.post('add_good.php', {"name":name, 'price':price,'cat':cat, "desc": desc}).done(function(data){
					$("body").html(data);
				});
				return false;
			});
		</script>