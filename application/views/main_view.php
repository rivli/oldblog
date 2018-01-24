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
        <span onclick="showLoginForm()" style="cursor:pointer;">Sign In</span>
      <br class="clearfix" />
    </div>
    <br class="clearfix" />
  </div>

</div>


<div class="autorization">
    <div class="windname">
        <span class="signin">Sign In</span>
    <span class="closewind" onclick="closeLoginForm()">Close</span>
    </div>

  <form id="autorizationForm" action="" method="post">
    <input type="text" name="login" placeholder="login"><br>
    <input type="password" name="password" placeholder="password"><br>
    <input type="button" class="form-button" name="submit" value="Submit" id="signIn">
  </form>
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
    }
</script>
