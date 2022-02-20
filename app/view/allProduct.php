<?php
session_start();
require '../helper/setUserType.php';
include '../helper/autoloader.php';
$product = new controller\product();
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Products - Modeo</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="all-product-main">
          <h2 class="all-product__title">Products</h2>
          <div class="all-product__container">
               <?php $productInfos = $product->readProduct('product'); ?>
               <?php foreach ($productInfos as $productInfo) : ?>
                    <?php
                    $productItems = $product->readProduct('productItem', $productInfo['product_id']);
                    $productInStock = false;
                    foreach ($productItems as $productItem) {
                         if ($productItem['quantity'] > 0) {
                              $productInStock = true;
                              break;
                         }
                    }
                    ?>

                    <div class="all-product__item">
                         <a class="all-product__link" href="product.php?id=<?php echo htmlspecialchars($productInfo['product_id']); ?>">
                              <img class="all-product__item-img" src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']) ?>">
                              <p class="all-product__item-name"><?php echo htmlspecialchars($productInfo['name']); ?></p>
                              <?php if ($productInStock) : ?>
                                   <p class="all-product__item-price"><?php echo 'RM' . htmlspecialchars($productInfo['price']); ?></p>
                              <?php elseif (!$productInStock) : ?>
                                   <p class="all-product__item-price">Sold out</p>
                              <?php endif; ?>
                         </a>
                    </div>
               <?php endforeach; ?>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
</body>

</html>