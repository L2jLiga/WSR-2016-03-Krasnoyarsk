function rand(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

$(document).ready(function(){
	function animate1 () {
		$("#clickme").animate({'left':'-50px'},1500,function(){
		animate2();
	})};
	function animate2 () {
		$("#clickme").animate({'left':'0'},1500,function(){
		animate1();
	})};
	
	animate1();
	
	$("#freezer").click(function(){
		$("#scene1").fadeOut(2500,function(){
			$("#scene2").fadeIn(500,function(){scene2()});
			$("#scene1").html('');
		});
	});
	
	var timers;
	var goodies;
	var time;
	var cnt=0;
	function scene2(){
		$('.click').remove();
		var i=0;
		cnt=0;
		time=15
		$("#lefttime").html(time);
		timerss = setInterval(Timers,1000);
		goodies = setInterval(GetGoods,750);
		$("#scene2").on("click","img.click",function(){
			var clicked = $(this);
			clicked.attr("class","clicked");
			clicked.attr("style","");
			cnt++;
			clicked.animate({"width":"0px"},500,function(){
				this.remove();
			});
			
		});
	}
	
	
	// Таймер, рабочий
	function Timers(){
		time--;
		if(time <= 0) {
			clearInterval(timerss);
			clearInterval(goodies);
			scene2finish();
			$("#timer").attr("class","elapsed");
		}
		if(time >9) {
			$("#lefttime").html(time);
		} else {
			$("#lefttime").html('0'+time);
		}
	}

	// Отрисовка фруктов
	function GetGoods() {
		var j;
		for (j=0;j<rand(1,3);j++) {
			var width = rand(25,50);
			var good = "<img src='res/collect/"+rand(1,5)+".jpg' alt=''\
						width="+width+" class='click' \
						style='top:"+rand(50,155)+"px; left:"+rand(5,330-width)+"px;'\
						/>";
			$(good).appendTo("#scene2");
		}
	}

	
	function scene2finish() {
		$('.click').remove();
		$("#scene2").fadeOut(0);
			$("#scene2finish").fadeIn(0);
		$("#percent").html(Math.floor(cnt*0.3));
		
		// Функция повторной игры
		$("#scene2finish").on('click','#retry',function(){
			cnt=0;
			time=15;
			$("#scene2finish").fadeOut(300,function(){
				$("#retry").remove();
				$("#scene2").fadeIn(150);
				scene2();
			});
		});
		
		// На последнюю сцену..
		$("#scene2finish").on('click',"#cont", function(){
			$("#scene2").remove();
			$("#scene2finish").fadeOut(300,function(){
				$("#scene3").fadeIn(150, function(){
					$("#scene2finish").remove();
				});
			});
			// А вот тут экшн 3-й сцены :D
			var i=0;
			for(i=1;i<=3;i++) {
				$("#f"+i+" #price").html(rand(2500,5000));
			}
		});
	}
});

