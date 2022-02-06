<?php

namespace Controller;

class Order extends \Model\Order
{
     public function addOrder($userId, $orderItems, $paidAmount)
     {
          $this->setOrder($userId, $orderItems, $paidAmount);
          return $this->create();
     }
}
