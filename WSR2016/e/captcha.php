<?PHP
	session_start();
	$symbols = array('a','b','c','d','e','f','q','w','r','t','u','i','o','p',0,1,2,3,4,5,6,7,8,9);

	$src = imagecreatetruecolor(150,50);
	$background_color = imagecolorallocate($src, 255, 255, 255);

	// Фон чтоли попробовать нафигачить?
	for($i=0;$i<45;$i++) {
		$symb = $symbols[rand(0,sizeof($symbols)-1)];
		$svet = imagecolorallocatealpha($src, rand(150,255),rand(150,255),rand(150,255), rand(90,117));
		imagechar($src,rand(5,25),rand(0,150),rand(0,50),$symb,$svet);
	}
	
	
	
	// Сама капча
	$_SESSION['captcha'] = '';
	$x = 15;
	
	for($i=0;$i<rand(4,7);$i++) {
		$x = $x + rand( 10,15);
		$symb = $symbols[rand(0,sizeof($symbols)-1)];
		$svet = imagecolorallocate($src, rand(150,255),rand(150,255),rand(150,255));
		imagechar($src,rand(15,25),$x,rand(10,30),$symb,$svet);
		$_SESSION['captcha'] .= $symb;
	}

	header("content-type: image/png");
	imagepng($src);
	
	?>