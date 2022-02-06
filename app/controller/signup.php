<?php

namespace Controller;

class Signup extends \Model\Signup
{
     public function __construct($postData)
     {
          // Call construct method of the parent class (SignupModel).
          parent::__construct($postData);
     }

     public function signup()
     {
          return $this->validateInput();
     }
}
