function openWindow(name, url) {
      $.ajax({
        url: url,
        type: "POST",
        data: {
        "name": name
    },
        dataType: 'html',
        success: funcSuccess
      });




  function funcBefore() {
      $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
      setTimeout(function(){$('.messageshow').fadeOut('swing')},5000);  //10000 = 10 секунд
  }

      function funcSuccess(data) {
      $('.messageshow').hide();  //10000 = 10 секунд
      $("body").prepend('<div class="windowBlock" ><div class="newWindow" ><div class="winHead"><div class="winName">'+name+'</div><div class="winClose" onclick="closeWindow()">Close</div></div><div class="winContent">'+data+'</div></div></div>');
  }

}



function checkPlacholder() {
    if ($(".main-input-placeholder").html()) {
        $(".main-input").empty();
    }
}
