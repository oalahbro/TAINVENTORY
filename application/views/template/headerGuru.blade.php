<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{ $planet['title'] }} | Inventory SMK 5 MADIUN</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ base_url() }}/assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ base_url() }}/assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['{{ base_url() }}/assets/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ base_url() }}/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ base_url() }}/assets/css/azzara.css">
	<link rel="stylesheet" href="{{ base_url() }}/assets/css/bootstrap-select.css">
	<link rel="stylesheet" href="{{ base_url() }}/assets/css/photoviewer.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ base_url() }}/assets/css/demo.css">
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
		<div class="main-header" data-background-color="orange">
			<!-- Logo Header -->
			<div class="logo-header">
				<a href="index.html" class="logo">
					<img src="{{ base_url() }}/assets/img/logo-kecil.png" alt="navbar brand" class="navbar-brand" height="70%">
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
						<form class="navbar-left navbar-form nav-search mr-md-3" action="{{ base_url() }}guru/guru/search" method="POST">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control" id="search" name="search">
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
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{  $planet['user']['img'] }}" alt="..." class="avatar-img rounded-circle" id="header-img1">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<li>
									<div class="user-box">
										<div class="avatar-lg"><img src="{{  $planet['user']['img'] }}" alt="image profile" class="avatar-img rounded" id="header-img2"></div>
										<div class="u-text">
											<h4 id="name-h4">{{  $planet['user']['nama_Admin'] }}</h4>
											<p class="text-muted" id="email-h4">{{  $planet['user']['email'] }}</p>
										</div>
									</div>
								</li>
								<li>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="{{ base_url() }}guru/guru/profile">My Profile</a>
									<div class="dropdown-divider"></div>
									<button  style="cursor: pointer;" type="submit" class="dropdown-item logout" href="">Logout</button>
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
							<img src="{{  $planet['user']['img'] }}" alt="..." class="avatar-img rounded-circle" id="header-img">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									<p id="side-name" class="mb-0">{{  $planet['user']['nama_Admin'] }}</p>
									<span class="user-level">
                                        Guru
                                    </span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="{{ base_url() }}guru/guru/profile">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav">
						@if ($planet['title'] !== "Dashboard") 
							<li class="nav-item">
						@else 
							<li class="nav-item active">
						@endif
							<a href="{{ base_url() }}guru/guru">
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
						
						@if (strpos($planet['title'], "Inventory") === FALSE)
						<li class="nav-item">
							<a data-toggle="collapse" href="#inventory">
								<i class="fas fa-layer-group"></i>
								<p>Inventory</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="inventory">
						@else 
						<li class="nav-item active submenu">
							<a data-toggle="collapse" href="#inventory">
								<i class="fas fa-layer-group"></i>
								<p>Inventory</p>
								<span class="caret"></span>
							</a>
							<div class="collapse show" id="inventory">
						@endif
								<ul class="nav nav-collapse">
								@if ($planet['title'] !== "Inventory Unconfirmed")
									<li>
								@else
									<li class="active">
								@endif
										<a href="<?= base_url()?>guru/guru/unconfirmed">
											<span class="sub-item">Perlu Konfirmasi</span>
										</a>
									</li>
								@if ($planet['title'] !== "Semua Inventory")
									<li>
								@else
									<li class="active">
								@endif
										<a href="<?= base_url()?>guru/guru/aset">
											<span class="sub-item">Inventory</span>
										</a>
									</li>
								@if ($planet['title'] !== "Inventory Request")
									<li>
								@else
									<li class="active">
								@endif
										<a href="<?= base_url()?>guru/guru/request">
											<span class="sub-item">Request</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						@if ($planet['title'] !== "Laporan") 
							<li class="nav-item">
						@else 
							<li class="nav-item active">
						@endif
							<a href="{{ base_url() }}guru/guru/report">
								<i class="fas fa-pen-square"></i>
								<p>Laporan</p>								
							</a>
						</li>									
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->