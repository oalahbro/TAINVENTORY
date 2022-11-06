@include('template.headerAdmin');
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
									Aset Teruskan
								</button>
							</div>
						</div>
						<div class="card-body">
							<!-- Modal teruskan -->
							<div class="modal fade" id="modalback" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header no-bd">
											<h5 class="modal-title">
												<span class="fw-mediumbold">
													Pilih</span>
												<span class="fw-light">
													Aset Teruskan
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
															<label for="exampleFormControlSelect1">Pilih Aset yang ingin diteruskan</label><br>
															<select class="selectpicker form-control" onchange="getBack()" id="asetback" data-live-search="true" data-width="auto" title="Pilih aset yang ingin diteruskan...">
																@foreach($planet['back'] as $back)
																<option value="{{ $back['id_aset'] }}" data-tokens="{{ $back['id_aset'] }}" data-subtext="{{ $back['code'] }}">{{ $back['nama_aset'] }}</option>
																@endforeach
															  </select> 
															  
														</div>
													<div class="form-group">
														<label for="exampleFormControlSelect1">Pilih Tujuan</label>
														<select name="tujuan" class="form-control" id="tujback">
															@foreach($planet['tuser'] as $tus)
															@if ($tus['level'] == 2)
																@php $tus['level'] = '( Guru )' @endphp
															@else
																@php $tus['level'] = '( Buyer )' @endphp
															@endif
															<option value="{{ $tus['id_admin'] }}">{{ $tus['nama_Admin'] }} {{ $tus['level'] }}</option>
															@endforeach
														</select>
													</div>
														<div class="form-group">
															<label for="comment">Keterangan</label>
															<textarea  name="deskripsi" class="form-control" id="descback" rows="5" required></textarea>
														</div>
												</div>
												</div>
												<div class="modal-footer no-bd">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
													<button class="btn btn-success btn-primary is-loading load" style="display: none" disabled>button</button>
													<button class="btn btn-success subm">Submit</button>
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
											<th style="width: 5%">No</th>
											<th style="width: 25%">Nama Inventory</th>
											<th>Code</th>
											<th>Tujuan</th>
											<th style="width: 15%">Status Request</th>
											<th style="width: 10%">Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No</th>
											<th>Nama Inventory</th>
											<th>Code</th>
											<th>Tujuan</th>
											<th>Request</th>
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
		{{-- MODAL ADD --}}
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
													@foreach($planet['kategori'] as $kat)
													<option value="{{ $kat['id_kategori'] }}">{{ $kat['nama_kategori'] }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label for="exampleFormControlSelect1">Pilih Tujuan</label>
												<select name="tujuan" class="form-control" id="tuj">
													@foreach($planet['tuser'] as $tus)
													<option value="{{ $tus['id_admin'] }}">{{ $tus['nama_Admin'] }} {{ $tus['level'] }}</option>
													@endforeach
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
		{{-- modal edit --}}
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
													@foreach($planet['kategori'] as $kat)
													<option value="{{ $kat['id_kategori'] }}">{{ $kat['nama_kategori'] }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label for="exampleFormControlSelect1">Pilih Tujuan</label>
												<select name="tujuan" class="form-control" id="tujup">
													@foreach($planet['tuser'] as $tus)
													<option value="{{ $tus['id_admin'] }}">{{ $tus['nama_Admin'] }} {{ $tus['level'] }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label for="email2">Nama Inventory</label>
												<input id="nama_aset" name="nama" type="text" class="form-control"  placeholder="Masukkan nama inventory">                                
											</div>
											<div class="form-group">
												<label for="email2">Code Inventory</label>
												<input id="code" name="code" type="text" class="form-control" disabled placeholder="Masukkan code inventory">                                
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
						<button type="submit" class="btn btn-primary" onclick="updateReq()">Edit</button>
					</div>
				</div>
			</div>
		</div>
		{{-- modal history --}}
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
	</div>
</div>

@include('template.footerAdmin');