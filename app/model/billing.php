<?php

namespace Model;

class billing extends \Config\DbConn
{
     private $orderId;
     private $firstName;
     private $lastName;
     private $phone;
     private $country;
     private $address;
     private $state;
     private $city;
     private $zipCode;

     protected function setBilling($orderID, $postData)
     {
          $this->orderId = $orderID;
          $this->firstName = $postData['firstName'];
          $this->lastName = $postData['lastName'];
          $this->phone = $postData['phone'];
          $this->country = $postData['country'];
          $this->address = $postData['address'];
          $this->state = $postData['state'];
          $this->city = $postData['city'];
          $this->zipCode = $postData['zipCode'];
     }

     protected function create()
     {
          $billingId = uniqid("B");

          $sql = "INSERT INTO billing_detail (
               billing_id, 
               order_id, 
               first_name, 
               last_name, 
               phone, 
               country, 
               `address`, 
               `state`, 
               city, 
               zip_code)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
          $stmt = $this->connect()->prepare($sql);

          // Error handler for statement execution.
          $this->executeStmt($stmt, [
               $billingId,
               $this->orderId,
               $this->firstName,
               $this->lastName,
               $this->phone,
               $this->country,
               $this->address,
               $this->state,
               $this->city,
               $this->zipCode
          ]);

          // Clear prepared statement.
          $stmt = null;
     }

     protected function read()
     {
     }

}
