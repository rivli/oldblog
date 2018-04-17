<?php

function GenPass ($p1, $p2) {
return md5(SECRET_WORD.md5('665'.$p1.'456').md5('32'.$p2.'645'));
}

function FormChars ($p1) {
return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}

function MessageSend($p1, $p2, $p3) {
if ($p1 == 1) { $p1 = 'Ошибка'; $c = '#b31c1c';}
else if ($p1 == 2) { $p1 = 'Подсказка'; $c = '#198f21';}
else if ($p1 == 3) { $p1 = 'Информация'; $c = '#114f96';}
$_SESSION['message'] = '
<script type="text/javascript">
	setTimeout(function(){$(\'.messageshow\').fadeOut(\'swing\')},5000);  //10000 = 10 секунд
</script>
<div class="messageshow" style="background:'.$c.'" ><b>'.$p1.'</b>: '.$p2.'</div>';
if ($p3) exit(header('Location: '.$p3));
}

function MessageShow() {
if ($_SESSION['message']) {$Message = $_SESSION['message'];
echo $Message;}
$_SESSION['message'] = array();
}


function USERLOGGIN() {
	if ($_SESSION['status'] != 'login') {MessageSend(1,"Эта страница доступна только авторизованным пользователям",'/');}
}

function OnlyForAdmin()
{
	if ($_SESSION['upost'] != 'admin') {MessageSend(1,"Эта страница доступна только Админам",'/');}
}

function vardump($x) {
	echo '<pre>';
	var_dump($x);
	echo '</pre>';
}

function GetArtcile($id) {
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());
	  $query = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	  $result = mysqli_query($MAINBD, $query);
	  $article = mysqli_fetch_array($result);

		if($article['poster'] == 'img') {
			$poster = mysqli_fetch_array(mysqli_query($ADDITIONALBD, "SELECT * FROM `".$article['id']."-Images` WHERE id = '1'"));
			if (!$poster['url']) {
				$poster['url'] = "/images/iz.png";
			};
			$article['poster'] = $poster['url'];
		}

		return $article;
}

function GetAllArticles($status = null) {
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$articles= array();
		$query = "SELECT * FROM `articles`";
		if ($status) $query = $query." WHERE `status` = '".$status."'";
		$result = mysqli_query($MAINBD, $query);
		while ($article = mysqli_fetch_assoc($result)) {
			 $articles[] = GetArtcile($article['id']);
		}

		return $articles;
}


function GetCategory($url = null) {
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());

		$query = "SELECT * FROM `categories`";
		if ($url) $query = $query." WHERE `URL` = '".$url."'";
		$result = mysqli_query($MAINBD, $query);

		if ($url) {$cat = mysqli_fetch_assoc($result);} else {
			$cat= array();
			while ($category = mysqli_fetch_assoc($result)) {
				$cat[] = $category;
			}
		}
		return $cat;
}

function TopArticles($number = 10) {
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());

		$articles= array();
		$query = "SELECT * FROM `articles` WHERE `status` = 'published' ORDER BY visits LIMIT ".$number;
		$result = mysqli_query($MAINBD, $query);
		while ($article = mysqli_fetch_assoc($result)) {
			 $articles[] = GetArtcile($article['id']);
		}

		return $articles;
}
