<?PHP
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'/>
	<title>Добавление товара</title>
	<script src="./jquery-2.1.4.min.js"></script>
	<style>
		form {width: 500px;}
		input, textarea, select {width:80%;box-sizing:border-box;margin: 10px;}
		textarea {height: 100px;}
	</style>
</head>
<body>

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
</body>

</html>