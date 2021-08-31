<h1> hello iam, home</h1>

<form action="<?= toLink("submit") ?>" method="POST" enctype="multipart/form-data">
        <label for="name">name</label>
        <input name="name" type="text" id="name">
        <label for="image">image</label>
        <input name="image" type="file" id="image"> 
        <input type="submit" value="submit">
</form>

<a href="<?= toLink("admin/login") ?>"> login page </a>
