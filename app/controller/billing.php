<?php

namespace Controller;

class Billing extends \model\billing
{
     public function addBilling($orderId, $postData)
     {
          $this->setBilling($orderId, $postData);
          $this->create();
     }

     public function readBilling($orderId)
     {
          return $this->read($orderId);
     }
}
