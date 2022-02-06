<?php

class SigninController extends SigninModel
{
     public function __construct($email, $password)
     {
          // Call construct method of the parent class (SigninModel).
          parent::__construct($email, $password);
     }

     public function signin()
     {
          return $this->validateInput();
     }
}
