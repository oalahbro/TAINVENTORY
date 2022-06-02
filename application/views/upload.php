<input type="file" onchange="encodeImageFileAsURL(this)" />
<!-- <input type="file" onchange="encodeImageFileAsURL(this)" /> -->
<div >
<!-- <form method="post" action="/admin/admin/insert"> -->
<form method="post" action="/admin/admin/imageResize">
        <input name="text" type="text" value="" id="mydiv" placeholder="enter some text" />
        <input name="text2" type="text" placeholder="enter some text" />
        <input type="submit" value="Save" name="submit">
    </form>


    <form action="<?php echo base_url().'admin/upload/upload_image'?>" method="post" enctype="multipart/form-data">
        <input type="text" name="xjudul" placeholder="Judul">
        <input type="file" name="filefoto">
        <button type="submit">Upload</button>
    </form>
</div>

<script>
function encodeImageFileAsURL(element) {
  var file = element.files[0];
  var reader = new FileReader();
  reader.onloadend = function() {
    var b64cok = reader.result
    document.getElementById('mydiv').value = b64cok;
  }
  reader.readAsDataURL(file);
}


</script>
