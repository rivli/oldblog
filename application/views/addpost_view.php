<?php //vardump($data); ?>
<div class="plsaddposter">Добавьте Постер</div>

<div id="wrapper">

  <div id="page">

    <div id="content">








        <form class='addpost' id="articleForm" method="POST" action="/blog/query_addpost" enctype="multipart/form-data">

            <div id="poster-settings">
                <span class="bold-text">Poster settings</span><br>
                <input type="file" id='poster' name="poster"><br>
                <div class="hided" id="hided-settings">
                  Width
                  <input type="range" min="1" max="50" name="poster_width" style="width:98%;" step="1" value="100" id="poster-width"><br>
                  <!--<input id="poster-width-like-wrapper" type="button" value="По ширине статьи" onclick="changePoster()"><br>-->
                  <input type="text"name="poster_description" style="width:98%;" id="poster_description" onchange="changePosterDesc()" placeholder="Описание"><br>
                  <input type="hidden" name="poster_status" value="poster">
                </div>

                </div>
            <input type="text" name="name" id="name" placeholder="Имя" width="100%" maxlength="100" title="Не менее 4 и неболее 20 латынских символов или цифр." required>
            <br>
                    <select  name="category" id="category">
                      <option disabled selected>Выберите категорию</option>
                          <?php
                            $i = $data['catsnum'] - 1;

                            while($i >= 0) {
                                echo '<option value="'.$data['categories'][$i]['name'].'">'.$data['categories'][$i]['name'].'</option>';
                                $i--;
                            }
                          ?>
                    </select>

          <!--<textarea type="text" name="description" placeholder="Описание Опроса" cols="60" rows="5" required></textarea>-->
          <div class="main-input" id="article" name="text" contenteditable="true" onclick="checkPlacholder()" required>
            <span class="main-input-placeholder">Вашa статья</span>
          </div>
          <input type="hidden" name="description" id="articleHided" required>
          <input type="text" name="tags" id="tags" placeholder="Теги" title="Теги через запятую." required>




<br>    <input type="hidden" name="imagesNumber" id="imagesNumber" value="0">
          <input type="submit" name="enter" class="form-button" value="Сохранить" onclick="addPost()">
        </form>

    </div>
  </div>
</div>


<div class="form-buttons-container">
  <div class="additional-button" id="add-image" title="add image">
    image
  </div>
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



<script type="text/javascript">
function addPost() {

  var elems = $(".image-block");
  var elemsTotal = elems.length;
  for(var i=0; i<elemsTotal; ++i){
    var idOnTable = parseInt($(elems[i]).attr("id").split("-")[1]);
    $(elems[i]).replaceWith("$IMG"+idOnTable);
  }



  $('#articleHided').val($('#article').html())
}


    function changePosterDesc() {
    $(".image-description").html($("#poster_description").val());
  }

function readURL(input) {// take url for image from form and set it to the poster place

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#hided-settings").show();
        $("#image").remove();
        $('.plsaddposter').remove();
        $('.poster-description-block').remove();
         $("#wrapper").before('<div class="image-block"><div class="desc" id="image" style="background: url('+e.target.result+');background-position: center center; background-repeat: no-repeat; background-size: cover;max-width:50%; "></div><div class="poster-description-block image-description"></div></div>');
      };

      reader.readAsDataURL(input.files[0]);
  }
}

function imageURL(input,id) {// take url for image from form and set it to the poster place
  if (input.files && input.files[0]) {
      var reader = new FileReader();

      var fileName = $("#file-image-"+id).val().split('.');
      var fileFormat = fileName[fileName.length - 1];

      reader.onload = function (e) {
        $("#image-"+id).css("background", "url("+e.target.result+")");
        $("#image-"+id).css("background-position", "center center");
        $("#image-"+id).css("background-repeat", "no-repeat");
        $("#image-"+id).css("background-size", "cover");

      };

      reader.readAsDataURL(input.files[0]);
  }
}

$("#poster").change(function(){//set poster
  readURL(this);
    $("#poster-width").val(50);
});

$("#poster-width").change(function(){
  $(".desc").css("width", $("#poster-width").val() + "%");
});

function changePoster() {
  $("#poster-width").val(50);
  $(".desc").css("width",  "50%");
}

$("#article").focusout(function() {
  if ($("#article").is(':empty')) {
    $("#article").html('<span class="main-input-placeholder">Вашa статья</span>');
  }
  })


  $(document).ready(function() {//hiding poster settings
    $(window).scroll(function () {
      if ($(this).scrollTop() > 300) $('#poster-settings').fadeOut();
      else $('#poster-settings').fadeIn();
    });
  });

var imagesNumber = 1;


  $("#add-image").click(function () {
    if ($(".main-input-placeholder").html()) {
        $(".main-input").empty();
    }

    $("#article").append('<div class="image-block" id="image-'+imagesNumber+'-block"><div class="image-place"  contenteditable="false" id="image-'+imagesNumber+'"></div><div class="image-description" contenteditable="false" id="image-'+imagesNumber+'-description"></div></div>')

  //  $("#articleForm").append('<div class="blackblock" id="bb-'+$imagesNumber+'" style="top:'+$("#image-"+$imagesNumber).offset().top+'px;"></div>')



  var position = $("#image-"+imagesNumber).position().top + 10;
    $("#articleForm").append('            <div class="image-settings" id="image-'+imagesNumber+'-settings" style="top:'+position+'px;">'+
                    '<span class="bold-text">Image settings</span><br>'+
                    '<input type="file" id="file-image-'+imagesNumber+'" onchange="imageURL(this,'+imagesNumber+')" name="file-image-'+imagesNumber+'"><br>'+
                    '<input type="text" name="image-'+imagesNumber+'-description"  id="image-'+imagesNumber+'-description-input" onchange="changeDesc('+imagesNumber+')" placeholder="Описание"><br>'+
                    '<input type="button" name="delete" class="form-button" style="background:rgb(35, 130, 20);border-color:rgb(35, 130, 20);" value="Delete" onclick="removeImage('+imagesNumber+')">'+
      '</div>');
                    $("#imagesNumber").val(imagesNumber);
                    imagesNumber++;

  });

    function changeDesc(id) {
    $("#image-"+id+"-description").html($("#image-"+id+"-description-input").val());
  }

    function removeImage(id) {
    $("#image-"+id+"-block").remove();
    $("#image-"+id+"-settings").remove();
  }


    $("#add-code").click(function () {
      if ($(".main-input-placeholder").html()) {
          $(".main-input").empty();
      }

      $("#article").append("<pre class='code-block'>Here code</pre><br>")
    });


    $("#add-quote").click(function () {
          if ($(".main-input-placeholder").html()) {
              $(".main-input").empty();
          }

          $("#article").append("<div class='quote-block'><q>Here quote</q><div class='q-author'>Author here</div></div><br>")
    });

    function appendLink() {
      var linkUrl = $("#link-url").val();
      var linkTitle = $("#link-title").val();
      if (linkUrl && linkTitle) {
                if ($(".main-input-placeholder").html()) {
          $(".main-input").empty();
      }

        $("#article").append("<a class='cool-link' href="+linkUrl+">"+linkTitle+"</a>");
        closeWindow();
      } else if (!linkUrl) {
        alert("fill URL");
      } else if (!linkTitle) {
        alert("fill Title");
      } else alert("fill in fields");

    };

    $("#add-link").click(function () {
      $("body").prepend('<div class="windowBlock" >'+
                            '<div class="newWindow" >'+
                              '<div class="winHead">'+
                                '<div class="winName">Add link</div>'+
                                '<div class="winClose" onclick="closeWindow()">Close</div>'+
                              '</div>'+
                              '<div class="winContent">'+
                                  '<form class="">'+
                                    '<input type="text" id="link-url" placeholder="URL" required><br>'+
                                    '<input type="text" id="link-title" placeholder="title" required><br>'+
                                    '<input type="button" id="add-link" class="form-button" style="background:rgb(35, 130, 20);border-color:rgb(35, 130, 20);" value="add" onclick="appendLink()">'+
                                  '</form>'+
                              '</div>'+
                            '</div>'+
                          '</div>');

    })

    function appendVideo() {
      var videoCode = $("#video-code").val();
      if (videoCode) {
                if ($(".main-input-placeholder").html()) {
          $(".main-input").empty();
      }

        $("#article").append('<div class="centrator">'+videoCode+'</div><br>');
        closeWindow();
      } else alert("fill in code");

    };

    $("#add-video").click(function () {
      $("body").prepend('<div class="windowBlock" >'+
                            '<div class="newWindow" >'+
                              '<div class="winHead">'+
                                '<div class="winName">Add Video</div>'+
                                '<div class="winClose" onclick="closeWindow()">Close</div>'+
                              '</div>'+
                              '<div class="winContent">'+
                                  '<form class="">'+
                                    '<textarea id="video-code" placeholder="Code" style="width:100%;" required></textarea><br>'+
                                    '<input type="button" id="add-video" class="form-button" style="background:rgb(35, 130, 20);border-color:rgb(35, 130, 20);" value="add" onclick="appendVideo()">'+
                                  '</form>'+
                              '</div>'+
                            '</div>'+
                          '</div>');

    })

    $("#show-code").click(function () {
      if ( $("#article").parent().is( "code" ) ) {
    $("#article").unwrap();
  } else {
    $("#article").wrap( "<code></code>" );
  }

});

      $("#add-bold-text").click(function () {
        if ($(".main-input-placeholder").html()) {
          $(".main-input").empty();
      }

      $("#article").append('<span style="font-weight:bold;">Here your text</span><br><br>');
      })

      $("#add-h3").click(function () {
        if ($(".main-input-placeholder").html()) {
          $(".main-input").empty();
      }

      $("#article").append('<h3>Here your text</h3><br>');
      })

</script>
