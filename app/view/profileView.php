<?php
session_start();
require '../helper/setUserType.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>
          Profile - 
          <?php
          $userType == 'admin' ? $title = 'Modeo (Admin)' : $title = 'Modeo';
          echo $title;
          ?>
     </title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="profile-main">
          <div class="profile-content-container">
               <h2 class="profile-title">Profile</h2>
               <img class="profile-img" src="../../img/icons/userProfile.jpg" alt="Profile picture">
               <p class="profile-content"><span>User Id: </span><?php echo htmlspecialchars($userInfo['user_id']); ?></p>
               <p class="profile-content"><span>Email Address: </span><?php echo htmlspecialchars($userInfo['email']); ?></p>
               <p class="profile-content"><span>Username: </span><?php echo htmlspecialchars($userInfo['username']); ?></p>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
</body>

</html>