<?php echo $__env->make('template.headerAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data User</h4>
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
                                <h4 class="card-title">Tambah User</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#adduser">
                                    <i class="fa fa-plus"></i>
                                    Tambah User
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Modal add-->
                            <div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h5 class="modal-title">
                                                <span class="fw-mediumbold">
                                                    Tambah</span>
                                                <span class="fw-light">
                                                    User
                                                </span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="small">Masukkan detail user untuk mandambah user</p>
                                            <form onsubmit="return addUser();" method="POST" action="">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Nama User</label>
                                                            <input id="addName" type="text" class="form-control" placeholder="fill Nama User" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Level</label>
                                                            <select name="tujuan" class="form-control" id="leveladd">
                                                                <option value="1">Superadmin</option>
                                                                <option value="2">Guru</option>
                                                                <option value="3">Buyer</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pr-0">
                                                        <div class="form-group form-group-default">
                                                            <label>Username</label>
                                                            <input id="usernameadd" type="text" class="form-control" placeholder="fill Username" required>
                                                        </div>
                                                        <p class="text-danger ml-2" id="errorusr"></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Password</label>
                                                            <input id="passwordadd" type="password" class="form-control" placeholder="fill Password" required>
                                                        </div>
                                                        <p class="text-danger ml-2" id="errorpwd"></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer no-bd">
                                                    <button class="btn btn-primary">Add</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="user" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th>Nama User</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>status</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Level</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Modal Edit-->
             <div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header no-bd">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold">
                                    Tambah</span>
                                <span class="fw-light">
                                    User
                                </span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="small">Masukkan detail user untuk mandambah user</p>
                            <div class="d-flex justify-content-center">
                                <div class="loader loader-lg" id="loading"></div>
                            </div>
                            <form onsubmit="return userUp();" method="POST" action="" style="display : none;" id="fupdate">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <input type="text" id="id_user" hidden/>
                                            <label>Nama User</label>
                                            <input id="name" type="text" class="form-control" placeholder="fill Nama User" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="form-group form-group-default">
                                            <label>Level</label>
                                            <select name="tujuan" class="form-control" id="level">
                                                <option value="1">Superadmin</option>
                                                <option value="2">Guru</option>
                                                <option value="3">Buyer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="form-group form-group-default">
                                            <label>Status</label>
                                            <select name="tujuan" class="form-control" id="status">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="form-group form-group-default">
                                            <label>Username</label>
                                            <input id="username" type="text" class="form-control" placeholder="fill Username" required>
                                        </div>
                                        <p class="text-danger ml-2" id="errorusrup"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Password</label>
                                            <input id="password" type="password" class="form-control" placeholder="fill Password">
                                        </div>
                                        <p class="text-danger ml-2" id="errorpwdup"></p>
                                    </div>
                                </div>
                                <div class="modal-footer no-bd">
                                    <button class="btn btn-primary">Add</button>
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
<?php echo $__env->make('template.footerAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;<?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/admin/user.blade.php ENDPATH**/ ?>