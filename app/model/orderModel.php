<?php

class OrderModel extends DbConfig
{
     private $userId;
     private $orderItems;
     private $paidAmount;

     protected function setOrder($userId, $orderItems, $paidAmount)
     {
          $this->userId = $userId;
          $this->orderItems = $orderItems;
          $this->paidAmount = $paidAmount;
     }

     protected function create()
     {
          // Generate unique order ID.
          $orderId = uniqid('O');

          // Set default datetime zone (Malaysia).
          date_default_timezone_set("Asia/Kuala_Lumpur");
          $date = date('Y-m-d');
          $time = date('H:i:s');

          $sql = "INSERT INTO `order` (order_id, `user_id`, order_date, order_time, paid_amount)
                       VALUES (?, ?, ?, ?, ?);";
          $data = [$orderId, $this->userId, $date, $time, $this->paidAmount];

          $stmt = $this->connect()->prepare($sql);
          $this->executeStmt($stmt, $data);

          // Order items insertion.
          $sql = "INSERT INTO `order_item` (order_item_id, order_id, product_id, size, quantity)
                  VALUES (?, ?, ?, ?, ?);";

          foreach ($this->orderItems as $orderItem) {
               // Generate unique order item ID.
               $orderItemId = uniqid('OI');

               $data = [
                    $orderItemId,
                    $orderId,
                    $orderItem['product_id'],
                    $orderItem['size'],
                    $orderItem['quantity']
               ];

               $stmt = $this->connect()->prepare($sql);
               $this->executeStmt($stmt, $data);
          }
          return ['orderId' => $orderId, 'orderDate' => $date, 'orderTime' => $time];
     }
}
