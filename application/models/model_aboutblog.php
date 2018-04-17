<?php

class Model_Aboutblog extends Model
{

	public function get_data()
	{

		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$ADDITIONALBD = mysqli_connect(HOST, USER_AD, PASS, DB_AD) or die("Ошибка MySQL: ".mysql_error());

		$articles= array();

		$query = "SELECT * FROM `articles`  WHERE category = 'aboutblog'";
		$result = mysqli_query($MAINBD, $query);


		while ($categorie = mysqli_fetch_assoc($result)) {
		if($categorie['poster'] == 'img') {
			$poster = mysqli_fetch_array(mysqli_query($ADDITIONALBD, "SELECT * FROM `".$categorie['id']."-Images` WHERE id = '1'"));

			if (!$poster['url']) {
				$poster['url'] = "/images/iz.png";
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
}
