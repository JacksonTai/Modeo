<?php
// Redirect user to main page if they haven't sign in.
if (!$userInfo) {
     header('Location: ../../index.php');
}
