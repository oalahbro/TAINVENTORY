<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ base_url() }}assets/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ base_url() }}assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['{{ base_url() }}assets/css/fonts.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ base_url() }}assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ base_url() }}assets/css/azzara.min.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h3 class="text-center">Sign In To Admin</h3>
            {{-- <form action="<?= base_url() ?>login/auth" method="post"> --}}
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

                        <a href="#" class="link float-right">Forget Password ?</a>
                    </div>
                    <div class="form-action mb-3">
                        <button onclick="login()" type="submit" class="btn btn-primary btn-rounded btn-login subm">Log in</button>
                        <button disabled class="btn btn-primary btn-rounded btn-login is-loading load" style="display: none">button</button>
                    </div>
            {{-- </form> --}}
            <div class="login-account">
                <span class="msg">Don't have an account yet ?</span>
                <a href="#" id="show-signup" class="link">Sign Up</a>
            </div>
        </div>
    </div>

    <div class="container container-signup animated fadeIn">
        <h3 class="text-center">Sign Up</h3>
        <form action="<?=base_url()?>/login/signup" method="post">
            <div class="login-form">
                <div class="form-group form-floating-label">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                </div>
                <div class="form-group form-floating-label">
                    <input id="fullname" name="nama_Admin" type="text" class="form-control input-border-bottom" required>
                    <label for="fullname" class="placeholder">Fullname</label>
                </div>
                <!-- <div class="form-group form-floating-label">
                        <input  id="email" name="email" type="email" class="form-control input-border-bottom" required>
                        <label for="email" class="placeholder">Email</label>
                    </div> -->
                <div class="form-group form-floating-label">
                    <input id="passwordsignin" name="password" type="password" class="form-control input-border-bottom" required>
                    <label for="passwordsignin" class="placeholder">Password</label>
                    <div class="show-password">
                        <i class="flaticon-interface"></i>
                    </div>
                </div>
                <div class="form-group form-floating-label">
                    <input id="confirmpassword" name="cpassword" type="password" class="form-control input-border-bottom" required>
                    <label for="confirmpassword" class="placeholder">Confirm Password</label>
                    <div class="show-password">
                        <i class="flaticon-interface"></i>
                    </div>
                </div>
                <div class="form-group form-floating-label">
                    <label for="pillSelect">Pilih role</label>
                    <select class="form-control input-pill" name="level" id="pillSelect">
                        <option></option>
                        <option value="1">Admin</option>
                        <option value="2">Guru</option>
                        <option value="3">Buyer</option>
                    </select>
                </div>
                <div class="row form-sub m-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="agree" id="agree">
                        <label class="custom-control-label" for="agree">I Agree the terms and conditions</label>
                    </div>
                </div>
                <div class="form-action">
                    <a href="#" id="show-signin" class="btn btn-danger btn-rounded btn-login mr-3">Cancel</a>
                    <!-- <a href="#" class="btn btn-primary btn-rounded btn-login">Sign Up</a> -->
                    <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign Up</button>
                </div>
            </div>
        </form>
    </div>
    </div>

    <script src="{{ base_url() }}/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="{{ base_url() }}assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ base_url() }}assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ base_url() }}assets/js/core/popper.min.js"></script>
    <script src="{{ base_url() }}assets/js/core/bootstrap.min.js"></script>
    <script src="{{ base_url() }}assets/js/ready.js"></script>

    <script>
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
    }
    </script>
    
</body>

</html>