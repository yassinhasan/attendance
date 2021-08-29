<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1> hello iam, home</h1>
<form action="<?= toLink("submit") ?>" method="POST" enctype="multipart/form-data">
 <label for="name">name</label>
<input name="name" type="text" id="name">
<label for="image">image</label>
<input name="image" type="file" id="image"> 
<input type="submit" value="submit">
</form>
</body>
</html>