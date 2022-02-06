<?php
session_start();
require '../helper/setUserType.php';
include '../helper/autoloader.php';

// Instantiate product object.
$product = new ProductController();

// Http request through Ajax.
if (isset($_POST['action'])) {

     if ($_POST['action'] == 'add') {
          $errorMessage = $product->addProduct($_POST, $_FILES);
     }

     if ($_POST['action'] == 'update') {
          $product->updateProduct($_POST, $_FILES);
     }
     exit();
}

if (isset($_GET['action'])) {

     $table = $_GET['table'] ?? null;
     $productId = $_GET['productId'] ?? null;
     $productSize = $_GET['productSize'] ?? null;

     if ($_GET['action'] == 'get') {
          $selectedProduct = $product->readProduct($table, $productId);
          echo json_encode($selectedProduct);
     }

     if ($_GET['action'] == 'delete') {
          $product->deleteProduct($table, $productId, $productSize);
     }
     exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <?php include '../../templates/head.php' ?>
     <title>Modeo(Admin) - Manage Product</title>
</head>

<body>

     <?php include '../../templates/header.php' ?>

     <main class="manage-product-main">
          <section class="manage-product-section">
               <h2 class="manage-product-title">Manage Product</h2>
               <div class="manage-product__container">
                    <div class="manage-product__item manage-product__item--add">
                         <img src="../../img/icons/add.jpg" alt="Add product">
                         <p class="manage-product__item-content manage-product__item-content--add">Add Product</p>
                    </div>
                    <?php $productInfos = $product->readProduct('product'); ?>
                    <?php foreach ($productInfos as $productInfo) : ?>
                         <div class="manage-product__item">
                              <div class="manage-product__item-btn-container">
                                   <button class="manage-product__item-btn manage-product__item-btn--update" value="<?php echo $productInfo['product_id']; ?>">
                                        <img src="../../img/icons/edit.jpg" alt="Edit">
                                   </button>
                                   <button class="manage-product__item-btn manage-product__item-btn--delete" value="<?php echo $productInfo['product_id']; ?>">
                                        <img src="../../img/icons/trash.jpg" alt="Delete">
                                   </button>
                              </div>
                              <img class="manage-product__item-image" src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']); ?>">
                              <div class="manage-product__item-content-container">
                                   <p class="manage-product__item-content"><span>Id: </span><?php echo htmlspecialchars($productInfo['product_id']); ?></p>
                                   <p class="manage-product__item-content"><span>Name: </span><?php echo htmlspecialchars($productInfo['name']); ?></p>
                                   <p class="manage-product__item-content"><span>Price: </span><?php echo 'RM' . htmlspecialchars($productInfo['price']); ?></p>
                              </div>
                              <button class="btn manage-product__item-manage-btn" value="<?php echo $productInfo['product_id']; ?>">Manage</button>
                         </div>
                    <?php endforeach; ?>
               </div>
          </section>
          <!-- Modal section -->
          <div class="modal-overlay modal-overlay--add-product">
               <div class="modal modal--add-product">
                    <header class="modal__header modal__header--add-product">
                         <button class="modal__close-btn">&#10006;</button>
                         <h2 class="modal__title">Add product</h2>
                    </header>
                    <form class="manage-product-form manage-product-form--add-product" enctype="multipart/form-data">
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productName">Name:</label>
                              <input class="manage-product-form__input" type="text" value="<?php echo htmlspecialchars($productName ?? ''); ?>" name="productName" id="productName" placeholder="Please enter product name">
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productName']  ?? ''; ?></p>
                         </div>
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productDesc">Description:</label>
                              <textarea class="manage-product-form__input" value="<?php echo htmlspecialchars($productDesc ?? ''); ?>" name="productDesc" id="productDesc" cols="23" rows="10" placeholder="Describe the product here..."></textarea>
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productDesc']  ?? ''; ?></p>
                         </div>
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productPrice">Price (RM):</label>
                              <input class="manage-product-form__input" type="number" value="<?php echo htmlspecialchars($productPrice ?? ''); ?>" name="productPrice" id="productPrice" placeholder="Please enter product price" min="0" step="0.01">
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productPrice']  ?? ''; ?></p>
                         </div>
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productPrice">Image:</label>
                              <input class="manage-product-form__input" type="file" name="productImg" id="productImg">
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productImg']  ?? ''; ?></p>
                         </div>
                         <button class="btn manage-product-form__btn" name="addProduct" type="submit">Add product</button>
                    </form>
               </div>
          </div>
          <div class="modal-overlay modal-overlay--update-product">
               <div class="modal modal--update-product">
                    <header class="modal__header modal__header--update-product">
                         <button class="modal__close-btn">&#10006;</button>
                         <h2 class="modal__title">Update product</h2>
                    </header>
                    <form class="manage-product-form manage-product-form--update-product" enctype="multipart/form-data">
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productName">Name:</label>
                              <input class="manage-product-form__input" type="text" value="<?php echo htmlspecialchars($productName ?? ''); ?>" name="productName" id="productName" placeholder="Please enter product name">
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productName']  ?? ''; ?></p>
                         </div>
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productDesc">Description:</label>
                              <textarea class="manage-product-form__input" value="<?php echo htmlspecialchars($productDesc ?? ''); ?>" name="productDesc" id="productDesc" cols="23" rows="10" placeholder="Describe the product here..."></textarea>
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productDesc']  ?? ''; ?></p>
                         </div>
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productPrice">Price (RM):</label>
                              <input class="manage-product-form__input" type="number" value="<?php echo htmlspecialchars($productPrice ?? ''); ?>" name="productPrice" id="productPrice" placeholder="Please enter product price" min="0" step="0.01">
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productPrice']  ?? ''; ?></p>
                         </div>
                         <div class="manage-product-form__item-container">
                              <label class="manage-product-form__label" for="productPrice">Image:</label>
                              <input class="manage-product-form__input" type="file" name="productImg" id="productImg">
                              <p class="manage-product-form__error-msg"><?php echo $errorMessage['productImg']  ?? ''; ?></p>
                         </div>
                         <button class="btn modal__update-product-btn" name="updateProduct" type="submit">Update product</button>
                    </form>
               </div>
          </div>
          <div class="modal-overlay modal-overlay--delete-product">
               <div class="modal modal--delete-product">
                    <header class="modal__header modal__header--delete-product">
                         <button class="modal__close-btn">&#10006;</button>
                         <h2 class="modal__title">Delete Product</h2>
                         <p class="modal__message">Are you sure you want to delete this product?</p>
                    </header>
                    <img class="modal__delete-img">
                    <div class="modal__delete-info-container">
                         <p class="modal__delete-info"><span>Id: </span></p>
                         <p class="modal__delete-info"><span>Name: </span></p>
                         <p class="modal__delete-info"><span>Price: </span></p>
                    </div>
                    <button class="btn modal__delete-product-btn">Delete</button>
               </div>
          </div>
          <div class="modal-overlay modal-overlay--manage-product">
               <div class="modal modal--manage-product">
                    <header class="modal__header modal__header--manage-product">
                         <button class="modal__close-btn">&#10006;</button>
                         <h2 class="modal__title">Manage Product</h2>
                    </header>
                    <form class="manage-product-form manage-product-form--add-product-item">
                         <input type="number" name="productSize" placeholder="Size (EU)" min="36" max="48">
                         <input type="number" name="productQty" placeholder="Quantity" min="0">
                         <button class="add-product-item-btn" type="submit">
                              <img src="../../img/icons/add.jpg" alt="Add">
                         </button>
                    </form>
                    <form class="manage-product-form manage-product-form--manage-product"></form>
               </div>
          </div>
     </main>

     <?php include '../../templates/footer.php' ?>
     <script src="../../js/script.js"></script>
     <script src="../../js/manageProduct.js"></script>
</body>

</html>