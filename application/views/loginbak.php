<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Login</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?= base_url();?>assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?= base_url();?>assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['<?= base_url();?>assets/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url();?>assets/css/azzara.min.css">
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<h3 class="text-center">Sign In To Admin</h3>
                <form action="/login/auth" method="post">
                    <div class="login-form">
                        <div class="form-group form-floating-label">
                            <input id="username" name="username" type="text" class="form-control input-border-bottom" required>
                            <label for="username" class="placeholder">Username</label>
                        </div>
                        <div class="form-group form-floating-label">
                            <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                            <label for="password" class="placeholder">Password</label>
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
                            <!-- <a href="#" class="btn btn-primary btn-rounded btn-login">Sign In</a> -->
                            <button type="submit" class="btn btn-primary btn-rounded btn-login">Log in</button>
                        </div>
                </form>
				<div class="login-account">
					<span class="msg">Don't have an account yet ?</span>
					<a href="#" id="show-signup" class="link">Sign Up</a>
				</div>
			</div>
		</div>

		<div class="container container-signup animated fadeIn">
			<h3 class="text-center">Sign Up</h3>
            <form action="/login/signup" method="post">
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
                        <input  id="fullname" name="nama_Admin" type="text" class="form-control input-border-bottom" required>
                        <label for="fullname" class="placeholder">Fullname</label>
                    </div>
                    <!-- <div class="form-group form-floating-label">
                        <input  id="email" name="email" type="email" class="form-control input-border-bottom" required>
                        <label for="email" class="placeholder">Email</label>
                    </div> -->
                    <div class="form-group form-floating-label">
                        <input  id="passwordsignin" name="password" type="password" class="form-control input-border-bottom" required>
                        <label for="passwordsignin" class="placeholder">Password</label>
                        <div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                    </div>
                    <div class="form-group form-floating-label">
                        <input  id="confirmpassword" name="cpassword" type="password" class="form-control input-border-bottom" required>
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
    
<script src="<?= base_url();?>/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="<?= base_url();?>assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="<?= base_url();?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="<?= base_url();?>assets/js/core/popper.min.js"></script>
	<script src="<?= base_url();?>assets/js/core/bootstrap.min.js"></script>
	<script src="<?= base_url();?>assets/js/ready.js"></script>

   <?php 
        error_reporting(0);
        echo $danger;
   ?>
</body>
</html>