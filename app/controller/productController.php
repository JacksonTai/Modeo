<?php

class ProductController extends ProductModel
{
     public function addProduct($postData, $filesData)
     {
          $this->setProduct($postData, $filesData);
          $this->create($postData['table'], $postData['productId']);
     }

     public function readProduct($table, $productId = null)
     {
          if ($productId) {
               return $this->read($table, $productId);
          }
          if (!$productId) {
               return $this->readAll($table);
          }
     }

     public function updateProduct($postData, $filesData)
     {
          $this->setProduct($postData, $filesData);
          $this->update($postData['table'], $postData['productId']);
     }

     public function deleteProduct($table, $productId, $productSize)
     {
          $this->delete($table, $productId, $productSize);
     }

     public function updateProductStock($checkoutItems) {
          $this->updateProductQty($checkoutItems);
     }
}
