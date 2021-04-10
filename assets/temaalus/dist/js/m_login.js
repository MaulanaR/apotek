document.getElementById('submitform').onclick =masukbr;

$('[name="password"]').keypress(function(e) {
    if(e.which == 13) {
        masukbr();
    }
});

function masukbr()
   {
      var base_url = '<?php echo base_url();?>';
      var form=$("#form");
      var identity = $("input[name='identity']").val();
      var pass = $("input[name='password']").val();
      var captcha_data = $("input[name='captcha_data']").val();
      var gambarcap = $("input[name='gambarcap']").val();
      var csrf = $.cookie("askrindo_cookieapp");
/*      var capt = $("input[name='identity']").val();
      var respons = $("#g-recaptcha-response").val();*/

      $.ajax({
            type:"POST",
            url:form.attr("action"),
            data:{'identity' : identity,'password' : pass,'captcha_data':captcha_data,'gambarcap':gambarcap, 'csrf_askrindo_financeapp':csrf},
            dataType: "json",
            beforeSend: function() 
            { $("#load_ajax").fadeIn(20); },
            complete: function() 
            { $("#load_ajax").fadeOut("slow"); },
            error: function (jqXHR, textStatus, errorThrown)
            { 
              $("#load_ajax").fadeOut("slow");
              alert(errorThrown);
            },
            success: function(data){
              $("#load_ajax").fadeOut("slow");
              if(data.status)
              {
                window.location = data.redirect;
                popup(data.msg);
              }else{
                //go_captcha();
                popup(data.msg);
              }
            }
        
        });
   }

function popup(ms = null,act= null) {
    if(ms == null)
    {
      $().toasty({
          message: "Berhasil",
          autoHide: 3000
      }); 
      
    }else{
      $().toasty({
          message: ms,
          autoHide: 3000,
          afterHide : function() {
            //Logic to run after the toast is removed from the DOM
            if(act != null)
              {
                act;
              }
          }
      }); 
    }  
  }