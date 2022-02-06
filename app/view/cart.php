<?php
session_start();
require '../helper/setUserType.php';
include '../helper/autoloader.php';

$cartItem = new Controller\CartItem();
$product = new Controller\Product();

if (isset($_GET['addToCart'])) {
     $cartItem->addCartItem(
          $userInfo['user_id'],
          $_GET['productId'],
          $_GET['productSize'],
          $_GET['productQty']
     );
     // Remove get variable by relocating the page.
     header('Location: ' . $_SERVER['PHP_SELF']);
}

if (isset($_GET['action'])) {
     if ($_GET['action'] == 'delete') {
          $cartItem->deleteCartItem($_GET['cartItemId']);
     }
     exit();
}

if (isset($_POST['action'])) {
     if ($_POST['action'] == 'update') {
          $cartItem->updateCartItem($_POST['cartItemId'], $_POST['quantity']);
     }
     exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Cart - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="cart-main">
          <h2 class="cart-title">My cart</h2>
          <section class="cart-section">
               <table class="cart-table">
                    <thead>
                         <tr>
                              <th class="cart-table__head cart-table__head--product" colspan="2">Product</th>
                              <th class="cart-table__head">Price</th>
                              <th class="cart-table__head cart-table__head--quantity">Quantity</th>
                              <th class="cart-table__head cart-table__head--total-price">Total</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         $cartItems = $cartItem->getCartItem($userInfo['user_id']);
                         $subTotalPrice = 0;
                         ?>
                         <?php foreach ($cartItems as $cartItem) : ?>
                              <?php
                              $productInfo = $product->readProduct('product', $cartItem['product_id']);
                              $productStocks = $product->readProduct('productItem', $cartItem['product_id']);
                              $maxQuantity = 0;
                              foreach ($productStocks as $productStock) {
                                   if ($productStock['size'] == $cartItem['size']) {
                                        // Add maximum quantity for input if product still in stock.
                                        $maxQuantity = $productStock['quantity'];
                                        // Only count product that is still in stock for subtotal price.
                                        if ($productStock['quantity'] > 0) {
                                             $subTotalPrice += ($cartItem['quantity'] * $productInfo['price']);
                                        }
                                   }
                              }
                              // Force user previous cart item quantity to follow product stock.
                              if ($cartItem['quantity'] > $maxQuantity) {
                                   $cartItem['quantity'] = $maxQuantity;
                              }
                              ?>
                              <tr class="cart-table__row" data-cart-item-id="<?php echo htmlspecialchars($cartItem['cart_item_id']); ?>">
                                   <td class="cart-table__data cart-table__data--product-img">
                                        <img class="cart-product-img" src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']); ?>">
                                   </td>
                                   <td class="cart-table__data cart-table__data--product-info">
                                        <div class="cart-table__data-wrapper">
                                             <a href="productView.php?id=<?php echo htmlspecialchars($productInfo['product_id']) ?>"><?php echo htmlspecialchars($productInfo['name']); ?></a>
                                             <?php echo htmlspecialchars('Size: ' . $cartItem['size']); ?>
                                             <a class="cart-table__remove-link" data-cart-item-id="<?php echo htmlspecialchars($cartItem['cart_item_id']); ?>">Remove</a>
                                        </div>
                                   </td>
                                   <td class="cart-table__data cart-table__data--price">
                                        <p><?php echo htmlspecialchars('RM' . $productInfo['price']); ?></p>
                                   </td>
                                   <td class="cart-table__data cart-table__data--quantity">
                                        <?php if ($maxQuantity > 0) : ?>
                                             <input class="cart-table__input-quantity" type="number" data-cart-item-id="<?php echo htmlspecialchars($cartItem['cart_item_id']); ?>" value="<?php echo htmlspecialchars($cartItem['quantity']); ?>" id="productQty" name="productQty" min="1" max="<?php echo $maxQuantity; ?>" required>
                                        <?php elseif ($maxQuantity == 0) : ?>
                                             <p>Sold Out</p>
                                        <?php endif; ?>
                                   </td>
                                   <td class="cart-table__data cart-table__data--total-price">
                                        <?php echo htmlspecialchars('RM' . $productInfo['price'] * $cartItem['quantity']); ?>
                                   </td>
                              </tr>
                              <tr class="cart-table__row" data-cart-item-id="<?php echo htmlspecialchars($cartItem['cart_item_id']); ?>">
                                   <td class="cart-table__label cart-table__label--total-price" colspan="2">
                                        <b>Total:</b>
                                   </td>
                              </tr>
                         <?php endforeach; ?>
                         <tr class="cart-table__row">
                              <td class="cart-table__data cart-table__data--subtotal" colspan="5">
                                   <?php echo htmlspecialchars('Subtotal: RM' . $subTotalPrice); ?>
                              </td>
                         </tr>
                         <tr class="cart-table__row">
                              <td class="cart-table__data cart-table__data--checkout" colspan="5">
                                   <button class="btn check-out-btn">Check out</button>
                              </td>
                         </tr>
                    </tbody>
               </table>
          </section>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
     <script src="../../js/cart.js"></script>
</body>

</html>