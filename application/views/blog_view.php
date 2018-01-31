<div class="left-sidebar sb">
  <div class="item">
    <div class="item-name">
      Категории
    </div>
    <div class="categories">
      <ul>
        <?php
          $i = $data['catsnum'] - 1;

          while($i >= 0) {
            echo '<a href="/blog/cat/'.$data['categories'][$i]['url-code'].'" title="'.$data['categories'][$i]['desc'].'"><li class="first ';
            if ($routes[3] == $data['categories'][$i]['name']) echo "active";
            echo '">'.$data['categories'][$i]['name'].'</li></a>';
              $i--;
          }
        ?>
      </ul>
    </div>
  </div>
</div>


<?php if ($_SESSION['upost'] == 'admin') { ?>
<div class="right-sidebar sb">
  <div class="item">
    <div class="item-name">
      Админ панель
    </div>
    <div class="categories">
      <ul>
        <a href="/blog/addpost"><li>Добавить статью</li></a>
        <a href="/blog/addcat"><li>Добавить категорию</li></a>
        <a href="/blog/signout"><li>Выйти</li></a>
      </ul>
    </div>
  </div>
</div>
<?php } ?>

<div id="wrapper">

  <div id="page">
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

    <div class="article-name"><a href="blog/article/'.$row['id'].'" style="text-decoration:none;">'.$row['name'].'</a></div>
    </div>';
    $i--;
  }
}
?>
  <br class="clearfix" />
  </div>
</div>

<script type="text/javascript">
 function showLoginForm() {
      $(".autorization").fadeIn();
    }
  function closeLoginForm() {
      $(".autorization").fadeOut();
    }

      $("#signIn").bind('click',function() {
        var login   = $('#autorizationForm').serialize();
        $.ajax({
            url: "/ajax/signin",
            type: "POST",
            data: login,
            dataType: "html",
            beforeSend: funcBefore,
            success: funcSuccess
        });
    });

    function funcBefore() {
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
        setTimeout(function(){$('.messageshow').fadeOut('swing')},5000);  //10000 = 10 секунд
    }

        function funcSuccess(data) {
        $('.messageshow').hide();  //10000 = 10 секунд
	      $("body").prepend('<div class="messageshow" style="background:#2b3540" >'+data+'</div>');
        setTimeout(function(){$('.messageshow').fadeOut('swing')},5000);  //10000 = 10 секунд
        location.reload();
    }
</script>
