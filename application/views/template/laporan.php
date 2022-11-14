<!doctype html>
<html lang="en">
<?php error_reporting(0); ?>

<head>
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Print Lpaoran</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: small;
        }

        .teer {
            line-height: 16px;
            min-height: 16px;
            height: 16px;
        }

        .gray {
            background-color: lightgray
        }

        table {
            text-align: left;
            position: relative;
            border-collapse: collapse;
            background-color: #fefaff;
        }

        /* Spacing */
        td,
        th {
            border: 1px solid #3d3d3d;
            padding: 10px;
        }

        th {
            background: #bddfeb;
            color: black;
            border-radius: 0;
            position: sticky;
            top: 0;
            padding: 10px;
        }

        .primary {
            background-color: #000000
        }

        tfoot>tr {
            background: black;
            color: white;
        }

        tbody>tr:hover {
            background-color: #ffc107;
        }

        hr.new5 {
            border: 2px solid black;
            border-radius: 2px;
            margin-top: -30px;
        }

        .right {
            position: absolute;
            right: 0px;

            bottom: 0;
            width: 300px;
            /* border: 3px solid #73AD21; */
            /* padding: 10px; */
            text-align: center;
        }
    </style>

</head>

<body>

    <table width="100%" style="top:-30px; height : 150px; border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ; background: white;">
        <tr style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ;">
            <td style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ; padding-top:2rem;" valign=" top" width="150">
                <img src="<?= base_url() ?>/assets/img/logo-kecil.png" alt="" width="270" />
            </td>
            <td style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ; " align="center">
                <h3 class="mb-2">KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</h3>
                <h2>SMK NEGERI 5 Madiun</h2>
                <p class="mb-0">JL. MERAK No 5, Kota Madiun Prov. Jawa Timur</p>
                <p>Telepon (0351) 464575 Kode Pos: 63128 https://smkn5madiun.sch.id</p>
            </td>
        </tr>
    </table>
    <hr class="new5">
    <p align="center">
        <b> LAPORAN INVENTORY</b>
    </p>
    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr class="teer">
                <th>No</th>
                <th>Nama Inventory</th>
                <th>Code</th>
                <th>Tanggal Waktu</th>
                <th>Penanggung Jawab</th>
                <th>Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($laporan as $lap) {
                if ($lap['tujuan_info'][0] == "") {
                    $tujuan = "";
                } else {
                    $tujuan = $lap['user_info'][0]['nama_Admin'];
                }

                if ($lap['status'] == 'R0') {
                    $status = 'Request Keluar';
                }
                if ($lap['status'] == 'R1') {
                    $status = 'Request Masuk';
                }
                if ($lap['status'] == 'R1Y') {
                    $status = 'Request Masuk Diterima';
                }
                if ($lap['status'] == 'R0Y') {
                    $status = 'Request Keluar Diterima';
                }
                if ($lap['status'] == 'R1N') {
                    $status = 'Request Masuk Ditolak';
                }
                if ($lap['status'] == 'R0N') {
                    $status = 'Request Keluar Ditolak';
                }
                if ($lap['status'] == 'R1F') {
                    $status = 'Request Masuk Diteruskan';
                }
                if ($lap['status'] == 'R0F') {
                    $status = 'Request Keluar Diteruskan';
                }
            ?>
                <tr class="teer">
                    <th scope="row"><?= $no ?></th>
                    <td align="left"><?= $lap['nama_aset'] ?></td>
                    <td align="left"><?= $lap['code'] ?></td>
                    <td align="center"><?= $lap['date'] ?></td>
                    <td align="center"><?= $lap['user_info'][0]['nama_Admin'] ?></td>
                    <td align="center"><?= $tujuan ?></td>
                    <td align="center"><?= $status ?></td>

                </tr>
            <?php
                $no++;
            } ?>

        </tbody>


    </table>
    <div class="right">
        <p style="margin-bottom: 50px;">Madiun ,<?php
                                                echo $date = date('d-M-Y'); ?></p>

        <b>Mulyono <br>
            NIP : </b> 197012102007011023
    </div>
    <script src="<?= base_url() ?>/assets/js/core/bootstrap.min.js"></script>
</body>

</html>