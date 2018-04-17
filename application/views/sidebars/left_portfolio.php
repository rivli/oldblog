<div class="menu-buttons">

      <a class="menu-button" href="/" title="Портфолио">П</a>
      <a class="menu-button" href="/blog" title="Блог">Б</a>

</div>

<div class="left-sidebar sb">
  <?php if ($_SESSION['ulogin'] != 'logined') { ?>
  <div class="item">
    <div class="item-name">
      Авторизация
    </div>
    <div class="autorization">

      <form id="autorizationForm" action="/blog/signin" method="post">
        <input type="text" name="login" placeholder="login"><br>
        <input type="password" name="password" placeholder="password"><br>
        <input type="submit" class="form-button" name="submit" value="Submit">
      </form>
    </div>
  </div>
<?php } else if ($_SESSION['upost'] == 'admin') { ?>
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
