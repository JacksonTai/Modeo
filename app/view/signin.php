<?php
include '../helper/autoLoader.php';

if (isset($_POST['signin'])) {
     $email = $_POST['email'];
     $password = $_POST['password'];

     // Instantiate a user object and run signin method.
     $user = new Controller\Signin($email, $password);
     $errorMessage = $user->signin();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Sign in - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="user-entry-main">
          <div class="user-entry-panel">
               <h2 class="user-entry-panel__title">Sign in</h2>
               <form class="user-entry-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="user-entry-form__item-container">
                         <label class="user-entry-form__label" for="email">Email address</label>
                         <input class="user-entry-form__input user-entry-form__input--signin" value="<?php echo htmlspecialchars($email ?? ''); ?>" type="text" name="email" id="email" size="23" placeholder="Please enter your email">
                         <p class="user-entry-form__error-msg user-entry-form__error-msg--email"><?php echo $errorMessage['email']  ?? ''; ?></p>
                    </div>
                    <div class="user-entry-form__item-container">
                         <label class="user-entry-form__label" for="password">Password</label>
                         <input class="user-entry-form__input user-entry-form__input--signin" value="<?php echo htmlspecialchars($password ?? ''); ?>" type="password" name="password" id="password" size="23" placeholder="Please enter your password">
                         <p class="user-entry-form__error-msg user-entry-form__error-msg--password"><?php echo $errorMessage['password']  ?? ''; ?></p>
                    </div>
                    <button class="btn user-entry-form__btn" name="signin" type="submit">Sign in</button>
               </form>
               <p class="user-entry-panel__text user-entry-panel__text--btn">Don't have an account ?</p>
               <a class="user-entry-panel__link" href="signup.php">Create a new one</a>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/signin.js"></script>
</body>

</html>