<?php

class Model_Ajax extends Model
{

	public function get_data()
	{

		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());

		$query = "SELECT * FROM `articles`";
		$result = mysqli_query($MAINBD, $query);
		$articles= array();

		while ($categorie = mysqli_fetch_assoc($result)) {
			$articles[] = $categorie;
		}
		$data['articles'] = $articles;
		$articlesnum = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `articles`"));
		$data['articlesnum'] = $articlesnum[0];
		return $data;
	}

  public function signin($post)
	{
		if ($post['login'] == 'admin' and $post['password'] == 'admin') {
			return 'Вы успешно авторизовались!!';
		} else {
			return 'логин или пароль введены не верно';
		}
		$MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());

	}

}
