<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php echo e($planet['title']); ?> | Inventory SMK 5 MADIUN</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo e(base_url()); ?>/assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?php echo e(base_url()); ?>/assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['<?php echo e(base_url()); ?>/assets/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?php echo e(base_url()); ?>/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo e(base_url()); ?>/assets/css/azzara.min.css">
	<link rel="stylesheet" href="<?php echo e(base_url()); ?>/assets/css/bootstrap-select.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="<?php echo e(base_url()); ?>/assets/css/demo.css">
	<style type="text/css">
		.tom:hover {
		 cursor:pointer;
		}
	   </style>
</head>
<body>
	<div class="wrapper">
		<!--
				Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
		-->
		<div class="main-header" data-background-color="purple">
			<!-- Logo Header -->
			<div class="logo-header">
				<a href="index.html" class="logo">
					<img src="<?php echo e(base_url()); ?>/assets/img/logo-kecil.png" alt="navbar brand" class="navbar-brand" height="70%">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg">

				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form>
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						<li class="nav-item dropdown hidden-caret">
							<a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-envelope"></i>
							</a>
							<ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
								<li>
									<div class="dropdown-title d-flex justify-content-between align-items-center">
										Messages
										<a href="#" class="small">Mark all as read</a>
									</div>
								</li>
								<li>
									<div class="message-notif-scroll scrollbar-outer">
										<div class="notif-center">
											<a href="#">
												<div class="notif-img">
													<img src="<?php echo e(base_url()); ?>/assets/img/jm_denis.jpg" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Jimmy Denis</span>
													<span class="block">
														How are you ?
													</span>
													<span class="time">5 minutes ago</span>
												</div>
											</a>
											<a href="#">
												<div class="notif-img">
													<img src="<?php echo e(base_url()); ?>/assets/img/chadengle.jpg" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Chad</span>
													<span class="block">
														Ok, Thanks !
													</span>
													<span class="time">12 minutes ago</span>
												</div>
											</a>
											<a href="#">
												<div class="notif-img">
													<img src="<?php echo e(base_url()); ?>/assets/img/mlane.jpg" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Jhon Doe</span>
													<span class="block">
														Ready for the meeting today...
													</span>
													<span class="time">12 minutes ago</span>
												</div>
											</a>
											<a href="#">
												<div class="notif-img">
													<img src="<?php echo e(base_url()); ?>/assets/img/talha.jpg" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Talha</span>
													<span class="block">
														Hi, Apa Kabar ?
													</span>
													<span class="time">17 minutes ago</span>
												</div>
											</a>
										</div>
									</div>
								</li>
								<li>
									<a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="<?php echo e(base_url()); ?>/assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<li>
									<div class="user-box">
										<div class="avatar-lg"><img src="<?php echo e(base_url()); ?>/assets/img/profile.jpg" alt="image profile" class="avatar-img rounded"></div>
										<div class="u-text">
											<h4><?php echo e($planet['user']['nama_Admin']); ?></h4>
											<p class="text-muted">hello@example.com</p><a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
										</div>
									</div>
								</li>
								<li>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">My Profile</a>
									<a class="dropdown-item" href="#">My Balance</a>
									<a class="dropdown-item" href="#">Inbox</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Account Setting</a>
									<div class="dropdown-divider"></div>
									<button type="submit" class="dropdown-item logout" href="">Logout</button>
								</li>
							</ul>
						</li>

					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar">

			<div class="sidebar-background"></div>
			<div class="sidebar-wrapper scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="<?php echo e(base_url()); ?>assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
                                <?php echo e($planet['user']['nama_Admin']); ?>

									<span class="user-level">
                                        Buyer
                                    </span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="#profile">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
									<li>
										<a href="#edit">
											<span class="link-collapse">Edit Profile</span>
										</a>
									</li>
									<li>
										<a href="#settings">
											<span class="link-collapse">Settings</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav">
						<?php if($planet['title'] !== "Dashboard"): ?> 
							<li class="nav-item">
						<?php else: ?> 
							<li class="nav-item active">
						<?php endif; ?>
							<a href="<?php echo e(base_url()); ?>buyer/buyer">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
								<span class="badge badge-count">5</span>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Menu Inventory</h4>
						</li>
						<?php if($planet['title'] !== "Masukkan"): ?> 
							<li class="nav-item">
						<?php else: ?> 
							<li class="nav-item active">
						<?php endif; ?>
							<a href="<?php echo e(base_url()); ?>buyer/Buyer/addInvt">
								<i class="fas fa-plus-circle"></i>
								<p>Masukkan Inventory</p>								
							</a>
						</li>
						<?php if(strpos($planet['title'], "Inventory") === FALSE): ?>
						<li class="nav-item">
							<a data-toggle="collapse" href="#inventory">
								<i class="fas fa-layer-group"></i>
								<p>Inventory</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="inventory">
						<?php else: ?> 
						<li class="nav-item active submenu">
							<a data-toggle="collapse" href="#inventory">
								<i class="fas fa-layer-group"></i>
								<p>Inventory</p>
								<span class="caret"></span>
							</a>
							<div class="collapse show" id="inventory">
						<?php endif; ?>
								<ul class="nav nav-collapse">
								<?php if($planet['title'] !== "Inventory Unconfirmed"): ?>
									<li>
								<?php else: ?>
									<li class="active">
								<?php endif; ?>
										<a href="<?= base_url()?>buyer/buyer/unconfirmed">
											<span class="sub-item">Perlu Konfirmasi</span>
										</a>
									</li>
								<?php if($planet['title'] !== "Inventory"): ?>
									<li>
								<?php else: ?>
									<li class="active">
								<?php endif; ?>
										<a href="<?= base_url()?>buyer/buyer/aset">
											<span class="sub-item">Inventory</span>
										</a>
									</li>
								<?php if($planet['title'] !== "Inventory Request"): ?>
									<li>
								<?php else: ?>
									<li class="active">
								<?php endif; ?>
										<a href="<?= base_url()?>buyer/buyer/request">
											<span class="sub-item">Request</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<?php if($planet['title'] !== "Input Inventory"): ?> 
							<li class="nav-item">
						<?php else: ?> 
							<li class="nav-item active">
						<?php endif; ?>
							<a href="<?php echo e(base_url()); ?>inputInventory">
								<i class="fas fa-pen-square"></i>
								<p>Laporan</p>								
							</a>
						</li>								
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar --><?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/template/headerBuyer.blade.php ENDPATH**/ ?>