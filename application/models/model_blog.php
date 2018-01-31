<?php

class Model_Blog extends Model
{

	public function get_data()
	{

		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$articles= array();

		$query = "SELECT * FROM `articles`  WHERE status = 'published'";
		$result = mysqli_query($MAINBD, $query);


		while ($categorie = mysqli_fetch_assoc($result)) {
		if($categorie['poster'] == 'img') {
			$poster = mysqli_fetch_array(mysqli_query($ADDITIONALBD, "SELECT * FROM `".$categorie['id']."-Images` WHERE id = '1'"));

			if (!$poster['url']) {
				$poster['url'] = "/images/desc/main_desc.jpg";
			};

			$categorie['poster'] = $poster['url'];
		}

		if ($categorie['status'] == 'published') $articles[] = $categorie;
		}
		$data['articles'] = $articles;


				$query = "SELECT * FROM `categories`";
				$result = mysqli_query($MAINBD, $query);
				$cat= array();

				while ($categories = mysqli_fetch_assoc($result)) {
					$cat[] = $categories;
				}
				$data['categories'] = $cat;
				$catsnum = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `categories`"));
				$data['catsnum'] = $catsnum[0];

		return $data;
	}

	public function cat($catURL)
	{

		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$articles= array();

		$result2 = mysqli_query($MAINBD , "SELECT COUNT(*) FROM `articles` WHERE category = '".$catURL."' and status = 'published'");
		if ($result2) {
			$articlesnum = mysqli_fetch_array($result2);
			$data['articlesnum'] = $articlesnum[0];
		} else $data['articlesnum'] = 0;

		if ($data['articlesnum'] != 0) {
					$query = "SELECT * FROM `articles` WHERE category = '".$catURL."'";
					$result = mysqli_query($MAINBD, $query);

					if ($result) {
						while ($categorie = mysqli_fetch_assoc($result)) {

								if($categorie['poster'] == 'img') {
									$poster = mysqli_fetch_array(mysqli_query($ADDITIONALBD, "SELECT * FROM `".$categorie['id']."-Images` WHERE id = '1'"));
									if (!$poster['url']) {$poster['url'] = "/images/desc/main_desc.jpg";};
									$categorie['poster'] = $poster['url'];
								}

								if ($categorie['status'] == 'published') $articles[] = $categorie;
						}
					}
					$data['articles'] = $articles;
				};


				$query = "SELECT * FROM `categories`";
				$result = mysqli_query($MAINBD, $query);
				$cat= array();

				while ($categories = mysqli_fetch_assoc($result)) {
					$cat[] = $categories;
				}
				$data['categories'] = $cat;
				$catsnum = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `categories`"));
				$data['catsnum'] = $catsnum[0];

		return $data;
	}

	public function add_post()
	{
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
		return $data;
	}


	public function add_query_post($post) {
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$_POST['name'] = FormChars($_POST['name']);
		$_POST['description'] = FormChars($_POST['description']);
		$_POST['tags'] = FormChars($_POST['tags']);

		if ($_POST['save-as-draft'] == 1) {$artcilesStatus = "draft";} else $artcilesStatus = "published";



		mysqli_query($MAINBD , "INSERT INTO `articles`  VALUES ('','".$artcilesStatus."', '".$_POST['name']."', '".$_POST['category']."', '".$_POST['description']."', '".$_POST['tags']."','img', NOW(), '".date("H:i:s")."')");


		$query = "SELECT * FROM `articles` WHERE (`name` = '".$_POST['name']."') and (`description` = '".$_POST['description']."')";
		$result = mysqli_query($MAINBD, $query);
		$article = mysqli_fetch_array($result);



		//==================Создаем таблицу комментов
		$sql = "CREATE TABLE `".$article['id']."-Comments` ( `id` INT NOT NULL AUTO_INCREMENT , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
		mysqli_query($ADDITIONALBD, $sql);

		//==================Создаем таблицу images
		$sql = "CREATE TABLE `".$article['id']."-Images` ( `id` INT NOT NULL AUTO_INCREMENT ,`status` VARCHAR(300) NOT NULL ,`url` TEXT NOT NULL ,`description` TEXT NOT NULL , `width` INT(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
		mysqli_query($ADDITIONALBD, $sql);


		//------------------Добавляем постер опроса
		if (!file_exists("images/articles/".$article['id'])) {mkdir("images/articles/".$article['id'],0777);} else echo "images/articles/".$article['id']."already exist";

		    $errorSubmit = false; // контейнер для ошибок
		        if(isset($_FILES['poster']) && $_FILES['poster'] !=""){ // передали ли нам вообще файл или нет
		            $whitelist = array(".gif", ".jpeg", ".png", ".jpg", ".bmp"); // список расширений, доступных для нашей аватарки
		            // проверяем расширение файла
		            //===>>>
		            $error = true; //флаг, отвечающий за ошибку в расширении файла
		            foreach  ($whitelist as  $item) {
		                if(preg_match("/$item\$/i",$_FILES['poster']['name'])) $error = false;
		            }
		            //<<<===
		            if($error){
		                // если формат не корректный, заполняем контейнер для ошибок
		                $errorSubmit = 'Не верный формат картинки!';
		            }else{
		                // если формат корректный, то сохраняем файл
		                // и все остальную информацию о пользователе
		                // Файл сохранится в папку /files/
		                move_uploaded_file($_FILES["poster"]["tmp_name"], "images/articles/".$article['id']."/".$_FILES["poster"]["name"]);
		                $path_file = "https://ilvirzakiryanov.com/images/articles/".$article['id']."/".$_FILES["poster"]["name"];
		              	mysqli_query($MAINBD , "UPDATE `articles` SET `poster` = '".$path_file."' WHERE `id` = '".$article['id']."'") or die("Error on 101 line");
									mysqli_query($ADDITIONALBD , "INSERT INTO `".$article['id']."-Images`  VALUES ('', 'poster', '".$path_file."', '".$_POST['poster_description']."', '".$_POST['poster_width']."')") or die("Error on 102 line");

								};
		        };
//Добавляем остальные изображения, если они есть


if ($_POST['imagesNumber'] != 0) {
	$i = 1;

	while ($i <= $_POST['imagesNumber']) {

		$errorSubmit = false; // контейнер для ошибок
				if(isset($_FILES['file-image-'.$i]) && $_FILES['file-image-'.$i] !=""){ // передали ли нам вообще файл или нет
						$whitelist = array(".gif", ".jpeg", ".png", ".jpg", ".bmp"); // список расширений, доступных для нашей аватарки
						// проверяем расширение файла
						//===>>>
						$error = true; //флаг, отвечающий за ошибку в расширении файла
						foreach  ($whitelist as  $item) {
								if(preg_match("/$item\$/i",$_FILES['file-image-'.$i]['name'])) $error = false;
						}
						//<<<===
						if($error){
								// если формат не корректный, заполняем контейнер для ошибок
								$errorSubmit = 'Не верный формат картинки!';
						}else{
								// если формат корректный, то сохраняем файл
								// и все остальную информацию о пользователе
								// Файл сохранится в папку /files/
								move_uploaded_file($_FILES['file-image-'.$i]["tmp_name"], "images/articles/".$article['id']."/".$_FILES['file-image-'.$i]["name"]);
								$path_file = "https://ilvirzakiryanov.com/images/articles/".$article['id']."/".$_FILES['file-image-'.$i]["name"];

							mysqli_query($ADDITIONALBD , "INSERT INTO `".$article['id']."-Images`  VALUES ('', 'image', '".$path_file."', '".$_POST['image-'.$i.'-description']."', '100')") or die("Error on 135 line");

							//$_POST['description'] = str_replace("\$IMG".$i, '<div class="image-block" id="image-'.$i.'-block"><div class="image-place" style="background: url('.$path_file.');background-position: center center; background-repeat: no-repeat; background-size: cover; " id="image-'.$i.'"></div><div class="image-description" id="image-'.$i.'-description">'.$_POST['image-'.$i.'-description'].'</div></div><br>', $_POST['description']);


						$article['description'] = str_replace("IZ-IMG-CODE".$i, '<img class="article-image" src="'.$path_file.'" id="image-'.$i.'"><div class="image-description" id="image-'.$i.'-description">'.$_POST['image-'.$i.'-description'].'</div>', $article['description']);

						}
				}

		$i++;
	}



	mysqli_query($MAINBD , "UPDATE `articles` SET `description` = '".$article['description']."' WHERE `id` = '".$article['id']."'") or die("Error on 149 line");

	}

	header('location: /blog/article/'.$article['id']);
	}

	public function article($id) {

		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$query = "SELECT * FROM `articles` WHERE id = ".$id;
		$result = mysqli_query($MAINBD, $query);
		$data = mysqli_fetch_array($result);


		$data['poster'] = mysqli_fetch_array(mysqli_query($ADDITIONALBD, "SELECT * FROM `".$id."-Images` WHERE status = 'poster'"));

		$query = "SELECT * FROM `categories`";
		$result = mysqli_query($MAINBD, $query);
		$cat= array();

		while ($categories = mysqli_fetch_assoc($result)) {
			$cat[] = $categories;
		}
		$data['categories'] = $cat;
		$catsnum = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `categories`"));
		$data['catsnum'] = $catsnum[0];

		return $data;
	}

	public function signin($post) {

	$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$user = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `users` WHERE login = '".$post['login']."' and password = '".$post['password']."'"));


		if ($user) {

			$_SESSION['ulogin'] = 'logined';
			$_SESSION['upost'] = $user['post'];
		} else {
			return 'логин или пароль введены не верно';
		};
		header('location: /blog');

	}

	public function signout() {

		session_destroy();
		header('location: /blog');

	}


	public function add_cat($post)
	{
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());

		$_POST['name'] = FormChars($_POST['name']);
		$_POST['url'] = FormChars($_POST['url']);
		$_POST['description'] = FormChars($_POST['description']);

		mysqli_query($MAINBD , "INSERT INTO `categories`  VALUES ('', '".$_POST['name']."', '".$_POST['url']."', '".$_POST['description']."')");
		header('location: /blog/cat/'.$_POST['url']);

	}


	public function delete($id) {
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		mysqli_query($MAINBD , "UPDATE `articles` SET `status` = 'deleted' WHERE `id` = '".$id."'") or die("Error on 277 line");
		header('location: /blog');
	}


	public function edit($id) {
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$_POST['name'] = FormChars($_POST['name']);
		$_POST['description'] = FormChars($_POST['description']);
		$_POST['tags'] = FormChars($_POST['tags']);
		if ($_POST['save-as-draft'] == 1) {$artcilesStatus = "draft";} else $artcilesStatus = "published";

		mysqli_query($MAINBD , "UPDATE `articles` SET `status` = '".$artcilesStatus."',`name` = '".$_POST['name']."',`description` = '".$_POST['description']."',`category` = '".$_POST['category']."',`tags` = '".$_POST['tags']."' WHERE `id` = '".$_POST['id']."'") or die("Error on 302 line");
		header('location: /blog/article/'.$_POST['id']);
	}
}
