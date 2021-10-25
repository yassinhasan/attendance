<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?=   $favicon  ?>
    <?php 
    foreach ($css as $key) { ?>
        <link rel="stylesheet" href="<?= assets("$key") ?>">
    <?php  }
    ?>
</head>
<body>

