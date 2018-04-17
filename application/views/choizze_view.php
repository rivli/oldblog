
<div id="wrapper">

  <div id="page">


        <div class="cool-div">
          <div class="content">
            О том как я создавал CHOIZZE - свой первый сайт. Планы и нововведения.
            В этом сайте нет даже MVC, но на нем я научился AJAX и всяким событиям JS/jQuery.<br>
            Ссылка: <a href="https://choizze.com" target="_blank">choizze.com</a><br>
            GitHub: <a href="https://github.com/zakilvir/choizze" target="_blank">choizze</a><br>
          </div>
        </div>
<?php
$i=COUNT($data['articles']);
if ($i == 0) {
  echo "No articles yet.";
} else {
  $i--;
  while ($i >= 0) {
    $row = $data['articles'][$i];

    echo '<div class="article-output">
    <img class="article-image" src="'.$row['poster'].'" width="100%">

    <div class="article-name"><a href="/blog/article/'.$row['id'].'" style="text-decoration:none;">'.$row['name'].'</a></div>
    </div>';
    $i--;
  }
}
?>
  <br class="clearfix" />
  </div>
</div>
