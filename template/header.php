<?php
session_start();
require_once __DIR__.'/../config/app.php';
?>
<!Doctype html>
<html dir="<?php echo $config['dir']?>" lang="<?php echo $config['lang']?>">

<head>
    <title><?php echo $config['app_name'] ." | ".$title?></title>
    <script src="bootstrap-autocomplete.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>
<body>
<div class="container pt-5 ">