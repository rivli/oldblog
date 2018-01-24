<?php

class Model_Blog extends Model
{

	public function get_data()
	{

		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$articles= array();

		$query = "SELECT * FROM `articles`";
		$result = mysqli_query($MAINBD, $query);


		while ($categorie = mysqli_fetch_assoc($result)) {
		if($categorie['poster'] == 'img') {
			$poster = mysqli_fetch_array(mysqli_query($ADDITIONALBD, "SELECT * FROM `".$categorie['id']."-Images` WHERE id = '1'"));
			$categorie['poster'] = $poster['url'];
		}
			$articles[] = $categorie;
		}
		$data['articles'] = $articles;
		$articlesnum = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `articles`"));
		$data['articlesnum'] = $articlesnum[0];


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




		mysqli_query($MAINBD , "INSERT INTO `articles`  VALUES ('', '".$_POST['name']."', '".$_POST['category']."', '".$_POST['description']."', '".$_POST['tags']."','img', NOW(), '".date("H:i:s")."')");


		$query = "SELECT * FROM `articles` WHERE (`name` = '".$_POST['name']."') and (`description` = '".$_POST['description']."')";
		$result = mysqli_query($MAINBD, $query);
		$article = mysqli_fetch_array($result);


		//==================Создаем таблицу комментов
		$sql = "CREATE TABLE `".$article['id']."-Comments` ( `id` INT NOT NULL AUTO_INCREMENT , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
		mysqli_query($ADDITIONALBD, $sql);

		//==================Создаем таблицу комментов
		$sql = "CREATE TABLE `".$article['id']."-Images` ( `id` INT NOT NULL AUTO_INCREMENT ,`status` VARCHAR(300) NOT NULL ,`url` TEXT NOT NULL ,`description` TEXT NOT NULL , `width` INT(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
		mysqli_query($ADDITIONALBD, $sql);


		//------------------Добавляем постер опроса
		if (!file_exists("images/articles/".$article['id'])) {mkdir("images/articles/".$article['id'],0777);};

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
		              	mysqli_query($MAINBD , "UPDATE `articles` SET `poster` = '".$path_file."' WHERE `id` = '".$article['id']."'");
									mysqli_query($ADDITIONALBD , "INSERT INTO `".$article['id']."-Images`  VALUES ('', '".$_POST['poster_status']."', '".$path_file."', '".$_POST['poster_description']."', '".$_POST['poster_width']."')");

								}
		        }
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

							mysqli_query($ADDITIONALBD , "INSERT INTO `".$article['id']."-Images`  VALUES ('', 'image', '".$path_file."', '".$_POST['image-'.$i.'-description']."', '100')");

						//	$_POST['description'] = str_replace("\$IMG".$i, '<div class="image-block" id="image-'.$i.'-block"><div class="image-place" style="background: url('.$path_file.');background-position: center center; background-repeat: no-repeat; background-size: cover; " id="image-'.$i.'"></div><div class="image-description" id="image-'.$i.'-description">'.$_POST['image-'.$i.'-description'].'</div></div><br>', $_POST['description']);
						$_POST['description'] = str_replace("\$IMG".$i, '<img class="article-image" src="'.$path_file.'" id="image-'.$i.'"><div class="image-description" id="image-'.$i.'-description">'.$_POST['image-'.$i.'-description'].'</div>', $_POST['description']);

						}
				}

		$i++;
	}

	mysqli_query($MAINBD , "UPDATE `articles` SET `description` = '".$_POST['description']."' WHERE `id` = '".$article['id']."'");

}


	//	MessageSend(3, 'Опрос успешно добавлен.', "/");

		//------------------------------------------------------------------------------------------------------
	}

	public function article($id)
	{
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$query = "SELECT * FROM `articles` WHERE id = ".$id;
		$result = mysqli_query($MAINBD, $query);
		$data = mysqli_fetch_array($result);


		$data['poster'] = mysqli_fetch_array(mysqli_query($ADDITIONALBD, "SELECT * FROM `".$id."-Images` WHERE status = 'poster'"));

		return $data;
	}



}
