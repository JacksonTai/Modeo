<?php

namespace Controller;

class Order extends \model\order
{
     public function addOrder($userId, $orderItems, $paidAmount)
     {
          $this->setOrder($userId, $orderItems, $paidAmount);
          return $this->create();
     }
}
