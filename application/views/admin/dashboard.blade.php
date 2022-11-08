@include('template.headerAdmin');
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="page-header">
				<h4 class="page-title">Resume</h4>
			</div>
			<div class="row">
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-primary card-round">
						<div class="card-body">
							<div class="row">
								<div class="col-5">
									<div class="icon-big text-center">
										<i class="flaticon-users"></i>
									</div>
								</div>
								<div class="col col-stats">
									<div class="numbers">
										<p class="card-category">User</p>
										<h4 class="card-title">{{ $planet['jumlah'] }}</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-info card-round">
						<div class="card-body">
							<div class="row">
								<div class="col-5">
									<div class="icon-big text-center">
										<i class="flaticon-shapes-1"></i>
									</div>
								</div>
								<div class="col col-stats">
									<div class="numbers">
										<p class="card-category">Inventory</p>
										<h4 class="card-title">{{  $planet['jumlah_aset'] }}</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-success card-round">
						<div class="card-body ">
							<div class="row">
								<div class="col-5">
									<div class="icon-big text-center">
										<i class="flaticon-analytics"></i>
									</div>
								</div>
								<div class="col col-stats">
									<div class="numbers">
										<p class="card-category">Unconfirmed</p>
										<h4 class="card-title">{{ $planet['jumlah_unconfirmed'] }}</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-secondary card-round">
						<div class="card-body ">
							<div class="row">
								<div class="col-5">
									<div class="icon-big text-center">
										<i class="flaticon-success"></i>
									</div>
								</div>
								<div class="col col-stats">
									<div class="numbers">
										<p class="card-category">Order</p>
										<h4 class="card-title">576</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

</div>

@include('template.footerAdmin');