<?php
// Change file directories for index.php and files in app/view.
$url = $_SERVER['REQUEST_URI'];
strpos($url, 'app') ? $imgPath = '../../' : $imgPath = '';
strpos($url, 'app') ? $appPath = '../' : $appPath = 'app/';
?>

<header class="index-header">
     <h1 class="main-header__logo">
          <a class="main-header__logo-link" href="<?php echo $imgPath; ?>index.php">
               <img class="main-header__logo-img" src="<?php echo $imgPath; ?>img/logo.jpg" alt="Modeo logo">
          </a>
     </h1>
     <nav class="index-header__nav">
          <ul class="index-header__nav-list">
               <?php if (!strpos($url, 'app')) : ?>
                    <?php if ($userType == 'guest' || $userType == 'normal') : ?>
                         <li class="index-header__nav-item">
                              <a class="index-header__nav-link" href="#index-home">Home</a>
                         </li>
                         <li class="index-header__nav-item">
                              <a class="index-header__nav-link" href="#index-product">Product</a>
                         </li>
                         <li class="index-header__nav-item">
                              <a class="index-header__nav-link" href="#index-about">About</a>
                         </li>
                         <li class="index-header__nav-item">
                              <a class="index-header__nav-link" href="#index-contact">Contact</a>
                         </li>
                    <?php endif; ?>
               <?php endif; ?>
          </ul>
          <?php if (!strpos($url, 'signin') && !strpos($url, 'signup')) : ?>
               <div class="index-header__btn-container">
                    <?php if (isset($userInfo)) : ?>
                         <?php if ($userType == 'normal') : ?>
                              <a class="index-header__btn index-header__btn--cart" href="<?php echo $appPath; ?>view/cart.php">
                                   <!-- <i class="fas fa-shopping-cart"></i> -->
                                   <img src="<?php echo $imgPath; ?>img/icons/cart.jpg" alt="Cart">
                              </a>
                         <?php endif; ?>
                         <a class="index-header__btn index-header__btn--profile" href="<?php echo $appPath; ?>view/profile.php">
                              <!-- <i class="fas fa-user"></i> -->
                              <img src="<?php echo $imgPath; ?>img/icons/user.jpg" alt="User">
                         </a>
                         <a class="index-header__btn index-header__btn--signin" href="<?php echo $appPath; ?>helper/logout.php">
                              <!-- <i class="fas fa-sign-in-alt"></i> -->
                              <img src="<?php echo $imgPath; ?>img/icons/signin.jpg" alt="Icon">
                              Logout
                         </a>
                    <?php else : ?>
                         <a class="index-header__btn index-header__btn--signin" href="<?php echo $appPath; ?>view/signin.php">
                              <!-- <i class="fas fa-sign-in-alt"></i> -->
                              <img src="<?php echo $imgPath; ?>img/icons/signin.jpg" alt="Icon">
                              Sign in
                         </a>
                         <a class="index-header__btn index-header__btn--signup" href="<?php echo $appPath; ?>view/signup.php">Sign up</a>
                    <?php endif; ?>
               </div>
          <?php endif; ?>
     </nav>
     <div class="index-header__hamburger-menu">
          <span class="index-header__hamburger-bar"></span>
          <span class="index-header__hamburger-bar"></span>
          <span class="index-header__hamburger-bar"></span>
     </div>
</header>