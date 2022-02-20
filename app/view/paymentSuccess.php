<?php
session_start();
require '../helper/setUserType.php';
require '../helper/redirector.php';
include '../helper/autoloader.php';
$payment = $_SESSION['payment'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Payment Successfull - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="payment-success-main">
          <div class="payment-success__panel">
               <div class="payment-success__panel-header">
                    <h2 class="payment-success__title">Payment Successfull!</h2>
                    <img class="payment-success-icon" src="../../img/icons/done.jpg" alt="">
               </div>
               <div class="payment-success__panel-body">
                    <div class="payment-success__item">
                         <p class="payment-success__label">Paid by: </p>
                         <p class="payment-success__content">Bank Card</p>
                    </div>
                    <div class="payment-success__item">
                         <p class="payment-success__label">Payment Date: </p>
                         <p class="payment-success__content"><?php echo htmlspecialchars($payment['date']); ?></p>
                    </div>
                    <div class="payment-success__item">
                         <p class="payment-success__label">Payment Time: </p>
                         <p class="payment-success__content"><?php echo htmlspecialchars($payment['time']); ?></p>
                    </div>
                    <div class="payment-success__item">
                         <p class="payment-success__label">Amount paid: </p>
                         <p class="payment-success__content"><?php echo htmlspecialchars('RM' . $payment['totalPrice']); ?></p>
                    </div>
                    <div class="payment-success__item">
                         <p class="payment-success__label">Customer id: </p>
                         <p class="payment-success__content"><?php echo htmlspecialchars($userInfo['user_id']); ?></p>
                    </div>
                    <div class="payment-success__item">
                         <p class="payment-success__label">Order id: </p>
                         <p class="payment-success__content"><?php echo htmlspecialchars($payment['orderId']); ?></p>
                    </div>
               </div>
               <a class="btn payment-done-btn" href="../../index.php">Done</a>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
</body>

</html>