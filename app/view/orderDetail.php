<?php
session_start();
require '../helper/setUserType.php';
require '../helper/redirector.php';
include '../helper/autoloader.php';
$order = new controller\order();
$orderInfo = $order->readOrder('orderItemId', $_GET['id']);
$product = new controller\product();
$productInfo = $product->readProduct('product', $orderInfo['product_id']);
$billing = new controller\billing();
$billingInfo = $billing->readBilling($orderInfo['order_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Order Details - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="order-detail-main">
          <h2 class="order-detail__title">Order Details</h2>
          <a class="order-detail__back-btn" href="orderHistory.php">&lt; Back</a>
          <div class="order-detail__dialog">
               <div class="order-detail__upper-content">
                    <img class="order-detail__img" src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']); ?>">
                    <div class="order-detail__info-container">
                         <p class="order-detail__info">
                              <?php echo htmlspecialchars($productInfo['name']); ?>
                         </p>
                         <p class="order-detail__info">
                              Size:
                              <?php echo htmlspecialchars($orderInfo['size']); ?>
                         </p>
                         <p class="order-detail__info">
                              Price: RM
                              <?php echo htmlspecialchars($productInfo['price']); ?>
                         </p>
                         <p class="order-detail__info">
                              Quantity:
                              <?php echo htmlspecialchars($orderInfo['quantity']); ?>
                         </p>
                    </div>
               </div>
               <div class="order-detail__lower-content">
                    <p class="order-detail__order-total">Order Total:
                         <?php echo htmlspecialchars('RM' . $orderInfo['quantity'] * $productInfo['price']); ?>
                    </p>
                    <button class="btn buy-again-btn" onclick="window.location.href='product.php?id=<?php echo htmlspecialchars($orderInfo['product_id']); ?>'">Buy again</button>
               </div>
               <h3 class="order-detail__delivery-title">Delivery Information</h3>
               <div class="order-detail__delivery-content-container">
                    <?php
                    // print_r($orderInfo);
                    $fullName = $billingInfo['first_name'] . ' ' .  $billingInfo['last_name'];
                    $contactNo = $billingInfo['phone'];
                    ?>
                    <div class="order-detail__delivery-content">
                         <p class="order-detail__delivery-full-name"><?php echo htmlspecialchars($fullName); ?></p>
                         <p class="order-detail__delivery-contact"><?php echo htmlspecialchars($contactNo); ?></p>
                         <p class="order-detail__delivery-address"><?php echo htmlspecialchars($billingInfo['address'] . ','); ?></p>
                         <p class="order-detail__delivery-city-zip"><?php echo htmlspecialchars($billingInfo['city'] . ', ' . $billingInfo['zip_code'] . ','); ?></p>
                         <p class="order-detail__delivery-state-country"><?php echo htmlspecialchars($billingInfo['state'] . ', ' . $billingInfo['country']); ?></p>
                    </div>
                    <div class="order-detail__delivery-content">
                         <p class="order-detail__date"><?php echo htmlspecialchars('Order Date: ' . $orderInfo['order_date']); ?></p>
                         <p class="order-detail__time"><?php echo htmlspecialchars('Order Time: ' . $orderInfo['order_time'] . '(UTC+8)'); ?></p>
                         <p class="order-detail__id"><?php echo htmlspecialchars('Order Id: ' . $orderInfo['order_id']); ?></p>
                    </div>
               </div>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
</body>

</html>