<!DOCTYPE html>
<html>
	<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113588613-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-113588613-1');
		</script>


		<!-- VK Share -->
<script type="text/javascript" src="https://vk.com/js/api/share.js?95" charset="windows-1251"></script>

		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title><?php echo $title ?></title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="/css/style.css" />
		<script src="/js/jquery-1.6.2.js" type="text/javascript"></script>
  <SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>


	<script type="text/javascript">
	if (<?php
if (!$_COOKIE['width']) $_COOKIE['width'] = 0;

	 echo $_COOKIE['width'] ?> != screen.width) {
	$.ajax({
		url: '/ajax/dimension',
		type: 'POST',
		data: {
      'width' : screen.width,
      'height' : screen.height
		}
	});
}
	</script>

			<script src="/js/additional.js" type="text/javascript"></script>
		<!--VK Comments-->
		<script type="text/javascript" src="//vk.com/js/api/openapi.js?151"></script>

		<script type="text/javascript">
		  VK.init({apiId: 6343638, onlyWidgets: true});
		</script>
	</head>
	<body>

			<?php if($_COOKIE['width'] < 1024) { ?>
		<div id="header">
			<div class="menu-for-phones">
				<table>
					<tr>
						<td><img src="/images/phone-menu-button.svg" id="open-menu" alt=""></td>
						<td><div class="menu-name"><?php echo $title ?></div></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="phone-menu">
				<div class="item"><a href="/blog">Блог</a></div>
				<div class="p-0 item">
					<ul>
							<?php
	                                    	$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());

											$query = "SELECT * FROM `categories`";
                            				$result = mysqli_query($MAINBD, $query);
                            				$cat= array();

                            				while ($categories = mysqli_fetch_assoc($result)) {
                            					$cat[] = $categories;
                            				}
                            				$data['categories'] = $cat;
                            				$catsnum = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `categories`"));
                            				$data['catsnum'] = $catsnum[0];

								$i = $data['catsnum'] - 1;

								while($i >= 0) {
									echo '<a href="/blog/cat/'.$data['categories'][$i]['URL'].'" title="'.$data['categories'][$i]['desc'].'"><li class="inner-item ';
									if ($routes[3] == $data['categories'][$i]['name']) echo "active";
									echo '">'.$data['categories'][$i]['name'].'</li></a>';
										$i--;
								}
							?>
						</ul>
				</div>
				<div class="item"><a href="/">Обо мне</a></div>
		</div>
		<div class="phone-menu-bg"></div>
		<script type="text/javascript">
		$("#open-menu").click(function () {
		  if (!$(".phone-menu").is(':visible')) {
		    $(".phone-menu").fadeIn('fast');
		    $(".phone-menu-bg").fadeIn('fast');
		  } else {
		    $(".phone-menu").fadeOut('fast');
		    $(".phone-menu-bg").fadeOut('fast');
		  }
		});

		$(".phone-menu-bg").click(function () {
		     $(".phone-menu").fadeOut('fast');
		    $(".phone-menu-bg").fadeOut('fast');
		})
		</script>
<?php } else {//if desctop or notebook ?>
<div id="header"></div>
<div id = "toTop"> <img src="/images/icons/up-arrow.png" id="toTop-img" alt="Вверх" title="Вверх"> </div>
<script type="text/javascript">//script for scrolling to top
$(function() {
	$(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});
	$('#toTop').click(function() {
		$('body,html').animate({scrollTop:0},800);
	});
});
</script>
<?php } ?>


<?php

						$left_sb_name = false;
						$right_sb_name = false;
						$routes = explode('/', $_SERVER['REQUEST_URI']);
						include 'application/views/'.$content_view;


						if ($_COOKIE['width'] >= 1024) {
							if ($left_sb_name) require_once 'sidebars/left_'.$left_sb_name.'.php';
							if ($right_sb_name) require_once 'sidebars/right_'.$right_sb_name.'.php';

						}
?>

<script type="text/javascript">
/*$(document).ready(function() {
	var tempScrollTop, currentScrollTop = 0;

	$(window).scroll(function(){

	currentScrollTop = $(window).scrollTop();


	if (tempScrollTop < currentScrollTop ) {
		//scrolling down
		$('#floating-header').fadeOut();
	}
	else if (tempScrollTop > currentScrollTop ) {
		//scrolling up
		if ($(this).scrollTop() > 600)  $('#floating-header').fadeIn();
		else $('#floating-header').fadeOut();
	}

	tempScrollTop = currentScrollTop;
});
});
*/

function closeWindow() {
    $(".windowBlock").remove();
}
</script>
	</body>
</html>
