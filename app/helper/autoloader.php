<?php

spl_autoload_register('autoLoader');

function autoLoader($classname)
{
     $url = $_SERVER['REQUEST_URI'];

     // Change file directories for index.php and files in app/view.
     strpos($url, 'app') ? $path = '../' : $path = 'app/';

     $file = $path . $classname . '.php';

     if (file_exists($file)) {
          try {
               require_once $file;
          } catch (ErrorException $e) {
               echo 'Autoloader Failed' . $e->getMessage();
          }
     }
}
