//Login Function using AJAX
function verifylogin(){
        //Get Form Field Values
        var loginform = $('#loginform');
        var submit = $('.btn-submit');
        var alertotp = $('.alert-submit');
        var username = $('#username').val();
        var password = $('#inputPassword').val();

        if (username != "") {
            if (password != "") {
                $("#loading_spinner").css({"display":"block"});
                $.ajax({
                    url: 'login.php',
                    type: 'POST',
                    // dataType : 'html',
                    data: {username:username,password:password,logincheck:"logincheck"},
                    beforeSend: function(){
                        alertotp.fadeOut();
                        submit.html('Submitting.......');
                    },
                    success:function(data){
                        if(data == "success"){
                            alertotp.html("<strong class='text-success'>Login Successful, please wait while we are redirecting you to admin dashboard.</strong>").fadeIn();
                            loginform.trigger('reset');
                            $("#loading_spinner").css({"display":"none"});
                            submit.attr("style", "display: none !important");
                            setTimeout(function(){
                              window.location.href = "dashboard.php";
                            }, 2000);
                        }
                        else{
                            submit.html('Submit');
                            loginform.trigger('reset');
                            $("#loading_spinner").css({"display":"none"});
                            alertotp.html("<strong class='text-danger'>Login failed,Please Enter Correct Username or Password</strong>").fadeIn();
                            $('#username').focus();  
                        }
                    }
                });
            }
            else{
                alert("Please Enter Password");
                $('#inputPassword').focus();
            }
        }
        else{
            alert("Please Enter Username");
            $('#username').focus();
        }
        return false;
}