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
						<div class="card-header">
							<div class="d-flex align-items-center">
								<h4 class="card-title">Semua Inventory</h4>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="asetall" class="display table table-striped table-hover">
									<thead>
										<tr>
											<th>No</th>
											<th style="width: 30%">Nama Inventory</th>
											<th>Code</th>
											<th>Penanggung Jawab</th>
											<th>Status</th>
											<th style="width: 10%">Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No</th>
											<th>Nama Inventory</th>
											<th>Code</th>
											<th>Penanggung Jawab</th>
											<th>Status</th>
											<th>Action</th>
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

			<div class="modal fade bd-example-modal-lg" id="modaledit" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header no-bd">
							<h5 class="modal-title">
								<span class="fw-mediumbold">
									Detail</span>
								<span class="fw-light">
									Inventory
								</span>
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="d-flex justify-content-center">
								<div class="loader loader-lg" id="loading"></div>
							</div>
							<form id="fupdate" method="POST" style="display : none;" class="pt-0">
								<div class="row">
												<div class="col-md-6">
													<div class="form-group form-group-default">
														<label for="email2">Nama Inventory</label>
														<p id="nama_aset" class="mb-1"></p>                           
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-group-default">
														<label for="email2">Code Inventory</label>
														<p id="code" class="mb-1"></p>                        
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-group-default">
														<input type="text" id="id_aset" hidden/>
														<label for="exampleFormControlSelect1">Kategori</label>
														<p id="katup"class="mb-1"></p>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-group-default">
														<input type="text" id="id_asal" hidden/>
														<label for="exampleFormControlSelect1">Penanggung Jawab</label>
														<p id="tujup" class="mb-1"></p>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<img id="blah_det" src="#" alt="your image" style="max-width: 20rem;" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-group-default">
														<label for="comment">Spesifikasi</label>
														<textarea id="spesifikasi" name="spesifikasi" class="form-control"  rows="5">
														</textarea>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-group-default">
														<label for="comment">Keterangan</label>
														<textarea id="deskripsi" name="deskripsi" class="form-control" rows="5">
														</textarea>
													</div>
												</div>
										</div>    
							</form>
						</div>
						<div class="modal-footer no-bd">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade bd-example-modal-lg" id="modalhistory" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header no-bd">
							<h5 class="modal-title">
								<span class="fw-mediumbold">
									Detail</span>
								<span class="fw-light">
									Inventory
								</span>
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="d-flex justify-content-center">
								<div class="loader loader-lg" id="loadhis"></div>
							</div>
							<div class="col-md-12" style="display : none;" id="stephis">
								<div class="card">
									<div class="card-header">
										<div id="hisheader" class="card-title d-flex"></div>
									</div>
									<div class="card-body">
										<ol class="activity-feed" id="history">
										</ol>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer no-bd">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade bd-example-modal-lg" id="modalupdate" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header no-bd">
							<h5 class="modal-title">
								<span class="fw-mediumbold">
									Edit</span>
								<span class="fw-light">
									Inventory
								</span>
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="d-flex justify-content-center">
								<div class="loader loader-lg" id="loading_u"></div>
							</div>
							<form id="fupdate_u" method="POST" style="display : none;" class="pt-0">
								<div class="row">
										<div class="card-body pt-0">
												<div class="form-group">
													<input type="text" id="id_aset_u" hidden/>
													<label for="exampleFormControlSelect1">Pilih Kategori</label>
													<select name="kategori" class="form-control" id="katup_u">
														<?php $__currentLoopData = $planet['kategori']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<option value="<?php echo e($kat['id_kategori']); ?>"><?php echo e($kat['nama_kategori']); ?></option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
												</div>
												<div class="form-group">
													<label for="email2">Nama Inventory</label>
													<input id="nama_aset_u" name="nama" type="text" class="form-control"  placeholder="Masukkan nama inventory">                                
												</div>
												<div class="form-group">
													<label for="email2">Code Inventory</label>
													<input id="code_u" name="code" type="text" class="form-control" disabled placeholder="Masukkan code inventory">                                
												</div>
												<div class="form-group">
													<label for="exampleFormControlFile1">Masukkan Gambar</label>
													<input type="text" id="putbas" hidden>
													<input id="imgInp" name="img" type="file" class="form-control-file resize" hidden ><br/>
													<input id="img1" hidden ><br/>
													<input type="button" value="Browse..." onclick="document.getElementById('imgInp').click();" /><br>
													<img id="blah" src="#" alt="your image" style="max-width: 20rem;" />
													
												</div>
												<div class="form-group">
													<label for="comment">Spesifikasi</label>
													<textarea id="spesifikasi_u" name="spesifikasi" class="form-control"  rows="5">
													</textarea>
												</div>
												<div class="form-group">
													<label for="comment">Keterangan</label>
													<textarea id="deskripsi_u" name="deskripsi" class="form-control" rows="5">
													</textarea>
												</div>
											</div>
									</div>                
							</form>
						</div>
						<div class="modal-footer no-bd">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" onclick="updateInv()">Edit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $__env->make('template.footerBuyer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;<?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/buyer/inventory.blade.php ENDPATH**/ ?>