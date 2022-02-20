<?php
// Change file directories for index.php and files in app/view.
$url = $_SERVER['REQUEST_URI'];
strpos($url, 'app') ? $path = '../../' : $path = '';
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="copyright" content="Copyright <?php echo date('Y'); ?> - Modeo">
<meta name="description" content="Welcome to Modeo!">
<meta name="author" content="Jackson Tai">
<link rel="shortcut icon" href="<?php echo $path ?>img/icons/logo.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo $path ?>css/style.css">