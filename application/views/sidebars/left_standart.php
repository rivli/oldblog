<div class="menu-buttons">

      <a class="menu-button" href="/" title="Портфолио">П</a>
      <a class="menu-button" href="/blog" title="Блог">Б</a>

</div>

<div class="left-sidebar sb">
  <div class="item">
    <div class="item-name">
      Категории
    </div>
    <div class="categories item-body">
      <ul>
        <?php
          $i = $data['catsnum'] - 1;

          while($i >= 0) {
            echo '<a href="/blog/cat/'.$data['categories'][$i]['URL'].'" title="'.$data['categories'][$i]['desc'].'"><li class="first ';
            if ($routes[3] == $data['categories'][$i]['URL']) echo "active";
            echo '">'.$data['categories'][$i]['name'].'</li></a>';
              $i--;
          }
        ?>
      </ul>
    </div>
  </div>

  <?php if ($_SESSION['upost'] == 'admin') { ?>
  <div class="item">
    <div class="item-name">
      Админ панель
    </div>
    <div class="categories item-body">
      <ul>
        <a href="/blog/addpost"><li>Добавить статью</li></a>
        <a href="/blog/addcat"><li>Добавить категорию</li></a>
          <a href="/blog/drafts"><li>Drafts</li></a>
          <a href="/blog/deleted"><li>Deleted</li></a>
        <a href="/blog/signout"><li>Выйти</li></a>
      </ul>
    </div>
  </div>
  <?php } ?>
</div>
