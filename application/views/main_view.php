<?php if ($_SESSION['ulogin'] != 'logined') { ?>
<div class="left-sidebar sb">
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
</div>
<?php } ?>

<div class="image-block">
  <div class="desc" style="background: url('/images/desc/main_desc.jpg');background-position: center center; /* Положение фона */
  background-repeat: no-repeat; background-size: cover;width:50%; ">
  </div>
</div>

<div id="wrapper">
  <div id="page">
    <div id="content">
        <h1>Добро пожаловать!</h1>
        <p>
          Я Закирьянов Ильвир.
        </p>
    </div>
  </div>
</div>
