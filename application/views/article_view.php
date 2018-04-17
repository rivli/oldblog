<?php

  $left_sb_name = 'article';
  $right_sb_name = 'article';
 ?>

<div id="wrapper">
  <?php if ($data['poster']) { ?>
  <div class="image-block">
  <div class="desc" style="background: url(<?php echo $data['poster']['url'] ?>);background-position: center center; /* Положение фона */
  background-repeat: no-repeat; background-size: cover;width:<?php echo $data['poster']['width'] ?>%; ">

  </div>
  <div class="image-description">
    <?php echo $data['poster']['description'] ?>
  </div>
  </div>
  <?php } ?>
  <div id="page">

    <div id="content">
      <table class="article-nameblock">
        <tr>
          <td class="article-name-inside"><?php echo $data['name'] ?></td>
          <td><?php echo '<a href="/blog/cat/'.$data['category']['URL'].'" title="'.$data['category']['desc'].'">'.$data['category']['name'].'</a>' ?></td>
        </tr>
      </table>
        <div class="article">
          <?php echo htmlspecialchars_decode($data['description']) ?>
        </div>

        <div class="tags">
          <?php
                  $articleTags = str_replace(',', ' ', $data['tags']);//заменяет запятые на пробелы
          				$articleTags = preg_replace("|[\s]+|i"," ",$articleTags);//удаляет лишние пробелы
          				$articleTags = mb_strtolower($articleTags);//переводит строку в нижний регистр
          				$articleTags = explode(" ",$articleTags);
                  foreach ($articleTags as $key => $value) {
                    if ($key == 0) {
                      echo '<a class="tag" href="/search/tag/'.$value.'">#'.$value.'</a>';
                    } else {
                      echo ', <a class="tag" href="/search/tag/'.$value.'">#'.$value.'</a>';
                    }
                  }
                   ?>
        </div>
        <table class="w-100" style="margin-top: 5px;border-top: 1px solid #b7b7b7;">
          <tr>
            <td><?php echo $data['date'].' '.$data['time'] ?></td>
            <td class="fl-r"><?php echo 'Просмотров: '.$data['visits'] ?></td>
          </tr>
        </table>


    </div>
    <!-- Put this div tag to the place, where the Comments block will be -->
		<!--VK Comments-->
    <div id="vk_comments"></div>
    <script type="text/javascript">
    VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
    </script>
  </div>
</div>
