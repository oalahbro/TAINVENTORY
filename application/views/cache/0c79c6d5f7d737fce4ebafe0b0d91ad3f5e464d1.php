<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?php echo e(base_url()); ?>assets/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?php echo e(base_url()); ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['<?php echo e(base_url()); ?>assets/css/fonts.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo e(base_url()); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(base_url()); ?>assets/css/azzara.min.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn" id="login">
            <h3 class="text-center">Sign In To Admin</h3>
            <form onsubmit="return login()">
                <div class="login-form">
                    <div class="form-group form-floating-label">
                        <input id="username" name="username" type="text" class="form-control input-border-bottom" required>
                        <label for="username" id="username" class="placeholder">Username</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                        <label for="password" id="password" class="placeholder">Password</label>
                        <div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                    </div>
                    <div class="row form-sub m-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label" for="rememberme">Remember Me</label>
                        </div>
                        <a href="#" id="show-signup" class="link float-right">Forget Password ?</a>
                    </div>
                    <div class="form-action mb-3">
                        <button id="enter" type="submit" class="btn btn-primary btn-rounded btn-login subm">Log in</button>
                        <button disabled class="btn btn-primary btn-rounded btn-login is-loading load" style="display: none">button</button>
                    </div>
                </div>
            </form>
        </div>
    <div class="container container-signup animated fadeIn">
        <h3 class="text-center">Forgot Password</h3>
        <form onsubmit="return forgot();" action="">
            <div class="login-form">
                <div class="form-group form-floating-label">
                    <label>Masukkan Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input id="usrforgot" type="text" class="form-control" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                </div>
                <div class="form-action">
                    <a href="#" id="show-signin" class="btn btn-danger btn-rounded btn-login mr-3">Cancel</a>
                    <!-- <a href="#" class="btn btn-primary btn-rounded btn-login">Sign Up</a> -->
                    <button type="submit" class="btn btn-primary btn-rounded btn-login">submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card animated fadeIn text-center" id="otp-container" style="display: none; width: 25rem;" >
        <div class="card-body">
            <h3 class="text-center"><b>Forgot Password</b></h3>
            <form onsubmit="return otpe();" action="">
                <div class="login-form">
                    <div class="form-group form-floating-label">
                        <label>Masukkan OTP</label>
                        <div class="form-group">
                            <input type="number" id="otp" class="form-control"  aria-describedby="emailHelp" placeholder="Masukkan 6 digit otp">
                            
                        </div>
                    </div>
                    <div class="form-action mt-2">
                        <a href="#"  class="btn btn-danger btn-rounded btn-login mr-3" onclick="hideall()">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-rounded btn-login">submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card animated fadeIn text-center" id="reset-pw" style="display: none; width: 25rem;" >
        <div class="card-body">
            <h3 class="text-center"><b>Reset Password</b></h3>
            <form id="myform" onsubmit="return resetpw()" action="">
                <div class="login-form">
                        <div class="form-group form-group-default mb-2">
                            <label>Masukkan password baru</label>
                            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="password baru" value="">
                        </div>
                        <label id="pwd-error" class="error mt-0 ml-2" for="pwd"></label>
                    
                    
                        <div class="form-group form-group-default mb-2">
                            <label>Masukkan kembali password baru</label>
                            <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="masukkan kembali password baru" value="" required>
                        </div>
                        <label id="pwd2-error" class="error mt-0 ml-2" for="pwd2"></label>
                    
                </div>
                <div class="form-action mt-2">
                    <a href="#" class="btn btn-danger btn-rounded btn-login mr-3" onclick="hideall()">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-rounded btn-login">submit</button>
                </div>
            </form>
            
        </div>
    </div>
    </div>

    <script src="<?php echo e(base_url()); ?>/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo e(base_url()); ?>assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo e(base_url()); ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="<?php echo e(base_url()); ?>assets/js/core/popper.min.js"></script>
    <script src="<?php echo e(base_url()); ?>assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo e(base_url()); ?>assets/js/ready.js"></script>
    <script src="<?php echo e(base_url()); ?>/assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>

    <script>
    $.validator.addMethod("pwcheck", function(value) {
   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
       && /[a-z]/.test(value) // has a lowercase letter
       && /\d/.test(value)  // has a digit
}, 'Password harus berupa angke, huruf besar dan kecil.');
  $( "#myform" ).validate({
    rules: {
      pwd: {
      required: true,
      minlength: 6,
      pwcheck: true
				},
      pwd2: {
      required: true,
      equalTo: '#pwd'
				},
    },
    highlight: function(element) {
      
			},
    success: function(element) {
    
    $( ".error" ).text('');
    },
  });
        function login(){
      const api_url = "<?= base_url() ?>login/apiAuth"
      const data = {
        username : document.getElementById('username').value,
        password : document.getElementById('password').value
      }
      $('.subm').hide()
      $('.load').show()
      $.post(api_url,data, function(data, status){
        show(JSON.parse(data))
        
      })
      function show(data){
          let respon = data.respon
          if(respon == 'benar'){
            window.location.href = "<?= base_url() ?>" + data.link
          }else if(respon == 'salah'){
            swal({
			title: "Username / Password Salah !",
			text: "Silahkan cek username / password anda kembali",
			icon: "warning",
			buttons: "OK",
			dangerMode: true,
			})
          }else{
            swal({
			title: "User belum aktif",
			text: "Silahkan hubungi administrator",
			icon: "warning",
			buttons: "OK",
			dangerMode: true,
			})
          }
        $('.subm').show()
        $('.load').hide()
      }
      return false
    }
    function forgot(){
        const api_url = "<?= base_url() ?>login/forgot"
      const data = {
        username : document.getElementById('usrforgot').value,
      }
      
      $.post(api_url,data, function(data, status){
        k = JSON.parse(data)
        if(k == null){
            swal({
			title: "User Tidak terdafter",
			icon: "warning",
			buttons: "OK",
			dangerMode: true,
			})
        }else{
            $('.container-signup').css("display", "none");
            $('#otp-container').css("display", "block");
        }
        
      })
        return false
    }
    function otpe(){
        const api_url = "<?= base_url() ?>login/otp"
      const data = {
        otp : document.getElementById('otp').value,
      }
      
      $.post(api_url,data, function(data, status){
        if(data == "error"){
            swal({
			title: "OTP salah silahkan cek kembali",
			icon: "warning",
			buttons: "OK",
			dangerMode: true,
			})
        }else{
            $('#otp-container').css("display", "none");
            $('#reset-pw').css("display", "block");
            console.log("benar");
        }
        
      })
        return false
    }
    function resetpw(){
        const api_url = "<?= base_url() ?>login/resetpw"
      const data = {
        password : document.getElementById('pwd').value,
        username : document.getElementById('usrforgot').value,
      }
      
      $.post(api_url,data, function(data, status){
        
            swal({
			title: "Reset password berhasil",
            text: "silahkan login dengan password baru anda",
			icon: "success",
			buttons: "OK",
			})
            .then((willDelete) => {
          if (willDelete) {
            $('#reset-pw').css("display", "none");
            $('#login').css("display", "block");
            console.log("benar");
          } else {

          }
        });
      })
        
        return false
    }
    function hideall(){
        $('#otp-container').css("display", "none");
        $('#reset-pw').css("display", "none");
        $('#login').css("display", "block");
    }
    </script>
    
</body>

</html><?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/login.blade.php ENDPATH**/ ?>