<?php
class View
{

	//public $template_view; // здесь можно указать общий вид по умолчанию.

	/*
	$content_file - виды отображающие контент страниц;
	$template_file - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	*/
	function generate($content_view, $template_view, $data = null)
	{
		if(is_array($content_view)) {
			$title = $content_view['title'];
			$content_view = $content_view['content'];
			} else {
			$page_desc = false;
		}
		/*
		if(is_array($data)) {

			// преобразуем элементы массива в переменные
			extract($data);
		}
		*/

		/*
		динамически подключаем общий шаблон (вид),
		внутри которого будет встраиваться вид
		для отображения контента конкретной страницы.
		*/
		include 'application/views/'.$template_view;
	}
}
