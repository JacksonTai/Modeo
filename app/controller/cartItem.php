<?php

namespace Controller;

class CartItem extends \model\cartItem
{
     public function addCartItem($userId, $productId, $productSize, $productQty)
     {
          $this->setCartItem($userId, $productId, $productSize, $productQty);
          $this->create();
     }

     public function getCartItem($userId)
     {
          return $this->read($userId);
     }

     public function updateCartItem($cartItemId, $quantity)
     {
          $this->update($cartItemId, $quantity);
     }

     public function deleteCartItem($cartItemId)
     {
          $this->delete($cartItemId);
     }

     public function getCheckoutInfo($userId)
     {
          return $this->obtainCheckoutInfo($userId);
     }
}
