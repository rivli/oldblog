<?php
$left_sb_name = 'standart';
$right_sb_name = 'standart';
 ?>


<div id="wrapper">

  <div id="page">
<?php 	$routes = explode('/', $_SERVER['REQUEST_URI']);
if (!$routes[3]) { ?>
      <form class="" action="/search" name="searchingForm" method="post">
        <input type="text" name="query" placeholder="Найти" class="searching-query" value="<?php if ($_POST['query']) echo $_POST['query']; ?>" id="searching-query">
      </form>
<?php } ?>

<?php
$i=COUNT($data['articles']);
if ($i == 0) {
  echo "No coincidences.";
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
