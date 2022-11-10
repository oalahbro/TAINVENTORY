<?php echo $__env->make('template.headerAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;

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
                        <form onsubmit="return pass()" action="">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Pilih Kategori</label>
                                <select name="kategori" class="form-control" id="kat">
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
                                <input name="nama" type="text" class="form-control" id="nam" placeholder="Masukkan nama inventory">                                
                            </div>
                            <div class="form-group">
                                <label for="email2">Code Inventory</label>
                                <input name="code" type="text" class="form-control" id="cod" placeholder="Masukkan code invemtory" required>                                
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
                                <textarea name="deskripsi" class="form-control" id="des" rows="5">ASET BARU</textarea>
                            </div>
                        </div>
                        <div class="card-action">
                            <button class="btn btn-success subm">Submit</button>
                            <button class="btn btn-success btn-primary is-loading load" style="display: none" disabled>button</button>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Data Sementara</div>
                        </div>
                        <div id="tmp" class="card-body">
                        </div>
                        <div class="card-action">
                            <button id="btn-insert" class="allin btn btn-success btn-block" onclick="insert()">Submit</button>
                            <button class="allload btn btn-success btn-block is-loading" style="display: none" disabled>button</button>
                        </div>
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
                                            <select name="kategori" class="form-control" id="kategori">
                                                <?php $__currentLoopData = $planet['kategori']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($kat['id_kategori']); ?>"><?php echo e($kat['nama_kategori']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Pilih Tujuan</label>
                                            <select name="tujuan" class="form-control" id="tujuan">
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
                                            <input id="code" name="code" type="text" class="form-control" placeholder="Masukkan code inventory">                                
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1">Masukkan Gambar</label>
                                            <input type="text" id="putbas" hidden>
                                            <input id="imgInp" name="img" type="file" class="form-control-file resize" ><br/>
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
                    <button type="submit" class="btn btn-primary" onclick="passUp()">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('template.footerAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;<?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/admin/addInvt.blade.php ENDPATH**/ ?>