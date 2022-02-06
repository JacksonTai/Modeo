<?php

namespace Controller;

class billing extends \Model\billing
{
     public function addBilling($orderId, $postData)
     {
          $this->setBilling($orderId, $postData);
          $this->create();
     }

     public function getBilling($userId = null, $orderId = null)
     {
          return $this->read($userId, $orderId);
     }
}
