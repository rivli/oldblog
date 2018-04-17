<?php

class Model_Search extends Model
{

	public function tag($tags)
	{
    $MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
		$data['articles'] = array();
		$searchingWords = $tags;
		$searchingWords = str_replace(',', ' ', $searchingWords);
		$searchingWords = preg_replace("|[\s]+|i"," ",$searchingWords);
		$searchingWords = rawurldecode($searchingWords);
		$searchingWords = mb_strtolower($searchingWords);
		$tags = explode(" ",$searchingWords);
		$tagsNum = COUNT($tags);

		$articlezesNumber = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `articles`"));
		$i = $articlezesNumber[0];
		while ($i >= 1) {
				$article = GetArtcile($i);
				if ($article['status'] == 'published') {
				$j = $tagsNum - 1;
				$articleTags = str_replace(',', ' ', $article['tags']);//заменяет запятые на пробелы
				$articleTags = preg_replace("|[\s]+|i"," ",$articleTags);//удаляет лишние пробелы
				$articleTags = mb_strtolower($articleTags);//переводит строку в нижний регистр
				$articleTags = explode(" ",$articleTags);
				while($j >= 0) {
					if (in_array($tags[$j], $articleTags)) {
						if (!$article['foundtags']) {
							$article['foundtags'] = $tags[$j];
						} else {
							$article['foundtags'] = $article['foundtags'].', '.$tags[$j];
						}
						$data['articles'][] = $article;
					}
					$j--;
				}
			}
			$i--;
		}
		return $data;
	}

	public function search()
	{
	$data['articles'] = array();
		if ($_POST['query']) {
    $MAINBD = mysqli_connect(HOST, USER, PASS, DB) or die("Ошибка MySQL: " . mysql_error());
      $searchingWords = $_POST['query'];


        $searchingWords = str_replace(',', ' ', $searchingWords);
        $searchingWords = preg_replace("|[\s]+|i"," ",$searchingWords);

        $tags = explode(" ",$searchingWords);
        $tagsNum = COUNT($tags);


        //------------------------Получаем данные совпадений из опросов и закдючаем все в массив SEA - SearchEngineArray
        $articlezesNumber = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `articles`"));
        $i = $articlezesNumber[0];
        $SEA = array();//SearchEngineArray
        while ($i >= 1) {
        $article = GetArtcile($i);
        if ($article['status'] == 'published') {
        $j = $tagsNum - 1;


        //подготовка текста
        $articleText = ' '.$article['name'].' '.$article['description'].' ';
        $articleText = str_replace(',', ' ', $articleText);//заменяет запятые на пробелы

				$articleText = preg_replace('/[^a-zA-Zа-яА-Я0-9]/', ' ', $articleText ); // Удаляем


        $articleText = preg_replace("|[\s]+|i"," ",$articleText);//удаляет лишние пробелы
        $articleText = mb_strtolower($articleText);//переводит строку в нижний регистр
//echo $articleText;
$SEA[$i]['number of coincidences'] = 0;
$SEA[$i]['number of tags'] = 0;
        while($j >= 0) {
            $tags[$j] = mb_strtolower($tags[$j]);
            //echo "<hr>".$tags[$j]."<hr><hr>";
            $SEA[$i]['number of coincidences'] += mb_substr_count($articleText, ' '.$tags[$j].' ');//считает количество совпадений данного тега и приплюсовывает к сумме совпадений всех тегов
            //echo $SEA[$i]['number of coincidences'];
            if (mb_substr_count($articleText, ' '.$tags[$j].' ') > 0) {//если совпадения есть, то получаем координаты этих совпадений
                $z = 0;
                while ($z < mb_substr_count($articleText, ' '.$tags[$j].' ')) {//перебираем все совпадения записываем в двумерный массив как : ТЕГ - Номер тега - координата
                if ($z == 0) {// если первое совпадение то берем начало координат от самого начала
                    $SEA[$i]['tags'][$tags[$j]][$z] = mb_strpos($articleText, ' '.$tags[$j].' ');
                } else {//если 2ое и далее, то смещаем координату на координату предыдущего тега + 3 ($SEA[$i]['tags'][$tags[$j]][$z1] + 3)
                    $z1 = $z - 1;
                    $SEA[$i]['tags'][$tags[$j]][$z] = mb_strpos($articleText, ' '.$tags[$j].' ', $SEA[$i]['tags'][$tags[$j]][$z1] + 3);
                }
                $z++;
                }
            };
            if ( mb_substr_count($articleText, ' '.$tags[$j].' ') != 0) {//счетчик количества тегов найденных в опросе, без повторений. Далее это параметр b.
            $SEA[$i]['number of tags'] += 1;
            }
            $j--;
        };

        if ($SEA[$i]['number of coincidences'] == 0) {//если совпадений совсем нет, то удаляем этот опрос из массива поиска SEA
          unset($SEA[$i]);
        }
        }
        $i--;
        };

        $SCounter = COUNT($SEA);//Количество подходящих опросов

        /*----------------------------------Получаем все параметры уравнения - a,b,c ----------------------
        a - Количество пар тегов которые находятся в таком же порядке, как и в запросе поиска
        b - количество тегов, которые есть в опросе, без повторений
        c - общее количество совпадений

        все параметры сохраняем в SEAUnS - SEA Unsorted

        уравнение Ранга = 3*a+2*b+c = 'SRang'
        */

        $SEAUnS = array();//SEA Unsorted
        //---------------------------------Получаем параметр а-----------------

        //---новый массив: Id опроса - координата тега - тег
        foreach ($SEA as $articleId => $articleSearchingData) {
          foreach ($articleSearchingData['tags'] as $tag => $tagValues) {
            foreach ($tagValues as $key => $value) {
              $TagsInarticleUnsorted[$articleId][$value]=$tag;
            }
          }
        }

        //---Сортировка по координате
        $TagsInarticleSorted = array();
        foreach ($TagsInarticleUnsorted as $articleId => $value) {
          ksort($value);
          $TagsInarticleSorted[$articleId] = $value;
        }


        //---Замена координат на порядковый номер - 0,1,2...
        foreach ($TagsInarticleSorted as $articleId => $TagsInarticle) {
          $i = 0;
          foreach ($TagsInarticle as $key => $value) {
            $TagsInarticleSorted[$articleId][$i] = $value;
            unset($TagsInarticleSorted[$articleId][$key]);
            $i++;
          }
        }
        // получен сортированный массив $TagsInarticleSorted вида: id опроса - порядок тега в тексте опроса - тег
        //--- сам процесс подсчета параметра а
        foreach ($TagsInarticleSorted as $articleId => $TagsInarticle) {
          //echo '<h1>'.$articleId.'</h1>';
          if ($SEA[$articleId]['number of tags'] > 1) {//если меньше 1го находить пару бесполезно
            foreach ($TagsInarticle as $key => $value) {

                          //далее узнаем какой номер нашего тега в поисковом запросе - $i
                          $i = 0;
                          while ($i < $tagsNum) {
                            if ($tags[$i] == $value) {
                              break;
                            } else {
                              $i++;
                            };
                          };
                            //echo $value.' :<br>';
                    //перебираем все теги из поискового запроса:
                    foreach ($tags as $tagKey => $tag) {
                        //echo $tagKey.' - $tagKey  >? $i - '.$i;
                      if ($tagKey > $i) {//берем только те теги из запроса, которые идут после нашего

                        //перебираем все теги найденные в опросе
                        foreach ($TagsInarticle as $key2 => $value2) {
                            //сравниваем теги из опроса и запроса
                            //берем только теги идущие после нашего в опросе

                            if ($value2 == $tag and $key2 > $key) {
                              $SEAUnS[$articleId]['a'] = $SEAUnS[$articleId]['a'] + 1/($key2 - $key);//1 делим на расстояние между тегами в опросе тем самым уменьшаем ранг для дальних тегов

                              //echo '<br><br>'.$value.'['.$key.'] ? '.$value2.'['.$key2.']';
                              //echo '<br>a = '.$SEAUnS[$articleId]['a'].'<br>';
                            }
                        }

                      }
                      //echo '<hr>';
                    }

              }




          } else {
            $SEAUnS[$articleId]['a'] = 0;
          }
          //echo '<hr>';
        }

        //---------------------------------Получаем параметр b------------------
        foreach ($SEA as $articleId => $value) {
          $SEAUnS[$articleId]['b'] = $SEA[$articleId]['number of tags'];
        }
        //---------------------------------Получаем параметр c------------------
        foreach ($SEA as $articleId => $value) {
          $SEAUnS[$articleId]['c'] = $SEA[$articleId]['number of coincidences'];
        }

        //-------------------Считаем уравнение SRang-----------------------
        foreach ($SEAUnS as $articleId => $value) {
          $SEAUnS[$articleId]['SRang'] = 3*$SEAUnS[$articleId]['a']+2*$SEAUnS[$articleId]['b']+$SEAUnS[$articleId]['c'];
        }

        //-----------------Cортируем массив SEAS--------------------------
        foreach ($SEAUnS as $articleId => $value) {
          $SEAS[$articleId] = $SEAUnS[$articleId]['SRang'];
          arsort($SEAS);
        }


      //не удалять строки для проверки
/*
        echo '<br>TagsInarticleSorted';
        if (!empty($TagsInarticleSorted)) {
        echo '<pre>';
        print_r($TagsInarticleSorted);
        echo '</pre>';
        };


        echo '<br>TagsInarticleUnsorted';
        if (!empty($TagsInarticleUnsorted)) {
        echo '<pre>';
        print_r($TagsInarticleUnsorted);
        echo '</pre>';
        };


        echo '<br>Первоначальный Массив';
        if (!empty($SEA)) {
        echo '<pre>';
        print_r($SEA);
        echo '</pre>';
        } else {
          echo 'Совпадений не найдено';
        }

        echo '<br>SEAUnS';
        if (!empty($SEAUnS)) {
        echo '<pre>';
        print_r($SEAUnS);
        echo '</pre>';
        } else {
          echo 'Совпадений не найдено';
        }

        echo '<br>Cортированный массив по рангу';
        if (!empty($SEAS)) {
        echo '<pre>';
        print_r($SEAS);
        echo '</pre>';
        };
*/


$data = $SEAS;
foreach($SEAS as $key => $val) {
    $data['articles'][] = GetArtcile($key);
}
} else {
	$_POST['query'] = null;
}
		return $data;
	}
}
