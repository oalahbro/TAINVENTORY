<html>

<div id="root">
  <form method="post" action="/admin/admin/opo">
    <input name="text" type="text" value="" id="mydiv" placeholder="enter some text" />
    <input type="submit" value="Save" name="submit">
  </form>
  <p>Upload an image and see the result</p>
  <input id="img-input" type="file" accept="image/*" style="display:block" />
</div>

<script>
  const MAX_WIDTH = 600;
  const MAX_HEIGHT = 1000;
  const MIME_TYPE = "image/jpeg";
  const QUALITY = 0.3;

  const input = document.getElementById("img-input");
  input.onchange = function(ev) {
    const file = ev.target.files[0]; // get the file
    const blobURL = URL.createObjectURL(file);
    const img = new Image();
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
          // Handle the compressed image. es. upload or save in local state
          // displayInfo('Original file', file);
          // displayInfo('Compressed file', blob);
        },
        MIME_TYPE,
        QUALITY
      );
      // document.getElementById("root").append(canvas);
      var dataURL = canvas.toDataURL();
      document.getElementById('mydiv').value = dataURL;

    };
  };

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

  // Utility functions for demo purpose

  // function displayInfo(label, file) {
  //   const p = document.createElement('p');
  //   p.innerText = `${label} - ${readableBytes(file.size)}`;
  //   document.getElementById('root').append(p);
  // }

  function readableBytes(bytes) {
    const i = Math.floor(Math.log(bytes) / Math.log(1024)),
      sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
  }
</script>

</html>