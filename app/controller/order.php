<?php

namespace Controller;

class Order extends \model\order
{
     public function addOrder($userId, $orderItems, $paidAmount)
     {
          $this->setOrder($userId, $orderItems, $paidAmount);
          return $this->create();
     }

     public function readOrder($basedOn, $userId)
     {
          return $this->read($basedOn, $userId);
     }
}
