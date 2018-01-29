<!--<div id="categories">
  <ul> <
    <li class="first active"><a href="#">Travel</a></li>
    <li><a href="#">Space</a></li>
    <li><a href="#">Programming</a></li>
    <li><a href="#">Electrocars</a></li>
    <li class="last"><a href="#">Books</a></li> >
  </ul>
  <br class="clearfix" />
</div>-->

<div class="left-sidebar">
  <div class="ls-item">
    <div class="ls-item-name">
      Категории
    </div>
    <div class="categories">
      <ul>
        <a href="#"><li class="first active">Travel</li></a>
        <a href="#"><li>Space</li></a>
        <a href="#"><li>Programming</li></a>
        <a href="#"><li>Electrocars</li></a>
        <a href="#"><li class="last">Books</li></a>
      </ul>
    </div>
  </div>
</div>

<div id="wrapper">

  <div id="page">


<!--<h2 style="border-bottom:1px solid black;"><span style="font-weight:bold;">FEATURED</span> <span style="cursor:pointer">TOP</span> <span style="font-weight:bold;float:right;cursor:pointer;" onclick="openWindow('Information', '/window/information')">Information</span> </h2>-->

<?php
$i=COUNT($data['articles']);
$i--;
while ($i >= 0) {
  $row = $data['articles'][$i];

  echo '<div class="article-output">
  <img class="article-image" src="'.$row['poster'].'" width="100%">

  <div class="article-name"><a href="blog/article/'.$row['id'].'" style="text-decoration:none;">'.$row['name'].'</a></div>
  </div>';
  $i--;
}

?>




    <br class="clearfix" />
  </div>
</div>
