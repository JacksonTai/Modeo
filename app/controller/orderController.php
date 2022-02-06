<?php

class OrderController extends OrderModel
{
     public function addOrder($userId, $orderItems, $paidAmount)
     {
          $this->setOrder($userId, $orderItems, $paidAmount);
          return $this->create();
     }
}
