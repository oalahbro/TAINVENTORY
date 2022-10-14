
  $(document).ready(function(){
    if(document.title.includes("Masukkan")){
      showTmp();
    }else{
      dataTable();
    }
  });
  $('select').on('change', function() {
  });
  
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
            window.location.origin + '/login/logout';
          }, 1000);
        } else {

        }
      });
  });

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
  
  // ON INS
  function showTmp(){
    const api_url = "getTmp";
    async function getapi(url) {
          const response = await fetch(url);
          var dat = await response.json();
          show(dat);
          if (!dat.length){
            $("#btn-insert").prop('disabled', true);
          }else{
            $("#btn-insert").prop('disabled', false);
          }
          
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
            document.getElementById("tmp").innerHTML = tab;
        }
  }

  function pass(){
      const url = "pass"
      const data = {
        tujuan : document.getElementById('tuj').value,
        kategori : document.getElementById('kat').value,
        nama : document.getElementById('nam').value,
        code : document.getElementById('cod').value,
        img : document.getElementById('putbase').value,
        spesifikasi : document.getElementById('spek').value,
        deskripsi : document.getElementById('des').value,
      }
      if(!data.code){
        $.notify({
              message: 'Gagal Menambah Inventory semenatara, code inventory tidak boleh kosong'
          }, {
              type: 'danger',
              delay: 1100
          });      
      }else{
      $('.subm').hide()
      $('.load').show()

      $.post(url,data, function(data, status){
        
          if(status == 'success'){
            $.notify({
                message: 'Sukses Menambah Inventory semenatara'
            }, {
                type: 'info',
                delay: 1100
            });
  
            $('.subm').show()
            $('.load').hide()
          
          showTmp()
          clearTimeout(gum);
          }
        })
      }
      var gum = setTimeout(function() {
        $.notify({
          message: 'Pastikan koneksi anda lancar, atau reload halaman'
      }, {
          type: 'warning',
          delay: 1100
      });
        }, 10000);
    return false
  }

  function passUp(){
      const url = "updateTmp"
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
      $.post(url,data, function(data, status){
        
        if(status == 'success'){
          swal('Berhasil update data', {
            icon : "info",
	          timer: 800,
            buttons: false
          });
        showTmp()
        }
      })
  }

  function modl(id_aset){
    $('#modaledit').modal('show');
      const id_aset_tmp = id_aset
      $('#id_aset_tmp').val(id_aset_tmp);
      var api_url = "api?asetid=" + id_aset_tmp;
      
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
        $('#tujuan').val(data[0]['id_user_tujuan']);
        $('#nama_aset').val(data[0]['nama_aset']);
        $('#code').val(data[0]['code']);
        $('#blah').attr('src',data[0]['img']);
        $('#spesifikasi').val(data[0]['spesifikasi']);
        $('#deskripsi').val(data[0]['deskripsi']);
      }
      if (!$('.modal').hasClass("show")){
        document.getElementById('loading').style.display = 'block';
        document.getElementById('fupdate').style.display = 'none';
      }
  }

  function delTmp(id_aset){
    var url = "delTmp"
    const data = {
        id_aset_tmp : id_aset
    }
    $.post(url,data, function(data, status){
        
        if(status == 'success'){
        showTmp()
          $.notify({
              message: 'Inventory sementara telah dihapus'
          }, {
              type: 'info',
              delay: 1100
          });
        }
      })
  }

  function insert(){
    $('.allin').hide()
    $('.allload').show()
    const api_url = "reqInvt";
    async function getapi(url) {
        const response = await fetch(url);
        var dat = await response.json();
        masuk(dat)
    }
    getapi(api_url);
    function masuk(dat){
      if(dat.respon == 'habis'){
          $.notify({
              message: 'Inventory semenatara berhasil di request'
          }, {
              type: 'info',
              delay: 1100
          });
          $('.allin').show()
          $('.allload').hide()
        }
        else{
          $('.allin').hide()
          setTimeout(function() {
            getapi(api_url);
            showTmp()
          }, 100);
        }
    }
  }
// END INS
// ON REQ
  function delReq(id_aset){
    var url = "delReq"
    const data = {
        id_aset : id_aset
    }
    $.post(url,data, function(data, status){
        
        if(status == 'success'){
          $.notify({
              message: 'Inventory request telah dihapus'
          }, {
              type: 'info',
              delay: 1100
          });
          dataTable();
        }
      })
  }

  function dataTable() {
    const api_url = link
    async function getapi(url) {
          const response = await fetch(url);
          var dat = await response.json();
          let kp = dat
          merg(kp)
      }
    getapi(api_url);
    function merg(kp){
      ok = []
      for(let i of kp) {
          let obj = [i.nama_aset , i.code , i.tujuan_info[0]['nama_Admin'] , `<div class="form-button-action">
            <button type="button" data-toggle="tooltip" onclick="updtReq('${i.id_aset}')" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
              <i class="fa fa-edit"></i>
            </button>
            <button type="button" data-toggle="tooltip" onclick="delReq('${i.id_aset}')" title="" class="btn btn-link btn-danger" data-original-title="Remove">
              <i class="fa fa-times"></i>
            </button>
          </div>`];
          ok.push(obj);
      }
      $('#basic-datatables').DataTable({
              "pageLength": 5,
              "bDestroy": true,
              data: ok
            });
    }
};
  function addReq(){
    const url = "addReq"
    const data = {
      tujuan : document.getElementById('tuj').value,
      kategori : document.getElementById('kat').value,
      nama : document.getElementById('nam').value,
      code : document.getElementById('cod').value,
      img : document.getElementById('putbase').value,
      spesifikasi : document.getElementById('spek').value,
      deskripsi : document.getElementById('des').value,
    }
    if(!data.code){
      $.notify({
            message: 'Gagal Menambah Inventory request, code inventory tidak boleh kosong'
        }, {
            type: 'danger',
            delay: 1100
        });      
    }else{
      $('.subm').hide()
    $('.load').show()

    $.post(url,data, function(data, status){
      
      if(status == 'success'){
        $.notify({
            message: 'Sukses Menambah Inventory request'
        }, {
            type: 'info',
            delay: 1100
        });

        $('.subm').show()
        $('.load').hide()
      
        dataTable();
        $('#modaladd').modal('hide')
      }
    })
    }
  return false
}
function updtReq(id_aset){
  $('#modaledit').modal('show');
    const id_aset_tmp = id_aset
    $('#id_aset').val(id_aset_tmp);
    var api_url = "getReq?asetid=" + id_aset_tmp;
    
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
      $('#katup').val(data[0]['id_category']);
      $('#tujup').val(data[0]['id_user_tujuan']);
      $('#nama_aset').val(data[0]['nama_aset']);
      $('#code').val(data[0]['code']);
      $('#blah').attr('src',data[0]['img']);
      $('#spesifikasi').val(data[0]['spesifikasi']);
      $('#deskripsi').val(data[0]['deskripsi']);
    }
    if (!$('.modal').hasClass("show")){
      document.getElementById('loading').style.display = 'block';
      document.getElementById('fupdate').style.display = 'none';
    }
  }
  function updateReq(){
    const url = "updateReq"
    const data = {
      id_aset : document.getElementById('id_aset').value,
      tujuan : document.getElementById('tujup').value,
      kategori : document.getElementById('katup').value,
      nama : document.getElementById('nama_aset').value,
      code : document.getElementById('code').value,
      img : document.getElementById('putbas').value,
      spesifikasi : document.getElementById('spesifikasi').value,
      deskripsi : document.getElementById('deskripsi').value,
}
    $.post(url,data, function(data, status){
      if(status == 'success'){
        swal('Berhasil update data', {
          icon : "info",
          timer: 800,
          buttons: false
        });
        dataTable();
        $('#modaledit').modal('hide')
      }
    })
}

function getBack(){
    const id_aset_tmp = $('#asetback').val();
    var api_url = "getReq?asetid=" + id_aset_tmp;
    
    async function getapi(url) {
        const response = await fetch(url);
        var data = await response.json();
        show(data);
    }
    getapi(api_url);
    function show(data) {
      $('#descback').val(data[0]['deskripsi']);
    }
  }
function backReq(){
  const url = "backReq"
  const dat = {
    id_aset : document.getElementById('asetback').value,
    tujuan : document.getElementById('tujback').value,
    deskripsi : document.getElementById('descback').value,
  }
  $('.subm').hide()
  $('.load').show()
  $.post(url,dat, function(data, status){
      if(status == 'success'){
        $.notify({
            message: 'Sukses Menambah request aset kembali'
        }, {
            type: 'info',
            delay: 1100
        });

        $('.subm').show()
        $('.load').hide()
      
        dataTable();
          $('#asetback').find(`[value=${dat.id_aset}]`).remove();
          $('#asetback').selectpicker('refresh');
          document.getElementById('descback').value = ''
      }
    })
  
return false
}
// END REQ

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