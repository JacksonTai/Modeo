<?php

spl_autoload_register('autoLoader');

function autoLoader($classname)
{
     $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

     // assign different file directories based on where the page file located at.
     strpos($url, 'index') ? $path = 'app/' : $path = '../';

     $dbConfigFile =  $path . 'config/dbConfig.php';
     $modelFile = $path . 'model/' . $classname . '.php';
     $controllerFile = $path . 'controller/' . $classname . '.php';

     $files = [$dbConfigFile, $controllerFile, $modelFile];

     foreach ($files as $file) {
          if (file_exists($file)) {
               try {
                    require_once $file;
               } catch (ErrorException $e) {
                    echo 'Autoloader Failed' . $e->getMessage();
               }
          }
     }
}
