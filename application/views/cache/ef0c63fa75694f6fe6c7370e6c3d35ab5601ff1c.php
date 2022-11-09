<?php echo $__env->make('template.headerAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <h4 class="page-title">User Profile</h4>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-with-nav">
                        <div class="card-header">
                            <div class="row row-nav-line">
                                <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Profile</a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo e($planet['profile']['nama_Admin']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo e($planet['profile']['email']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo e($planet['profile']['username']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo e($planet['profile']['telp']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-3">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#resetpwd">Reset Password</button>
                                <button class="float-right btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile card-secondary">
                        <div class="card-header" style="background-image: url('<?php echo e(base_url()); ?>assets/img/blogpost.jpg')">
                            <div class="profile-picture">
                                <div class="avatar avatar-xl">
                                    <img src="<?php echo e(base_url()); ?>/assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile text-center">
                                <div class="name"><?php echo e($planet['profile']['nama_Admin']); ?></div>
                                <div class="job">Frontend Developer</div>
                                <div class="view-profile">
                                    <a href="#" class="btn btn-secondary btn-block">View Full Profile</a>
                                </div>
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
                                            <input id="pwdold" type="text" class="form-control" required>
                                        </div>
                                        <p class="text-danger ml-2" id="errpwdold"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default">
                                            <label>Password baru</label>
                                            <input id="pwdnew" type="text" class="form-control" required>
                                        </div>
                                        <p class="text-danger ml-2" id="errpwdnew"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default">
                                            <label>Masukkan kembali password baru</label>
                                            <input id="pwdnew1" type="text" class="form-control" required>
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
        </div>
    </div>
</div>
<?php echo $__env->make('template.footerAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;<?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/admin/profile.blade.php ENDPATH**/ ?>