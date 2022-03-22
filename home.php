<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, height=device-height, width=device-width, user-scalable=no">
	<title>竞赛页面</title>
</head>
<body style="transition: 0.25s;">
	<div class="card">
		<form action="/competition/home.php" onsubmit="alert('ddd')">
			<span style="font-size: 70px;">4.3-27=</span>
			<input style="font-size: 60px; width: 200px;" type="number" name="answer" required><br>
			<input type="button" style="font-size: 30px; width: 220px; height: 100px;" value="提交答案" onclick="submitting()">
			<input type="text" style="display: none;">
		</form>
		<p></p>
		<div>
			<div id="right" style="display: none">
				<h2>It's Right!</h2>
				<svg width="200px" viewBox="0 0 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<path d="M7.981,0.084 C3.596,0.084 0.042,3.639 0.042,8.022 C0.042,12.406 3.596,15.96 7.981,15.96 C12.364,15.96 15.917,12.406 15.917,8.022 C15.917,3.639 12.363,0.084 7.981,0.084 L7.981,0.084 Z M10.998,4 C12.106,4 13,4.894 13,6 C13,7.103 12.106,8 10.998,8 C9.897,8 9,7.103 9,6 C9,4.894 9.897,4 10.998,4 L10.998,4 Z M5,4 C6.104,4 7,4.896 7,6 C7,7.104 6.104,8 5,8 C3.896,8 3,7.104 3,6 C3,4.895 3.896,4 5,4 L5,4 Z M8,14 C4.987,14 3,12.101 3,10 L13,10 C13,12.101 11.012,14 8,14 L8,14 Z" fill="orange"></path>
					</g>
				</svg>
			</div>
			<div id="wrong" style="display: none">
				<h2>It's Wrong!</h2>
				<img width="300px" src="_crying.svg">
			</div>
		</div>
	</div>
	<div class="container">
		<div class="progress">
			<div class="progress-bar progress-bar-blue progress-bar-striped active">锦
				<div class="progress-value"></div>
			</div>
		</div>
		<div class="progress">
			<div class="progress-bar progress-bar-red progress-bar-striped active">博
				<div class="progress-value"></div>
			</div>
		</div>
	</div>
	<audio>
		<source src="/competition/right.mp3" type="audio/mpeg">
	</audio>
	<audio>
		<source src="/competition/wrong.mp3" type="audio/mpeg">
	</audio>
	<audio>
		<source src="/competition/qreq.mp3" type="audio/mpeg">
	</audio>
</body>
</html>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script type="text/javascript">
	qreq();
	rwq();
	cq();

	function rwq()
	{
		$("input:last").val(<?php echo "'" . $_GET['name'] . "'"; ?>);
		var xhr_rwq = new XMLHttpRequest();
		xhr_rwq.onreadystatechange = function()
		{
			if(xhr_rwq.readyState == 4 && xhr_rwq.status == 200)
			{
				if(xhr_rwq.responseText == 1)
				{
					$("#wrong").hide();
					$("#right").fadeIn();
					$("form>input:first").val("");

					wff();
				}
			}

		}

		xhr_rwq.open("GET", "/competition/rwq.php?name=" + <?php echo "'" . $_GET['name'] . "'"; ?>, true);
		xhr_rwq.send();
	}

	function cq()
	{
		var xhr_cq = new XMLHttpRequest();

		xhr_cq.onreadystatechange = function()
		{
			if(xhr_cq.readyState == 4 && xhr_cq.status == 200)
			{
				eval(xhr_cq.responseText);

				var avr1 = sum1 / 200 * 100 + "%";
				var avr2 = sum2 / 200 * 100 + "%";

				$("p").text("本题已回答次数:" + sum3);
				$(".progress-value:first").text(sum1);
				$(".progress-bar:first").css("width", avr1);

				$(".progress-value:last").text(sum2);
				$(".progress-bar:last").css("width", avr2);

				if(sum1 >= 200 || sum2 >= 200)
				{
					var xhr_sav = XMLHttpRequest();
					xhr_sav.open("GET", "/competition/saving.php", true);
					xhr_sav.send();
				}
			}
		}

		xhr_cq.open("GET", "/competition/sum.php?name=" + <?php echo "'" . $_GET['name'] . "'"; ?>, true);
		xhr_cq.send();
	}

	function qreq()
	{
		$("body").scrollTop(-50);
		$("form>input:first").val("");
		$("#right").hide();
		$("#wrong").hide();

		var xhr_qreq = new XMLHttpRequest();
		xhr_qreq.onreadystatechange = function()
		{
			if(xhr_qreq.readyState == 4 && xhr_qreq.status == 200)
			{
				var question = eval("(" + xhr_qreq.responseText + ")");

				$("body").css("background-color", "yellow");
				setTimeout(function()
				{
					$("body").css("background-color", "white");
					$("audio")[2].play();
					cq();
					questioning(question);
				}, 250);
			}
		}


		xhr_qreq.open("GET", "/competition/qreq.php?name=" + <?php echo "'" . $_GET['name'] . "'"; ?>, true);
		xhr_qreq.send();
	}

	function submitting()
	{
		$("body").scrollTop(-50);
		var xhr_submitting = new XMLHttpRequest();
		var answer = $("form>input:first").val();
	
		xhr_submitting.onreadystatechange = function()
		{
			if(xhr_submitting.readyState == 4 && xhr_submitting.status == 200)
			{
				if(xhr_submitting.responseText == 0)
				{
					$("#wrong").hide();
					$("audio")[0].play();
					$("#right").fadeIn("fast");
					$("form>input:first").val("");

					wff();
				}
				else if(xhr_submitting.responseText == 1)
				{
					if($("#wrong").css("display") != "none")
					{
						$("#wrong").fadeToggle("fast");
					}
					$("audio")[1].play();
					$("#wrong").fadeToggle("fast");
				}
				else if(xhr_submitting.responseText == 2)
				{
					alert('你已经回答过这题了哦!');
				}

				cq();
			}
		}
	
		xhr_submitting.open("GET", "/competition/submitting.php?name=" + <?php echo "'" . $_GET['name'] . "'"; ?> + "&answer=" + Number(answer), true);
		xhr_submitting.send();
	}

	function wff()
	{
		xhr_wff = new XMLHttpRequest();
		xhr_wff.onreadystatechange = function()
		{
			if(xhr_wff.readyState == 4 && xhr_wff.status == 200)
			{
				if(xhr_wff.responseText == 0)
				{
					$("body").css("background-color", "yellow");
					setTimeout(function()
					{
						$("body").css("background-color", "white");
					}, 250);
					setTimeout(function()
					{
						$("body").css("background-color", "yellow");
					}, 1250);
					setTimeout(function()
					{
						$("body").css("background-color", "white");
					}, 1500);
					setTimeout(function()
					{
						$("body").css("background-color", "yellow");
					}, 2500);
					setTimeout(function()
					{
						$("body").css("background-color", "white");
						qreq();
					}, 2750);
				}
			}
		}

		xhr_wff.open("GET", "/competition/rreq.php?name=" + <?php echo "'" . $_GET['name'] . "'"; ?>, true);
		xhr_wff.send();

	}

	function questioning(question)
	{
		switch(Number(question.symbol))
		{
			case 1: $("form>span").text(question.q1 + "+" + question.q2 + "=");
			break;
			case 2: $("form>span").text(question.q1 + "-" + question.q2 + "=");
			break;
			case 3: $("form>span").text(question.q1 + "×" + question.q2 + "=");
			break;
			case 4: $("form>span").text(question.q1 * 1000 * question.q2 * 1000 / 1000000 + "÷" + question.q1 + "=");
			break;
		}
	}

	window.onload = function()
	{
        document.addEventListener('touchstart', function(event)
        {
        	if(event.touches.length > 1)
        	{
        		event.preventDefault();
        	}
        });
        var lastTouchEnd = 0;
        document.addEventListener('touchend', function(event)
        {
        	var now = (new Date()).getTime();
        	if(now - lastTouchEnd <= 300)
        	{
        		event.preventDefault();
        	}
        	lastTouchEnd = now;
        }, false);

        document.addEventListener('gesturestart', function(event)
        {
        	event.preventDefault();
        });
    }
</script>
<link rel="stylesheet" type="text/css" href="/competition/home.css">