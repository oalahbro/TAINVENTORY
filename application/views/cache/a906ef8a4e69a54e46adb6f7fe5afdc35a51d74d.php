<?php echo $__env->make('template.headerBuyer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="page-header">
				<h4 class="page-title">Data Inventaris</h4>
				<ul class="breadcrumbs">
					<li class="nav-home">
						<a href="#">
							<i class="flaticon-home"></i>
						</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="#">Tables</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="#">Datatables</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div id="img1"></div>
						<div id="imgInp"></div>
						<div class="card-header">
							<div class="d-flex align-items-center">
								<h4 class="card-title">Laporan Inventory</h4>
								<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalfilter">
									<i class="fas fa-filter"></i>
									Filter
								</button>
								<button class="btn btn-primary btn-round ml-2" onclick="exportPdf()">
									<i class="fas fa-file-export"></i>
									 Export 
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="basic-datatables" class="display table table-striped table-hover responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Inventory</th>
											<th>Code</th>
											<th>Tanggal</th>
											<th>Penanggung Jawab</th>
											<th>Tujuan</th>
											<th>Status</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No</th>
											<th>Nama Inventory</th>
											<th>Code</th>
											<th>Tanggal</th>
											<th>Penanggung Jawab</th>
											<th>Tujuan</th>
											<th>Status</th>
										</tr>
									</tfoot>
									<tbody id="request">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modalfilter" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header no-bd">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold">
                                    Filter</span>
                                <span class="fw-light">
                                    Inventory
                                </span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="small">Masukkan Password lama dan baru</p>
                            <form onsubmit="return filter();" method="POST" action="">
								<div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Dari Tanggal</label>
                                            <input type="text" class="form-control" id="datepicker" >
                                        </div>
                                    </div>
									<div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Sampai Tanggal</label>
                                            <input type="text" class="form-control" id="datepicker1" >
                                        </div>
                                    </div>
									<div class="col-sm-12">
										<div class="form-group form-group-default">
											<label for="exampleFormControlSelect1">Tujuan</label>
											<select name="tujuan" class="form-control" id="tujuan">
												<option value=""></option>
												<?php $__currentLoopData = $planet['tuser']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php if($tus['level'] == 2): ?>
													<?php $tus['level'] = '( Guru )' ?>
												<?php elseif($tus['level'] == 1): ?>
													<?php $tus['level'] = '( Superadmin )' ?>
												<?php else: ?>
												<?php $tus['level'] = '( Buyer )' ?>
												<?php endif; ?>
												<option value="<?php echo e($tus['id_admin']); ?>"><?php echo e($tus['nama_Admin']); ?> <?php echo e($tus['level']); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group form-group-default">
											<label for="exampleFormControlSelect1">Status</label>
											<select name="tujuan" class="form-control" id="status">
												<option value=""></option>
												<option value="R1" >Request Masuk</option>
												<option value="R0" >Request Keluar</option>
												<option value="Y" >Request Diterima</option>
												<option value="N" >Request Ditolak</option>
											</select>
										</div>
									</div>
                                </div>
                                <div class="modal-footer no-bd">
                                    <button class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<?php echo $__env->make('template.footerBuyer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;<?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/buyer/report.blade.php ENDPATH**/ ?>