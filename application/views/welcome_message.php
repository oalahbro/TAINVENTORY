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
    <div>
    <form method="post" action="/welcome/insert">
        <input name="text" type="text" placeholder="enter some text" />
        <input name="text2" type="text" placeholder="enter some text" />
        <input type="submit" value="Save" name="submit">
    </form>
    </div>
    <br/>
    <div>
        <h2>update</h2>
    <form method="post" action="/welcome/update">
        <input name="text2" type="text" placeholder="enter some text" />
        <input type="submit" value="Save" name="submit">
    </form>
    </div>
</body>
</html>



