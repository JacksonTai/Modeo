<?php
function setUserType()
{
     $userInfo = $_SESSION['userInfo'] ?? null;

     if ($userInfo) {
          if ($userInfo['user_id'][0] == 'N') {
               $userType = 'normal';
          }

          if ($userInfo['user_id'][0] == 'A') {
               $userType = 'admin';
          }
     } else {
          $userType = 'guest';
     }

     return [$userType, $userInfo];
}
$userType = setUserType()[0];
$userInfo = setUserType()[1];
