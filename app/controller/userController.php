<?php 

class UserController extends UserModel {
     
     public function getUser($type) {
          $this->readUser($type);
     }

}