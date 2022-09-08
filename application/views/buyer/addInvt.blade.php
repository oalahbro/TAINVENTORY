@include('template.headerBuyer');

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Forms</h4>
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
                        <a href="#">Forms</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Basic Form</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Masukkan Data Inventory</div>
                        </div>
                        {{-- <form action="{{ base_url() }}buyer/Buyer/addInvt" method="POST"> --}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Pilih Kategori</label>
                                <select name="kategori" class="form-control" id="kat">
                                    @foreach($planet['kategori'] as $kat)
                                    <option value="{{ $kat['id_kategori'] }}">{{ $kat['nama_kategori'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Pilih Tujuan</label>
                                <select name="tujuan" class="form-control" id="tuj">
                                    @foreach($planet['tuser'] as $tus)
                                    <option value="{{ $tus['id_admin'] }}">{{ $tus['nama_Admin'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email2">Nama Inventory</label>
                                <input name="nama" type="text" class="form-control" id="nam" placeholder="Masukkan nama inventory">                                
                            </div>
                            <div class="form-group">
                                <label for="email2">Code Inventory</label>
                                <input name="code" type="text" class="form-control" id="cod" placeholder="Masukkan code invemtory">                                
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Masukkan Gambar Inventory</label>
                                <input name="img" type="text" id="putbase" hidden>
                                <input  type="file" class="form-control-file resize" id="img1">
                                <img id="bla" src="#" alt="your image" style="max-width: 20rem;" hidden/>
                                
                            </div>
                            <div class="form-group">
                                <label for="comment">Spesifikasi</label>
                                <textarea name="spesifikasi" type="text" class="form-control" id="spek" rows="5">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="comment">Deskripsi</label>
                                <textarea name="deskripsi" type="text" class="form-control" id="des" rows="5">
                                </textarea>
                            </div>
                        </div>
                        <div class="card-action">
                            <button class="btn btn-success subm" onclick="pass()">Submit</button>
                            <button class="btn btn-success btn-primary is-loading load" style="display: none">button</button>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Data Sementara</div>
                        </div>
                        <div id="tmp" class="card-body">
                            {{-- @foreach ($planet['invt_tmp'] as $invtmp)
                            <div class="row alert alert-info px-2 mx-0" role="alert">
                                <div class="col-10 px-0 tom edit-tmp" data-id-aset="{{ $invtmp['id_aset_tmp'] }}">
                                    {{ $invtmp['nama_aset'] }}<b>, Code :</b>&nbsp;{{ $invtmp['code'] }}
                                </div>
                                <div class="col-2 pl-0">
                                <button type="button" class="close text-danger" aria-label="Close">
                                    <span >&times;</span>
                                </button>
                                </div>
                            </div>
                            @endforeach --}}
                        </div>
                        <div class="card-action">
                            <button class="btn btn-success btn-block">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL --}}
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
                                            <input type="text" id="id_aset_tmp" hidden/>
                                            <label for="exampleFormControlSelect1">Pilih Kategori</label>
                                            <select name="kategori" class="form-control" id="exampleFormControlSelect1">
                                                <option id="kategori" selected></option>
                                                @foreach($planet['kategori'] as $kat)
                                                <option value="{{ $kat['id_kategori'] }}">{{ $kat['nama_kategori'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Pilih Tujuan</label>
                                            <select name="tujuan" class="form-control" id="exampleFormControlSelect1">
                                                <option id="tujuan" selected></option>
                                                @foreach($planet['tuser'] as $tus)
                                                <option value="{{ $tus['id_admin'] }}">{{ $tus['nama_Admin'] }}</option>
                                                @endforeach
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
                                            <input id="imgInp" name="img" type="file" class="form-control-file resize" ><br/>
                                            <img id="blah" src="#" alt="your image" style="max-width: 20rem;" />
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Spesifikasi</label>
                                            <textarea id="spesifikasi" name="spesifikasi" type="text" class="form-control"  rows="5">
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Deskripsi</label>
                                            <textarea id="deskripsi" name="deskripsi" type="text" class="form-control" rows="5">
                                            </textarea>
                                        </div>
                                    </div>
                            </div>                
                    </form>
                </div>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="passUp()">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('template.footer');