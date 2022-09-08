<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
if ($this->session->userdata('level') == 1) {
    echo "anda admin";
}
if ($this->session->userdata('level') == 2) {
    echo "anda guru";
}
if ($this->session->userdata('level') == 3) {
    echo "anda user";
}
 ?>
<div class="container">
    <table class="table table-bordered mt-5">
    <?php  
    foreach($planet as $temp)
    {        
        echo '<thead><tr><th scope="col" class="text-break"><img id="img" height="120" src="'.$temp['newcol'].'"><br>'. ' == '. $temp['newcol2'] .'</th></tr></thead>';
        // echo '<img id="img" height="120" src="'.$temp['newcol'].'"><br>';
        // foreach($temp as $temps => $val){
        //     if (!$val){
        //         $val = "<b>[KOSONG]</b> ";
        //     }
        //     echo '<thead><tr><th scope="col" class="text-break">'. ' == '. $val .'</th></tr></thead>';
            // echo '<tbody><tr><td>' . $val . '</td></tr></tbody>';
// }
} ?>
    
    </table>
    </div>
</div>
</body>
</html>