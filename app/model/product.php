<?php

namespace Model;

class Product extends \config\dbConn
{
     private $productName;
     private $productDesc;
     private $productSize;
     private $productPrice;
     private $productQty;
     private $productImg;
     private $errorMessage = [
          'productName' => '',
          'productDesc' => '',
          'productSize' => '',
          'productPrice' => '',
          'productQty' => '',
          'productImg' => ''
     ];

     protected function setProduct($postData, $filesData = null)
     {
          // Set product properties.
          $this->productName = $postData['productName'] ?? null;
          $this->productDesc = $postData['productDesc'] ?? null;
          $this->productSize = $postData['productSize'] ?? null;
          $this->productPrice = $postData['productPrice'] ?? null;
          $this->productQty = $postData['productQty'] ?? null;
          $this->productImg = $filesData['productImg'] ?? null;
     }

     protected function create($table, $productId)
     {
          if ($table == 'product') {

               // Validation for all product input fields.
               $this->checkImgFormat();
               $this->checkEmptyInput();

               // Check if there is no empty or invalid input fields.
               if (!array_filter($this->errorMessage)) {

                    // Generate unique product ID.
                    $productId = uniqid('P');

                    // Encode image.
                    $encodedImgFile = $this->encodeImg();

                    $sql = "INSERT INTO product (product_id, name, description, price, image)
                            VALUES (?, ?, ?, ?, ?);";
                    $data = [
                         $productId,
                         $this->productName,
                         $this->productDesc,
                         $this->productPrice,
                         $encodedImgFile
                    ];
               }
          }

          if ($table == 'productItem') {

               $sql = "INSERT INTO product_item (product_id, size, quantity)
                       VALUES (?, ?, ?);";
               $data = [
                    $productId,
                    $this->productSize,
                    $this->productQty,
               ];
          }
          $stmt = $this->connect()->prepare($sql);

          // Statement execution error handler. 
          $this->executeStmt($stmt, $data);
          $stmt = null;

          return $this->errorMessage;
     }

     protected function read($table, $productId)
     {
          if ($table == 'product') {
               $sql = "SELECT * FROM product WHERE product_id = ?;";
          }

          if ($table == 'productItem') {
               $sql = "SELECT * FROM product_item WHERE product_id = ?;";
          }

          if ($table == 'productWithQty') {
               $sql = "SELECT * FROM product p 
                       INNER JOIN product_item pq ON p.product_id = pq.product_id
                       WHERE p.product_id = ?;";
          }

          $stmt = $this->connect()->prepare($sql);

          $this->executeStmt($stmt, [$productId]);

          if ($table == 'product') {
               $productInfo = $stmt->fetch();
               $stmt = null;
               return $productInfo;
          }
          $productInfo = $stmt->fetchAll();
          $stmt = null;
          return $productInfo;
     }

     protected function readAll($table)
     {
          if ($table == 'product') {
               $sql = "SELECT * FROM product;";
          }

          if ($table == 'productItem') {
               $sql = "SELECT * FROM product_item;";
          }

          if ($table == 'productWithQty') {
               $sql = "SELECT * FROM product p 
                       INNER JOIN product_item pq ON p.product_id = pq.product_id;";
          }
          $stmt = $this->connect()->prepare($sql);

          $this->executeStmt($stmt);

          $productInfo = $stmt->fetchAll();

          $stmt = null;
          return $productInfo;
     }

     protected function update($table, $productId)
     {
          if ($table == 'product') {
               // Update product image only if the is uploaded successfully.
               if ($this->productImg['error'] == 0) {
                    // Encode image.
                    $encodedImgFile = $this->encodeImg();

                    $sql = "UPDATE product SET name = ?, description = ?, price = ?, image = ? 
                            WHERE product_id = ?;";
                    $data = [
                         $this->productName,
                         $this->productDesc,
                         $this->productPrice,
                         $encodedImgFile,
                         $productId
                    ];
               } else {
                    $sql = "UPDATE product SET name = ?, description = ?, price = ?
                            WHERE product_id = ?;";
                    $data = [
                         $this->productName,
                         $this->productDesc,
                         $this->productPrice,
                         $productId
                    ];
               }
          }

          if ($table == 'productItem') {
               $sql = "UPDATE product_item SET quantity = ? 
                       WHERE size = ? AND product_id = ?;";
               $data = [
                    $this->productQty,
                    $this->productSize,
                    $productId
               ];
          }
          $stmt = $this->connect()->prepare($sql);

          // Statement execution error handler. 
          $this->executeStmt($stmt, $data);
          $stmt = null;
     }

     protected function updateProductQty($checkoutItems)
     {
          $product = new \Controller\Product();
          foreach ($checkoutItems as $checkoutItem) {
               $productStocks = $product->readProduct(
                    'productItem',
                    $checkoutItem['product_id']
               );
               foreach ($productStocks as $productStock) {
                    if (
                         $checkoutItem['product_id'] == $productStock['product_id']
                         && $checkoutItem['size'] == $productStock['size']
                    ) {
                         $remainingStock = $productStock['quantity'] - $checkoutItem['quantity'];
                         $this->setProduct(
                              [
                                   'productSize' => $checkoutItem['size'],
                                   'productQty' => $remainingStock
                              ]
                         );
                         $this->update('productItem', $checkoutItem['product_id']);
                    }
               };
          }
     }

     protected function delete($table, $productId, $productSize)
     {
          if ($table == 'product') {
               $sql = "DELETE FROM product WHERE product_id = ?;";
               $data = [$productId];
          }

          if ($table == 'productItem') {
               $sql = "DELETE FROM product_item WHERE product_id = ? 
                       AND size = ?;";
               $data = [$productId, $productSize];
          }

          if ($table == 'productWithQty') {
               $sql = "DELETE FROM product_item WHERE product_id = ?;
                       DELETE FROM product WHERE product_id = ?;";
               $data = [$productId, $productId];
          }

          $stmt = $this->connect()->prepare($sql);

          $this->executeStmt($stmt, $data);

          $stmt = null;
     }

     private function checkImgFormat()
     {
          // Acceptable image format.
          $allowFormat = ['jpg', 'png', 'jpeg'];
          // if ($this->productImg)
     }

     private function checkEmptyInput()
     {
          if ($this->productName && empty($this->productName)) {
               $this->errorMessage['productName'] = '* Name is a required field.';
          }
          if ($this->productDesc && empty($this->productDesc)) {
               $this->errorMessage['productDesc'] = '* Description is a required field.';
          }
          if ($this->productSize && empty($this->productSize)) {
               $this->errorMessage['productSize'] = '* Size is a required field.';
          }
          if ($this->productPrice && empty($this->productPrice)) {
               $this->errorMessage['productPrice'] = '* Price is a required field.';
          }
          if ($this->productQty && empty($this->productQty)) {
               $this->errorMessage['productQty'] = '* Quantity is a required field.';
          }
          if ($this->productImg && $this->productImg['size'] === 0) {
               $this->errorMessage['productImg'] = '* Image is required.';
          }
     }

     // Get encoded image file.
     private function encodeImg()
     {
          // Convert image file into string.
          $productImgStr = file_get_contents($this->productImg['tmp_name']);

          // Encode image.
          $encodedImgFile = base64_encode($productImgStr);

          return $encodedImgFile;
     }
}
