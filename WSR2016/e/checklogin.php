<?PHP
require_once 'config.php';

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
		<script>
			$("input[type=submit]").click(function () {
				var password = $("input[name=password]").val();
				var login = $("input[name=login]").val();
				
				alert(password);
				alert(login);
				
				$.post('checklogin.php', {"login":login, "password":password}, function(data){
					$("footer > form").remove();
					alert("Data Loaded: " + data);
					$(data).appendTo("footer");
				});
				return false;
			});
		</script>
		<?PHP
			endif;
		?>
