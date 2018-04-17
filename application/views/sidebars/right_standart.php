
<div class="right-sidebar sb">

  <form class="" action="/search" name="searchingForm" method="post">
    <input type="text" name="query" placeholder="Найти" id="searching-query">
  </form>

  <div class="item">
    <div class="item-name">
      Топ статей
    </div>
    <div class="item-body bg-inh">
<?php $TopArticles = TopArticles(3);

$i=COUNT($TopArticles);
if ($i == 0) {
  echo "No articles yet.";
} else {
  $i--;
  while ($i >= 0) {
    $row = $TopArticles[$i];

    echo '<div class="article-output mb-10">
    <img class="article-image" src="'.$row['poster'].'" width="100%">

    <div class="article-name"><a href="/blog/article/'.$row['id'].'" style="text-decoration:none;">'.$row['name'].'</a></div>
    </div>';
    $i--;
  }
}

 ?>
     </div>
  </div>

</div>
