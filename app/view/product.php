<?php
session_start();
require '../helper/setUserType.php';
include '../helper/autoloader.php';

$product = new controller\product();
$productInfo = $product->readProduct('product', $_GET['id'] ?? null);
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title><?php echo htmlspecialchars($productInfo['name']); ?> - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="product-main">
          <img class="product-img" src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']) ?>">
          <div class="product-content-container">

               <h2 class="product-name"><?php echo htmlspecialchars($productInfo['name']); ?></h2>
               <p class="product-price"><?php echo htmlspecialchars('RM' . $productInfo['price']); ?></p>
               <p class="product-description"><?php echo htmlspecialchars($productInfo['description']); ?></p>

               <?php
               $productItems = $product->readProduct('productItem', $_GET['id']);
               $productInStock = false;
               foreach ($productItems as $productItem) {
                    if ($productItem['quantity'] > 0) {
                         $productInStock = true;
                         break;
                    }
               }
               ?>

               <?php if ($productInStock) : ?>

                    <form class="add-to-cart-form" action="cart.php">
                         <div class="add-to-cart-form__item-container">
                              <label for="productSize">Size:</label>
                              <select class="product-size" name="productSize" id="productSize">

                                   <?php foreach ($productItems as $productItem) : ?>
                                        <?php if ($productItem['quantity'] > 0) : ?>
                                             <option value="<?php echo htmlspecialchars($productItem['size']); ?>">
                                                  <?php echo htmlspecialchars($productItem['size'] . ' (EU)'); ?>
                                             </option>
                                        <?php endif; ?>
                                   <?php endforeach; ?>

                              </select>
                              <label for="productQty">Quantity:</label>
                              <input type="number" name="productQty" id="productQty" value="1" min="1" required>
                              <input type="hidden" name="productId" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                         </div>
                         <div class="add-to-cart-form__btn-container">

                              <?php if ($userType == 'normal') : ?>

                                   <button class="btn add-to-cart-btn" type="submit" name="addToCart">Add to cart</button>

                              <?php elseif ($userType == 'guest') : ?>

                                   <a class="btn add-to-cart-btn" href="signin.php">Add to cart</a>

                              <?php endif; ?>

                         </div>
                    </form>

               <?php elseif (!$productInStock) : ?>

                    <p class="product-status">Sold out</p>

               <?php endif; ?>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
</body>

</html>