<div class="right-sidebar sb">
  <?php if ($_SESSION['upost'] == 'admin') { ?>
  <div class="item">
    <div class="item-name">
      Админ панель
    </div>
    <div class="categories item-body">
      <ul>
      <a href="/blog/edit/<?php echo $data['id'] ?>"><li>Редактировать</li></a>
        <a href="#" onclick="areyousure()"><li>Удалить</li></a>
      </ul>
    </div>
  </div>
  <script type="text/javascript">
  function areyousure() {
      var areYouSure = confirm("Вы уверены, что хотите удалить статью?");
       if (areYouSure) location.href = "/blog/delete/<?php echo $data['id'] ?>";
  }
  </script>
<?php } ?>
</div>
