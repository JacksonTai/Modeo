<?php
// get the page url.
$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// assign different file directories based on where the page file located at.
strpos($url, 'index') ? $path = '' : $path = '../../';
 
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="copyright" content="Copyright 2021 - Modeo">
<meta name="description" content="Welcome to Modeo!">
<meta name="author" content="Jackson Tai">
<script src="https://kit.fontawesome.com/a64d2d03df.js" crossorigin="anonymous"></script>
<link rel="shortcut icon" href="<?php echo htmlspecialchars($path) ?>img/icons/logo.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo htmlspecialchars($path) ?>css/style.css">