<?php
session_start();
require 'app/helper/setUserType.php';
include 'app/helper/autoloader.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'templates/head.php' ?>
    <title>
        <?php
        $userType == 'admin' ? $title = 'Modeo (Admin)' : $title = 'Modeo | Shoes - Men & Women';
        echo $title;
        ?>
    </title>
</head>

<body>

    <?php include 'templates/header.php' ?>

    <?php if ($userType == 'guest' || $userType == 'normal') : ?>

        <main class="index-main">
            <section class="index-section index-section--home" id="index-home">
                <img class="index-home__hero-img" src="img/home.png" alt="Poster">
                <div class="index-home__intro-container">
                    <h2 class="index-title index-title--home">
                        The sneaker makes the <span class="index-title-highlighted">man.</span>
                    </h2>
                    <p class="index-home__content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum cumque nesciunt rspiciatis nisi
                        consequuntur eum? Voluptate.
                        <?php echo htmlspecialchars($userInfo['username'] ?? ''); ?>
                    </p>
                    <a class="btn index-home__cta-btn" href="#index-product">Discover</a>
                </div>
            </section>
            <section class="index-section index-section--product" id="index-product">
                <h2 class="index-title index-title--product">Product</h2>
                <div class="index-product__container">
                    <?php
                    $product = new ProductController();
                    $productInfos = $product->readProduct('product');
                    ?>
                    <!-- Display only the first six products.  -->
                    <?php foreach (array_slice($productInfos, 0, 6) as $productInfo) : ?>

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

                        <div class="index-product__item">
                            <a href="app/view/productView.php?id=<?php echo htmlspecialchars($productInfo['product_id']); ?>">

                                <img src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']) ?>">
                                <p class="index-product__item-name"><?php echo htmlspecialchars($productInfo['name']); ?></p>

                                <?php if ($productInStock) : ?>

                                    <p class="index-product__item-price"><?php echo 'RM' . htmlspecialchars($productInfo['price']); ?></p>

                                <?php elseif (!$productInStock) : ?>

                                    <p class="index-product__item-price">Sold out</p>

                                <?php endif; ?>

                            </a>
                        </div>

                    <?php endforeach; ?>
                </div>

                <?php if (count($productInfos) > 6) : ?>

                    <a class="index-product__cta-btn" href="app/view/allProductView.php">See more</a>

                <?php endif; ?>

            </section>
            <section class="index-section index-section--about" id="index-about">
                <h2 class="index-title">About Modeo</h2>
                <div class="index-about__container">
                    <p class="index-about__content">We dress a generation of urban professionals, creatives and innovators that need functional yet modern
                        products for their everyday lives. We have sold more than 200K pairs. We have customers in more than
                        40 countries. We sell in more than 212 shops all around the globe.</p>
                    <img class="index-about__img" src="img/about.jpg" alt="">
                </div>
            </section>
            <!-- <section class="index-section index-section--contact" id="index-contact">
            <h2 class="index-title">Get in touch</h2>
            <p></p>
            <form action="">
                
            </form>
        </section> -->
        </main>

    <?php elseif ($userType == 'admin') : ?>

        <main class="index-main index-main--admin">
            <section class="index-section index-section--home-admin">
                <div class="index-panel">
                    <h2 class="index-panel__title">
                        <a href="app/view/manageProductView.php">Manage products</a>
                    </h2>
                </div>
                <div class="index-panel">
                    <h2 class="index-panel__title">
                        <a href="app/view/manageUserView.php">Manage users</a>
                    </h2>
                </div>
            </section>
        </main>
    <?php endif; ?>

    <?php include 'templates/footer.php' ?>
    <script src="js/script.js"></script>
</body>

</html>