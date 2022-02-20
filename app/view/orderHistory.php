<?php
session_start();
require '../helper/setUserType.php';
require '../helper/redirector.php';
include '../helper/autoloader.php';
$order = new controller\order();
$product = new controller\product();
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Order History - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="order-history-main">
          <?php $orderInfos = $order->readOrder('userId', $userInfo['user_id']); ?>
          <h2 class="order-history__title">Order History</h2>
          <div class="order-history__item-container">
               <?php if (!$orderInfos) :  ?>
                    <div class="no-order-content">
                         <img class="no-order__img" src="../../img/noOrder.jpg" alt="">
                         <h3 class="no-order__title">No Orders</h3>
                         <p class="no-order__msg">You haven’t made any orders yet</p>
                    </div>
               <?php else : ?>
                    <?php foreach ($orderInfos as $orderInfo) : ?>
                         <?php
                         $productInfo = $product->readProduct('product', $orderInfo['product_id']);
                         ?>
                         <div class="order-history__item">
                              <?php if ($productInfo) : ?>
                                   <div class="order-history__item-upper-content" data-order-item-id="<?php echo htmlspecialchars($orderInfo['order_item_id']) ?>">
                                        <img class="order-history__item-img" src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']); ?>">
                                        <div class="order-history__item-info-container">
                                             <p class="order-history__item-info">
                                                  <?php echo htmlspecialchars($productInfo['name']); ?>
                                             </p>
                                             <p class="order-history__item-info">
                                                  Size:
                                                  <?php echo htmlspecialchars($orderInfo['size']); ?>
                                             </p>
                                             <p class="order-history__item-info">
                                                  Price: RM
                                                  <?php echo htmlspecialchars($productInfo['price']); ?>
                                             </p>
                                             <p class="order-history__item-info">
                                                  Quantity:
                                                  <?php echo htmlspecialchars($orderInfo['quantity']); ?>
                                             </p>
                                        </div>
                                   </div>
                                   <div class="order-history__item-lower-content">
                                        <p class="order-history__order-total">Order Total:
                                             <?php echo htmlspecialchars('RM' . $orderInfo['quantity'] * $productInfo['price']); ?>
                                        </p>
                                        <button class="btn buy-again-btn" onclick="window.location.href='product.php?id=<?php echo htmlspecialchars($orderInfo['product_id']); ?>'">Buy again</button>
                                   </div>
                              <?php else : ?>
                                   <p class="order-history__empty-msg">Uh oh! Product Info not found.</p>
                              <?php endif; ?>
                         </div>
                    <?php endforeach; ?>
               <?php endif; ?>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
     <script src="../../js/orderHistory.js"></script>

</body>

</html>