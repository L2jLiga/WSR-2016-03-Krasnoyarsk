<?PHP 
require_once 'config.php';
$id = $_GET['id'];

function add_goods($good) {
	global $db,$id;
	$errs = array();
	
	if(strtolower($_POST['captcha']) != $_SESSION['captcha']) {
		$errs[] = 'Неправильно введена капча';
	}
	
	foreach($good AS $key => $val) {
		if(empty($val) and $key != 'mail') {
			$errs[] = "No attr: ".$key;
		}
	}

	if(!empty($errs) ) return $errs;

	$good['text'] = nl2br(htmlspecialchars($good['text']));
	$good['text'] = str_replace('[','<',$good['text']);
	$good['text'] = str_replace(']','>',$good['text']);

	$query = "INSERT INTO `comms`(`author`,`mail`,`text`,`id_goods`) VALUES('".$good['author']."','".$good['mail']."','".$good['text']."','".$id."')";

	$db->query($query);
	
	$errr = 'Коментарий добавлен';
	
	return $errr;
}
	$Add = array(
		'author' => $_POST['author'],
		'mail' => $_POST['mail'],
		'text' => $_POST['text']
	);
	$rez = add_goods($Add);
	if($rez == 'Коментарий добавлен') {
		echo $rez;
		foreach($good AS $key => $val) {
			$Add[$key] = '';
		}
	}
?>
<form method="POST" action="">
				<h1>Ваше мнение:</h1>
					<?PHP if(!empty($rez)) foreach($rez AS $er) {
						echo $er.'<br/>';
					} ?>
				<input name="author" type="text" value="<?PHP echo $Add['author']; ?>" placeholder="Ваш никнейм" required/>
				<input name="mail" type="email" value="<?PHP echo $Add['mail']; ?>" placeholder="E-Mail" />
				<img src="captcha.php" />
				<input name="captcha" type="text" value="" placeholder="Введите изображение с картинки" required />
				<textarea name='text' placeholder="Текст вашего сообщения" required><?PHP echo $Add['text']; ?></textarea>
				<input name="adds" type="submit" value="добавить" />
			</form>
		<script>
			$("input[name=adds]").click(function () {
				var mail = $("input[name=mail]").val();
				var author = $("input[name=author]").val();
				var text = $("textarea[name=text]").val();
				var captcha = $("input[name=captcha]").val();

				$.post('add_coment.php', {"captcha":captcha, 'author':author,'mail':mail, "text": text}).done(function(data){
					$("content > aside").html(data);
				});
				return false;
			});
		</script>
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