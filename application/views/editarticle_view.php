<?php
  $left_sb_name = 'article';
  ?>
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

      <form class='addpost' id="articleForm" method="POST" action="/blog/edit/<?php echo $data['id'] ?>" enctype="multipart/form-data">
          <input type="text" name="name" id="name" value="<?php echo $data['name'] ?>" width="100%" maxlength="100" title="Не менее 4 и неболее 20 латынских символов или цифр." required><br>
          <select  name="category" id="category">
                <?php
                  $i = $data['catsnum'] - 1;

                  while($i >= 0) {
                    if ($data['category'] == $data['categories'][$i]['URL']) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    };
                      echo '<option value="'.$data['categories'][$i]['URL'].'" '.$selected.'>'.$data['categories'][$i]['name'].'</option>';
                      $i--;
                  }
                ?>
          </select>
          <div class="main-input" id="article" name="text" contenteditable="true" onclick="checkPlacholder()" required>
            <?php echo htmlspecialchars_decode($data['description']) ?>
          </div>
          <input type="hidden" name="description" id="articleHided">
          <input type="text" name="tags" id="tags" value="<?php echo $data['tags'] ?>" title="Теги через запятую." required><br>
          <input type="hidden" name="imagesNumber" id="imagesNumber" value="0">
          <input type="hidden" name="save-as-draft" id="save-as-draft" value="0">
          <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
          <input type="submit" name="enter" class="form-button green" value="Сохранить черновик" onclick="addPost(1)">
          <input type="submit" name="enter" class="form-button fl-r" value="Сохранить" onclick="addPost(2)">
        </form>
    </div>
  </div>

</div>


<div class="form-buttons-container">
  <div class="additional-button" id="add-video" title="add video">
    video
  </div>
  <div class="additional-button" id="add-quote" title="add quote">
    quote
  </div>
  <div class="additional-button" id="add-code" title="add code">
    code
  </div>
  <div class="additional-button" id="add-link" title="add link">
    link
  </div>
  <div class="additional-button" id="add-h3" title="add h3" style="font-weight:bold;">
    <h3>h3</h3>
  </div>
</div>


<script src="/js/form.js" type="text/javascript"></script>
