<?php
// Change file directories for index.php and files in app/view.
$url = $_SERVER['REQUEST_URI'];
strpos($url, 'app') ? $imgPath = '../../' : $imgPath = '';
strpos($url, 'app') ? $homePath = '../../' : $homePath = '';
strpos($url, 'app') ? $appViewPath = '' : $appViewPath = 'app/view/';
strpos($url, 'app') ? $logoutPath = '../helper/' : $logoutPath = 'app/helper/';
?>

<header class="index-header">
     <h1 class="main-header__logo">
          <a class="main-header__logo-link" href="<?php echo $imgPath; ?>index.php">
               <img class="main-header__logo-img" src="<?php echo $imgPath; ?>img/logo.jpg" alt="Modeo logo">
          </a>
     </h1>
     <nav class="index-header__nav">
          <ul class="index-header__nav-list">
               <?php if ($userType == 'guest' || $userType == 'normal') : ?>
                    <li class="index-header__nav-item">
                         <a class="index-header__nav-link" href="<?php echo $homePath; ?>index.php">Home</a>
                    </li>
                    <li class="index-header__nav-item">
                         <a class="index-header__nav-link" href="<?php echo $appViewPath; ?>allProduct.php">Product</a>
                    </li>
                    <li class="index-header__nav-item">
                         <a class="index-header__nav-link" href="#index-about">About</a>
                    </li>
                    <?php
                    $page = 'orderHistory.php';
                    if ($userType == 'guest') {
                         $page = 'signin.php';
                    }
                    ?>
                    <li class="index-header__nav-item">
                         <a class="index-header__nav-link" href="<?php echo $appViewPath . $page; ?>">Orders</a>
                    </li>
               <?php endif; ?>
          </ul>
          <?php if (!strpos($url, 'signin') && !strpos($url, 'signup')) : ?>
               <div class="index-header__btn-container">
                    <?php if (isset($userInfo)) : ?>
                         <?php if ($userType == 'normal') : ?>
                              <a class="index-header__btn index-header__btn--cart" href="<?php echo $appViewPath; ?>cart.php">
                                   <img src="<?php echo $imgPath; ?>img/icons/cart.jpg" alt="Cart">
                              </a>
                         <?php endif; ?>
                         <a class="index-header__btn index-header__btn--profile" href="<?php echo $appViewPath; ?>profile.php">
                              <img src="<?php echo $imgPath; ?>img/icons/user.jpg" alt="User">
                         </a>
                         <a class="index-header__btn index-header__btn--signin" href="<?php echo $logoutPath; ?>logout.php">
                              <img src="<?php echo $imgPath; ?>img/icons/signin.jpg" alt="Icon">
                              Logout
                         </a>
                    <?php else : ?>
                         <a class="index-header__btn index-header__btn--signin" href="<?php echo $appViewPath; ?>signin.php">
                              <!-- <i class="fas fa-sign-in-alt"></i> -->
                              <img src="<?php echo $imgPath; ?>img/icons/signin.jpg" alt="Icon">
                              Sign in
                         </a>
                         <a class="index-header__btn index-header__btn--signup" href="<?php echo $appViewPath; ?>signup.php">Sign up</a>
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