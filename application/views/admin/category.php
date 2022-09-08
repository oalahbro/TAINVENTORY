<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Kategori</h4>
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
                                <h4 class="card-title">Add Row</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                                    <i class="fa fa-plus"></i>
                                    Add Row
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Modal -->
                            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h5 class="modal-title">
                                                <span class="fw-mediumbold">
                                                    Tambah</span>
                                                <span class="fw-light">
                                                    Kategori
                                                </span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="small">Silahkan masukkan detail kategori</p>
                                            <form action="<?= base_url() . "admin/admin/addCategory" ?>" method="POST">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Nama Kategori</label>
                                                            <input id="addName" name="nama_kategori" type="text" class="form-control" placeholder="fill name">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group  form-group-default">
                                                            <label for="squareSelect">Pilih status</label>
                                                            <select class="form-control input-square" name="status" id="formGroupDefaultSelect">
                                                                <option value="1">Aktif</option>
                                                                <option value="0">Non aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                        <div class="modal-footer no-bd">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h5 class="modal-title">
                                                <span class="fw-mediumbold">
                                                    Edit</span>
                                                <span class="fw-light">
                                                    Kategori
                                                </span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="small">Silahkan masukkan detail kategori</p>
                                            <form action="<?= base_url() . "admin/admin/updateCategory" ?>" method="POST">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Nama Kategori</label>
                                                            <input id="id_kategori" name="id_kategori" type="text" hidden>
                                                            <input id="nama_kategori" name="nama_kategori" type="text" class="form-control" placeholder="fill name">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group  form-group-default">
                                                            <label for="squareSelect">Pilih status</label>
                                                            <select class="form-control input-square" name="status" id="formGroupDefaultSelect">
                                                                <option id="status" hidden></option>
                                                                <option value="1">Aktif</option>
                                                                <option value="0">Non aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                        <div class="modal-footer no-bd">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 6%">No</th>
                                            <th>Nama Kategori</th>
                                            <th>Status</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>


                                        <?php
                                        $no = 1;
                                        foreach ($planet['kategori'] as $cat) {
                                            echo "<tr><td>" . $no . "</td>
                                                      <td>" . $cat['nama_kategori'] . "</td>";
                                            if ($cat['status'] == 1) {
                                                echo "<td><p style='margin-bottom: 0;' class='btn btn-sm btn-success btn-round'>&nbsp;Aktif&nbsp;</p></td>";
                                            } else {
                                                echo "<td><p style='margin-bottom: 0;' class='btn btn-sm btn-danger btn-round'>Non Aktif</p></td>";
                                            }
                                            echo "
                                                <td>
                                                    <div class='form-button-action'>
                                                        <button type='button' title='' data-toggle='modal' data-target='#modaledit' class='btn btn-link btn-primary btn-lg' data-original-title='Edit Task' onClick=\"SetInput('" . $cat['id_kategori'] . "','" . $cat['nama_kategori'] . "','" . $cat['status'] . "')\">
                                                            <i class='fa fa-edit'></i>
                                                        </button>
                                                        <button type='button' data-toggle='modal' data-target='#delete-modal' title='' class='btn btn-link btn-danger' data-original-title='Remove' onClick=\"setInput1('" . $cat['id_kategori'] . "')\">
                                                            <i class='fa fa-times'></i>
                                                        </button>
                                                    </div>
                                                </td></tr>
                                                ";
                                            $no++;
                                        }
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                            <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" style="width:55%;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="custom-width-modalLabel">DATA PENGGUNA</h4>
                                        </div>

                                        <form action="<?php echo base_url() . 'admin/admin/delKategori'; ?>" method="post" class="form-horizontal" role="form">
                                            <div class="modal-body">
                                                <h4>Konfirmasi</h4>
                                                <p>Apakah anda yakin ingin menghapus data ini ?</p>
                                                <div class="form-group">
                                                    <input type="hidden" id="id_kategori1" name="id_kategori">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                            </div>
                                        </form>
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

<script type="text/javascript">
    function SetInput(id_kategori, nama_kategori, status) {
        document.getElementById('id_kategori').value = id_kategori;
        document.getElementById('nama_kategori').value = nama_kategori;
        document.getElementById('status').value = status;
        if (status == 1) {
            document.getElementById('status').innerText = "Aktif"
        } else {
            document.getElementById('status').innerText = "Nonaktif"
        }

    }

    function setInput1(id_kategori) {
        document.getElementById('id_kategori1').value = id_kategori;
    }

    // function notify() {

    // };
</script>