<?php
$left_sb_name = 'standart';
$right_sb_name = 'standart';
 ?>


<div id="wrapper">

  <div id="page">
<?php

if ($data['articlesnum'] == 0) {
  echo "No articles yet.";
} else {

$i=COUNT($data['articles']);
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
