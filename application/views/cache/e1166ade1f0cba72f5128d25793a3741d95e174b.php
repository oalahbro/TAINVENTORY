<!doctype html>
<html lang="en">

<head>
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

        .gray {
            background-color: lightgray
        }

        table {
            text-align: left;
            position: relative;
            border-collapse: collapse;
            background-color: #fffafa;
        }

        /* Spacing */
        td,
        th {
            border: 1px solid #999;
            padding: 10px;
        }

        th {
            background: #add8e6;
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
            margin-top: -20px;
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

    <table width="100%" style="top:-30px; height : 200px; border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ; background: white;">
        <tr style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ;">
            <td style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ; padding-left:5rem;" valign=" top" width="150">
                <img src="<?= base_url() ?>/assets/images/sma.png" alt="" width="120" />
            </td>
            <td style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0 ; padding-right:10rem;" align="center">
                <h2>KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</h2>
                <h2>SMA NEGERI 1 BARAT</h2>
                <p>JL. PASAR LEGI BARAT, BLARAN, Kec. Barat, Kab. Magetan Prov. Jawa Timur</p>
                <p>Telepon (0351869380) Kode Pos: 63393 Email:sma1barat@yahoo.co.id</p>
            </td>
        </tr>
    </table>
    <!-- <table width="50%">
        <tr>
            <td><strong>From:</strong><?= $tgl['tgl_mulai'] ?></td>
            <td><strong>To:</strong><?= $tgl['tgl_selesai'] ?></td>
        </tr>

    </table> -->
    <hr class="new5">
    <p align="center">
        <b> LAPORAN STOCK RUANGAN DAN BARANG</b>
    </p>
    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
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
            if(!$lap['tujuan_info']){
                $tujuan = "kosong";
            }else{
                $tujuan=$lap['user_info'][0]['nama_Admin'];
            }
                ?>
                <tr>
                    <th scope="row"><?= $no ?></th>
                    <td align="left"><?= $lap['nama_aset'] ?></td>
                    <td align="left"><?= $lap['code'] ?></td>
                    <td align="center"><?= $lap['date'] ?></td>
                    <td align="center"><?= $lap['user_info'][0]['nama_Admin'] ?></td>
                    <td align="center"><?= $tujuan ?></td>
                    <td align="center"><?= $lap['status'] ?></td>
                    
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
</body>

</html><?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/template/laporan.blade.php ENDPATH**/ ?>