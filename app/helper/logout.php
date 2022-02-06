<?php

try {
     session_start();
     session_unset();
     session_destroy();
     header('Location: ../view/signinView.php');
} catch (Exception $e) {
     echo '<h2>Failed to destroy session!</h2> Error: ' . $e->getMessage();
}
