<?php
include '../helper/autoLoader.php';

if (isset($_POST['create'])) {
     // Instantiate a new user object and run signup method.
     $newUser = new Controller\Signup($_POST);
     $errorMessage = $newUser->signup();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Create Account - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="user-entry-main">
          <div class="user-entry-panel">
               <h2 class="user-entry-panel__title">Create Account</h2>
               <form class="user-entry-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="user-entry-form__item-container">
                         <label class="user-entry-form__label" for="email">Email address</label>
                         <div class="user-entry-form__item-wrapper">
                              <input class="user-entry-form__input user-entry-form__input--signup" value="<?php echo htmlspecialchars($email ?? ''); ?>" type="text" name="email" id="email" size="30" placeholder="Please enter your email">
                              <ul class="user-entry-form__rules user-entry-form__rules--email">
                                   <li>
                                        <p>&nbsp e.g. me@mydomain.com</p>
                                   </li>
                              </ul>
                         </div>
                         <p class="user-entry-form__error-msg user-entry-form__error-msg--email"><?php echo $errorMessage['email']  ?? ''; ?></p>
                    </div>
                    <div class="user-entry-form__item-container">
                         <label class="user-entry-form__label" for="username">Username</label>
                         <div class="user-entry-form__item-wrapper">
                              <input class="user-entry-form__input user-entry-form__input--signup" value="<?php echo htmlspecialchars($username ?? ''); ?>" type="text" name="username" id="username" size="30" placeholder="Please enter your username">
                              <ul class="user-entry-form__rules user-entry-form__rules--username">
                                   <li>
                                        <p>* Contain 8 to 30 characters.</p>
                                   </li>
                              </ul>
                              <p class="user-entry-form__rules user-entry-form__rules--username"></p>
                         </div>
                         <p class="user-entry-form__error-msg user-entry-form__error-msg--username"><?php echo $errorMessage['username'] ?? ''; ?></p>
                    </div>
                    <div class="user-entry-form__item-container">
                         <label class="user-entry-form__label" for="password">Password</label>
                         <div class="user-entry-form__item-wrapper">
                              <input class="user-entry-form__input user-entry-form__input--signup" value="<?php echo htmlspecialchars($password ?? ''); ?>" type="password" name="password" id="password" size="30" placeholder="Please enter your password">
                              <ul class="user-entry-form__rules user-entry-form__rules--password">
                                   <li>
                                        <p>* Contain at least 8 characters.</p>
                                   </li>
                                   <li>
                                        <p>* Contain at least 1 number. (0-9)</p>
                                   </li>
                                   <li>
                                        <p>* Contain at least 1 lowercase character. (a-z)</p>
                                   </li>
                                   <li>
                                        <p>* Contain at least 1 uppercase character. (A-Z)</p>
                                   </li>
                              </ul>
                         </div>
                         <p class="user-entry-form__error-msg user-entry-form__error-msg--password"><?php echo $errorMessage['password'] ?? ''; ?></p>
                    </div>
                    <div class="user-entry-form__item-container">
                         <label class="user-entry-form__label" for="passwordRepeat">Confirm Password</label>
                         <div class="user-entry-form__item-wrapper">
                              <input class="user-entry-form__input user-entry-form__input--signup" value="<?php echo htmlspecialchars($passwordRepeat ?? ''); ?>" type="password" name="passwordRepeat" id="passwordRepeat" size="30" placeholder="Please confirm your password">
                         </div>
                         <p class="user-entry-form__error-msg user-entry-form__error-msg--passwordRepeat"><?php echo $errorMessage['passwordRepeat'] ?? ''; ?></p>
                    </div>
                    <button class="btn user-entry-form__btn" name="create" type="submit">Create</button>
               </form>
               <p class="user-entry-panel__text user-entry-panel__text--btn">Already have an account ?</p>
               <a class="user-entry-panel__link" href="signin.php">Sign in</a>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/signup.js"></script>
</body>

</html>