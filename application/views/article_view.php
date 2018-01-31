<?php if ($_SESSION['upost'] == 'admin') { ?>
<div class="right-sidebar sb">
  <div class="item">
    <div class="item-name">
      Админ панель
    </div>
    <div class="categories">
      <ul>
      <a href="/blog/edit/<?php echo $data['id'] ?>"><li>Редактировать</li></a>
        <a href="#" onclick="areyousure()"><li>Удалить</li></a>
      </ul>
    </div>
  </div>
</div>

    <script type="text/javascript">
    function areyousure() {
        var areYouSure = confirm("Вы уверены, что хотите удалить статью?");
         if (areYouSure) location.href = "/blog/delete/<?php echo $data['id'] ?>";
    }
    </script>
<?php } ?>
<?php if ($data['poster']) { ?>
<div class="image-block">
<div class="desc" style="background: url(<?php echo $data['poster']['url'] ?>);background-position: center center; /* Положение фона */
background-repeat: no-repeat; background-size: cover;width:<?php echo $data['poster']['width'] ?>%;max-width:50%; ">

</div>
<div class="image-description">
  <?php echo $data['poster']['description'] ?>
</div>
</div>
<?php } ?>

<div id="wrapper">

  <div id="page">

    <div id="content">
      <table class="article-nameblock">
        <tr>
          <td class="article-name-inside"><?php echo $data['name'] ?></td>
          <td><?php echo $data['category'] ?></td>
        </tr>
      </table>
        <div class="article">
          <?php echo htmlspecialchars_decode($data['description']) ?>
        </div>



    </div>
    <!-- Put this div tag to the place, where the Comments block will be -->
		<!--VK Comments-->
    <div id="vk_comments"></div>
    <script type="text/javascript">
    VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
    </script>
  </div>
</div>
