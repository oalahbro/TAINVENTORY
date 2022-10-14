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
								<h4 class="card-title">Request Inventory</h4>
								<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modaladd">
									<i class="fa fa-plus"></i>
									Tambah Baru
								</button>
								<button class="btn btn-primary btn-round ml-2" data-toggle="modal" data-target="#modalback">
									<i class="fa fa-plus"></i>
									Aset Kembali
								</button>
							</div>
						</div>
						<div class="card-body">
							<!-- Modal -->
							<div class="modal fade" id="modalback" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header no-bd">
											<h5 class="modal-title">
												<span class="fw-mediumbold">
													Pilih</span>
												<span class="fw-light">
													Aset Kembali
												</span>
											</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form onsubmit="return backReq()" action="">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group" id="list">
															<label for="exampleFormControlSelect1">Pilih Aset Kembali</label><br>
															<select class="selectpicker form-control" onchange="getBack()" id="asetback" data-live-search="true" data-width="auto" title="Pilih aset kembali...">
																<?php $__currentLoopData = $planet['back']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $back): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<option value="<?php echo e($back['id_aset']); ?>" data-tokens="<?php echo e($back['id_aset']); ?>" data-subtext="<?php echo e($back['code']); ?>"><?php echo e($back['nama_aset']); ?></option>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															  </select> 
															  
														</div>
													<div class="form-group">
														<label for="exampleFormControlSelect1">Pilih Tujuan</label>
														<select name="tujuan" class="form-control" id="tujback">
															<?php $__currentLoopData = $planet['tuser']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($tus['id_admin']); ?>"><?php echo e($tus['nama_Admin']); ?></option>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</select>
													</div>
														<div class="form-group">
															<label for="comment">Keterangan</label>
															<textarea  name="deskripsi" class="form-control" id="descback" rows="5" required></textarea>
														</div>
												</div>
												</div>
												<div class="modal-footer no-bd">
													<button class="btn btn-success subm">Submit</button>
													<button class="btn btn-success btn-primary is-loading load" style="display: none" disabled>button</button>
													<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<table id="basic-datatables" class="display table table-striped table-hover">
									<thead>
										<tr>
											<th style="width: 30%">Nama Inventory</th>
											<th>Code</th>
											<th>Tujuan</th>
											<th style="width: 10%">Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Nama Inventory</th>
											<th>Code</th>
											<th>Tujuan</th>
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
		</div>
		
		<div class="modal fade bd-example-modal-lg" id="modaladd" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header no-bd">
						<h5 class="modal-title">
							<span class="fw-mediumbold">
								Add</span>
							<span class="fw-light">
								Inventory Request
							</span>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="fadd" method="POST" class="pt-0">
							<div class="row">
									<div class="card-body pt-0">
											<div class="form-group">
												<label for="exampleFormControlSelect1">Pilih Kategori</label>
												<select name="kategori" class="form-control"  id="kat">
													<?php $__currentLoopData = $planet['kategori']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($kat['id_kategori']); ?>"><?php echo e($kat['nama_kategori']); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</select>
											</div>
											<div class="form-group">
												<label for="exampleFormControlSelect1">Pilih Tujuan</label>
												<select name="tujuan" class="form-control" id="tuj">
													<?php $__currentLoopData = $planet['tuser']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($tus['id_admin']); ?>"><?php echo e($tus['nama_Admin']); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</select>
											</div>
											<div class="form-group">
												<label for="email2">Nama Inventory</label>
												<input  name="nama" type="text" class="form-control" id="nam" placeholder="Masukkan nama inventory">                                
											</div>
											<div class="form-group">
												<label for="email2">Code Inventory</label>
												<input name="code" type="text" class="form-control" id="cod" placeholder="Masukkan code invemtory">                                
											</div>
											<div class="form-group">
												<label for="exampleFormControlFile1">Masukkan Gambar Inventory</label>
												<input name="img" type="text" id="putbase" hidden>
												<input  type="file" class="form-control-file resize" id="img1">
												<br>
												<img id="bla" src="#" alt="your image" style="max-width: 20rem;" hidden/>
												
											</div>
											<div class="form-group">
												<label for="comment">Spesifikasi</label>
												<textarea name="spesifikasi" class="form-control" id="spek" rows="5" ></textarea>
											</div>
											<div class="form-group">
												<label for="comment">Keterangan</label>
												<textarea  name="deskripsi" class="form-control" id="des" rows="5"></textarea>
											</div>
										</div>
								</div>                
						</form>
					</div>
					<div class="modal-footer no-bd">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" onclick="addReq()">Submit</button>
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
							<div class="loader loader-lg" id="loading"></div>
						</div>
						<form id="fupdate" method="POST" style="display : none;" class="pt-0">
							<div class="row">
									<div class="card-body pt-0">
											<div class="form-group">
												<input type="text" id="id_aset" hidden/>
												<label for="exampleFormControlSelect1">Pilih Kategori</label>
												<select name="kategori" class="form-control" id="katup">
													<?php $__currentLoopData = $planet['kategori']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($kat['id_kategori']); ?>"><?php echo e($kat['nama_kategori']); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</select>
											</div>
											<div class="form-group">
												<label for="exampleFormControlSelect1">Pilih Tujuan</label>
												<select name="tujuan" class="form-control" id="tujup">
													<?php $__currentLoopData = $planet['tuser']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($tus['id_admin']); ?>"><?php echo e($tus['nama_Admin']); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</select>
											</div>
											<div class="form-group">
												<label for="email2">Nama Inventory</label>
												<input id="nama_aset" name="nama" type="text" class="form-control"  placeholder="Masukkan nama inventory">                                
											</div>
											<div class="form-group">
												<label for="email2">Code Inventory</label>
												<input id="code" name="code" type="text" class="form-control" placeholder="Masukkan code invemtory">                                
											</div>
											<div class="form-group">
												<label for="exampleFormControlFile1">Masukkan Gambar</label>
												<input type="text" id="putbas" hidden>
												<input id="imgInp" name="img" type="file" class="form-control-file resize" hidden ><br/>
												<input type="button" value="Browse..." onclick="document.getElementById('imgInp').click();" /><br>
												<img id="blah" src="#" alt="your image" style="max-width: 20rem;" />
												
											</div>
											<div class="form-group">
												<label for="comment">Spesifikasi</label>
												<textarea id="spesifikasi" name="spesifikasi" class="form-control"  rows="5">
												</textarea>
											</div>
											<div class="form-group">
												<label for="comment">Deskripsi</label>
												<textarea id="deskripsi" name="deskripsi" class="form-control" rows="5">
												</textarea>
											</div>
										</div>
								</div>                
						</form>
					</div>
					<div class="modal-footer no-bd">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" onclick="updateReq()">Edit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo $__env->make('template.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;<?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/buyer/request.blade.php ENDPATH**/ ?>