<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title><?php echo $title ?></title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<link rel="stylesheet" type="text/css" href="/css/fonts.css" />
		<script src="/js/jquery-1.6.2.js" type="text/javascript"></script>
  <SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
		<script src="/js/form.js" type="text/javascript"></script>
			<script src="/js/additional.js" type="text/javascript"></script>
		<script type="text/javascript">
		// return a random integer between 0 and number
		function random(number) {

			return Math.floor( Math.random()*(number+1) );
		};

		// show random quote
		$(document).ready(function() {

			var quotes = $('.quote');
			quotes.hide();

			var qlen = quotes.length; //document.write( random(qlen-1) );
			$( '.quote:eq(' + random(qlen-1) + ')' ).show(); //tag:eq(1)
		});
		</script>

		<!-- Put this script tag to the <head> of your page -->
		<!--VK Comments-->
		<script type="text/javascript" src="//vk.com/js/api/openapi.js?151"></script>

		<script type="text/javascript">
		  VK.init({apiId: 6343638, onlyWidgets: true});
		</script>


	</head>
	<body>
		<div id="header">

			<div id="menu">
				<ul>
					<li class="first active"><a href="/blog">Блог</a></li>
					<li><a href="/blog/addpost">Добавить статью</a></li>
					<li class="last"><a href="/">Обо мне</a></li>
				</ul>
				<br class="clearfix" />
			</div>
			<a href="/" id="logo">Ilvir Zakiryanov</a>

		</div>
		<div id="floating-header">

			<div id="menu">
				<ul>
					<li class="first active"><a href="/blog">Blog</a></li>
					<li><a href="/projects">Projects</a></li>
					<li class="last"><a href="/">Advices</a></li>
				</ul>
				<br class="clearfix" />
			</div>
			<a href="/" id="logo">Ilvir Zakiryanov</a>

		</div>

						<?php include 'application/views/'.$content_view; ?>

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
