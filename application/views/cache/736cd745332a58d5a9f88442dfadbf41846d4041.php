<?php echo $__env->make('template.headerBuyer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <h4 class="page-title">User Profile</h4>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-with-nav">
                        <div class="card-header ">
                            <div class="row row-nav-line">
                                <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Profile</a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="myform">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default mb-2">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="" required>
                                    </div>
                                    <label id="email-error" class="error mt-0 ml-2" for="email"></label>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default mb-2">
                                        <label>username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="">
                                    </div>
                                    <label id="username-error" class="error mt-0 ml-2" for="username"></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default mb-2">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="" required>
                                    </div>
                                    <label id="phone-error" class="error mt-0 ml-2" for="phone"></label>
                                </div>
                            </div>
                            </form>
                            <div class="mt-3 mb-3">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#resetpwd">Reset Password</button>
                                <button class="float-right btn btn-success" id="edit-profile" data-toggle="modal" data-target="#changeprofile">Edit Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 rounded">
                    <div class="card card-profile card-success">
                        <div class="card-header rounded-top" style="background-image: url('https://picsum.photos/900/400')">
                            <div class="profile-picture">
                                <div class="avatar avatar-xl image-set">
                                    <a data-gallery="photoviewer" data-group="a"
                                        href="" id="foto">
                                        <img src="" alt="..." class="avatar-img rounded-circle border border-white border-3" id="foto1">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-xl-5">
                            <div class="user-profile text-center">
                                <div class="change-img mb-2 text-primary" onclick="getimg()" ><a style="cursor: pointer;">Ganti Foto</a></div>
                                <div class="name" id="nameprfl"></div>
                                <div class="job" id="level"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="resetpwd" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <p class="small">Masukkan Password lama dan baru</p>
                            <form onsubmit="return resetPwd();" method="POST" action="">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Password lama</label>
                                            <input id="pwdold" type="password" class="form-control" required>
                                            
                                        </div>
                                        <p class="text-danger ml-2" id="errpwdold"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default">
                                            <label>Password baru</label>
                                            <input id="pwdnew" type="password" class="form-control" required>
                                        </div>
                                        <p class="text-danger ml-2" id="errpwdnew"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default">
                                            <label>Masukkan kembali password baru</label>
                                            <input id="pwdnew1" type="password" class="form-control" required>
                                            <input id="img1" hidden >
                                        </div>
                                        <p class="text-danger ml-2" id="errpwdnew1"></p>
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
            
            <div class="modal fade" id="change-img" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header no-bd">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold">
                                    Ganti</span>
                                <span class="fw-light">
                                    Foto
                                </span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="small">Masukkan Foto baru</p>
                            <form onsubmit="return imgUpdate();" method="POST" action="">
                                <div class="d-flex justify-content-center">
                                    <div class="form-group">
                                        <img id="blah" src="#" alt="your image" style="max-width: 20rem;" /><br>
                                        <label for="exampleFormControlFile1">Masukkan Gambar</label>
                                        <input type="text" id="putbas" hidden>
                                        <input id="imgInp" name="img" type="file" class="form-control-file resize" >
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
            
            <div class="modal fade" id="changeprofile" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header no-bd">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold">
                                    Edit</span>
                                <span class="fw-light">
                                    Profile
                                </span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="small">Masukkan Password untuk konfirmasi</p>
                            <form onsubmit="return updateProfile();" method="POST" action="">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Password</label>
                                            <input id="pwdedit" type="password" class="form-control" required>
                                        </div>
                                        <p class="text-danger ml-2" id="errpwdedit"></p>
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
<?php echo $__env->make('template.footerBuyer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;<?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/buyer/profile.blade.php ENDPATH**/ ?>