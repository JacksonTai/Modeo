<?php

namespace Model;
use Controller;

class CartItem extends \config\dbConn
{
     private $userId;
     private $productId;
     private $productSize;
     private $productQty;

     protected function setCartItem($userId, $productId, $productSize, $productQty)
     {
          $this->userId = $userId;
          $this->productId = $productId;
          $this->productSize = $productSize;
          $this->productQty = $productQty;
     }

     protected function create()
     {
          // Generate unique cart item ID.
          $cartItemId = uniqid('C');

          $sql = "INSERT INTO cart_item (cart_item_id, user_id, product_id, size, quantity)
                  VALUES (?, ?, ?, ?, ?);";
          $data = [
               $cartItemId,
               $this->userId,
               $this->productId,
               $this->productSize,
               $this->productQty
          ];

          $stmt = $this->connect()->prepare($sql);
          $this->executeStmt($stmt, $data);
     }

     protected function read($userId)
     {
          $sql = "SELECT * FROM cart_item
                  WHERE user_id = ?;";
          $stmt = $this->connect()->prepare($sql);
          $this->executeStmt($stmt, [$userId]);

          $cartItem = $stmt->fetchAll();
          $stmt = null;
          return $cartItem;
     }

     protected function update($cartItemId, $quantity)
     {
          $sql = "UPDATE cart_item SET quantity = ?
                  WHERE cart_item_id = ?;";
          $stmt = $this->connect()->prepare($sql);
          $this->executeStmt($stmt, [$quantity, $cartItemId]);

          $stmt = null;
     }

     protected function delete($cartItemId)
     {
          $sql = "DELETE FROM cart_item WHERE cart_item_id = ?;";
          $stmt = $this->connect()->prepare($sql);
          $this->executeStmt($stmt, [$cartItemId]);

          $stmt = null;
     }

     protected function obtainCheckoutInfo($userId)
     {
          $product = new Controller\Product();

          $cartItems = $this->read($userId);

          $checkoutItems = [];
          $totalPrice = 0;
  
          foreach ($cartItems as $cartItem) {
               $productStocks = $product->readProduct('productItem', $cartItem['product_id']);
               $productInfo = $product->readProduct('product', $cartItem['product_id']);

               foreach ($productStocks as $productStock) {
                    // Match cart item product with product in stock.
                    if (
                         $cartItem['product_id'] == $productStock['product_id'] &&
                         $cartItem['size'] == $productStock['size']
                    ) {
                         // Only calculate(total price) and add product that is still in stock.
                         if ($productStock['quantity'] > 0) {
                              $totalPrice += ($cartItem['quantity'] * $productInfo['price']);
                              array_push($checkoutItems, array_merge($cartItem, $productInfo));
                         }
                    }
               }
          }

          return ['totalPrice' => $totalPrice, 'checkoutItems' => $checkoutItems];
     }
}
