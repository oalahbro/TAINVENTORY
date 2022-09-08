<!--   Core JS Files   -->
<script src="<?= base_url(); ?>/assets/js/core/jquery.3.2.1.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/core/popper.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="<?= base_url(); ?>/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="<?= base_url(); ?>/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Moment JS -->
<script src="<?= base_url(); ?>/assets/js/plugin/moment/moment.min.js"></script>

<!-- Chart JS -->
<script src="<?= base_url(); ?>/assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="<?= base_url(); ?>/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="<?= base_url(); ?>/assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="<?= base_url(); ?>/assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="<?= base_url(); ?>/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- Bootstrap Toggle -->
<script src="<?= base_url(); ?>/assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="<?= base_url(); ?>/assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

<!-- Google Maps Plugin -->
<script src="<?= base_url(); ?>/assets/js/plugin/gmaps/gmaps.js"></script>

<!-- Sweet Alert -->
<script src="<?= base_url(); ?>/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Azzara JS -->
<script src="<?= base_url(); ?>/assets/js/ready.min.js"></script>

<script src="https://www.jquery-az.com/boots/js/bootstrap-imageupload/bootstrap-imageupload.js"></script>

<script type="text/javascript">
  $(".logout").click(function() {

    swal({
        title: "Anda yakin keluar?",
        text: "Setelah keluar anda akan diminta login untuk mengakses halaman ini",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Anda berhasil logout", {
            icon: "success",
            buttons: false,
          });
          setTimeout(function() {
            window.location.href = '<?= base_url() ?>/login/logout';
          }, 1000);
        } else {

        }
      });
  });
</script>

<script>
  var $imageupload = $('.imageupload');
  $imageupload.imageupload();
</script>
<script>
  const MAX_WIDTH = 580;
  const MAX_HEIGHT = 854;
  const MIME_TYPE = "image/jpeg";
  const QUALITY = 0.4;
  const input = document.getElementById("img1");
  const inputMod = document.getElementById("imgInp");
  input.onchange = function(ev) {
    const file = ev.target.files[0]; // get the file
    const blobURL = URL.createObjectURL(file);
    const img = new Image();
    const bla = document.getElementById('bla')
    const [gambar] = input.files
    if (gambar) {      
    bla.src = URL.createObjectURL(file)
    bla.removeAttribute("hidden")
    }

    img.src = blobURL;
    img.onerror = function() {
      URL.revokeObjectURL(this.src);
      // Handle the failure properly
      console.log("Cannot load image");
    };
    img.onload = function() {
      URL.revokeObjectURL(this.src);
      const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
      const canvas = document.createElement("canvas");
      canvas.width = newWidth;
      canvas.height = newHeight;
      const ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0, newWidth, newHeight);
      canvas.toBlob(
        (blob) => {
        },
        MIME_TYPE,
        QUALITY
      );
      // document.getElementById("root").append(canvas);
      var dataURL = canvas.toDataURL();
      document.getElementById('putbase').value = dataURL;
      
    };
  };

  inputMod.onchange = function(ev) {
    const file = ev.target.files[0]; // get the file
    const blobURL = URL.createObjectURL(file);
    const img = new Image();
    const blah = document.getElementById('blah')
    const [gambar] = inputMod.files
    if (gambar) {      
    blah.src = URL.createObjectURL(file)
    blah.removeAttribute("hidden")
    }

    img.src = blobURL;
    img.onerror = function() {
      URL.revokeObjectURL(this.src);
      // Handle the failure properly
      console.log("Cannot load image");
    };
    img.onload = function() {
      URL.revokeObjectURL(this.src);
      const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
      const canvas = document.createElement("canvas");
      canvas.width = newWidth;
      canvas.height = newHeight;
      const ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0, newWidth, newHeight);
      canvas.toBlob(
        (blob) => {
        },
        MIME_TYPE,
        QUALITY
      );
      // document.getElementById("root").append(canvas);
      var dataURL = canvas.toDataURL();
      document.getElementById('putbas').value = dataURL;

    };
  };

  

function showTmp(){
  const api_url = "<?= base_url() ?>buyer/Buyer/getTmp";
  async function getapi(url) {
        const response = await fetch(url);

        var dat = await response.json();
        
        show(dat);
    }
    getapi(api_url);
    function show(dat) {
            let tab =
                ``;

            // Loop to access all rows
            for (let r of dat) {
                tab += `<div class="row alert alert-info px-2 mx-0" role="alert"><div class="col-10 px-0 tom edit-tmp" onclick="modl('${r.id_aset_tmp}')">
       ${r.nama_aset}<b>, Code :</b>&nbsp;${r.code}</div>
       <div class="col-2 pl-0">
                                <button type="button" class="close text-danger" onclick="delTmp('${r.id_aset_tmp}')" aria-label="Close">
                                    <span >&times;</span>
                                </button>
                                </div></div>`;
            }
            // Setting innerHTML as tab variable
            document.getElementById("tmp").innerHTML = tab;
        }
}

  function pass(){
      const url = "<?= base_url() ?>/buyer/Buyer/pass"
      const data = {
        tujuan : document.getElementById('tuj').value,
        kategori : document.getElementById('kat').value,
        nama : document.getElementById('nam').value,
        code : document.getElementById('cod').value,
        img : document.getElementById('putbase').value,
        spesifikasi : document.getElementById('spek').value,
        deskripsi : document.getElementById('des').value,

      }

      $('.subm').hide()
      $('.load').show()

      $.post(url,data, function(data, status){
        
        if(status == 'success'){
          $.notify({
              message: 'Sukses Menambah Inventory semenatara'
          }, {
              type: 'info',
              delay: 1100,
              position: 'relative'
          });

          $('.subm').show()
          $('.load').hide()
        
        showTmp()
        }
      })
      
  }

  function passUp(){
      const url = "<?= base_url() ?>buyer/Buyer/updateTmp"
      const data = {
        id_aset : document.getElementById('id_aset_tmp').value,
        tujuan : document.getElementById('tujuan').value,
        kategori : document.getElementById('kategori').value,
        nama : document.getElementById('nama_aset').value,
        code : document.getElementById('code').value,
        img : document.getElementById('putbas').value,
        spesifikasi : document.getElementById('spesifikasi').value,
        deskripsi : document.getElementById('deskripsi').value,

      }

      // $('.subm').hide()
      // $('.load').show()

      $.post(url,data, function(data, status){
        
        if(status == 'success'){
          swal('Berhasil update data', {
            icon : "info",
	          timer: 800,
            buttons: false
          });
          console.log(data)
          // $('.subm').show()
          // $('.load').hide()

        
        showTmp()
        }
      })
      
  }

  $(document).ready(function(){
  // we call the function
  showTmp();
  });

  function modl(id_aset){
    $('#modaledit').modal('toggle');
    $('#modaledit').modal('show');
    $('#modaledit').modal('hide');
      // get data from button edit
      const id_aset_tmp = id_aset
      $('#id_aset_tmp').val(id_aset_tmp);
      var api_url = "<?= base_url() ?>buyer/Buyer/api?asetid=" + id_aset_tmp;
      
      async function getapi(url) {
          const response = await fetch(url);
          var data = await response.json();
          
          if (response) {
              hideloader();
          }
          show(data);
      }
      getapi(api_url);
      function hideloader() {
          document.getElementById('loading').style.display = 'none';
          document.getElementById('fupdate').style.display = 'block';
      }
      function show(data) {
        $('#kategori').val(data[0]['id_category']);
        $('#kategori').html(data[0]['kategori_info'][0]['nama_kategori']);
        $('#tujuan').val(data[0]['id_user_tujuan']);
        $('#tujuan').html(data[0]['tujuan_info'][0]['nama_Admin']);
        $('#nama_aset').val(data[0]['nama_aset']);
        $('#code').val(data[0]['code']);
        $('#blah').attr('src',data[0]['img']);
        $('#spesifikasi').val(data[0]['spesifikasi']);
        $('#deskripsi').val(data[0]['deskripsi']);
      }

  }

  function delTmp(id_aset){
    var url = "<?= base_url() ?>buyer/Buyer/delTmp"
    const data = {
        id_aset_tmp : id_aset
    }
    $.post(url,data, function(data, status){
        
        if(status == 'success'){
          $.notify({
              message: 'Inventory semenatara telah dihapus'
          }, {
              type: 'info',
              delay: 1100
          });
        
        showTmp()
        }
      })
  }

  function calculateSize(img, maxWidth, maxHeight) {
    let width = img.width;
    let height = img.height;

    // calculate the width and height, constraining the proportions
    if (width > height) {
      if (width > maxWidth) {
        height = Math.round((height * maxWidth) / width);
        width = maxWidth;
      }
    } else {
      if (height > maxHeight) {
        width = Math.round((width * maxHeight) / height);
        height = maxHeight;
      }
    }
    return [width, height];
  }
  function readableBytes(bytes) {
    const i = Math.floor(Math.log(bytes) / Math.log(1024)),
      sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
  }
</script>
<script>
  $(document).ready(function() {
    $('#basic-datatables').DataTable({});

    $('#multi-filter-select').DataTable({
      "pageLength": 5,
      initComplete: function() {
        this.api().columns().every(function() {
          var column = this;
          var select = $('<select class="form-control"><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on('change', function() {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              column
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();
            });

          column.data().unique().sort().each(function(d, j) {
            select.append('<option value="' + d + '">' + d + '</option>')
          });
        });
      }
    });

    // Add Row
    $('#add-row').DataTable({
      "pageLength": 5,
    });

    var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

    $('#addRowButton').click(function() {
      $('#add-row').dataTable().fnAddData([
        $("#addName").val(),
        $("#addPosition").val(),
        $("#addOffice").val(),
        action
      ]);
      $('#addRowModal').modal('hide');

    });
  
      

      $('#modaledit').on('hidden.bs.modal',function(){
        document.getElementById('loading').style.display = 'block';
        document.getElementById('fupdate').style.display = 'none';
      })
      
        // get Delete Product
        $('.btn-delete').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');
            // Set data to Form Edit
            $('.productID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });
         
});
</script>
<?php
error_reporting(0);
?>
{{ $_SESSION['success'] }}
</body>

</html>