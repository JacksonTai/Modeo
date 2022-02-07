<?php

namespace Model;

class Signin extends \config\dbConn
{
     private $email;
     private $password;
     private $errorMessage = [
          'email' => '',
          'password' => ''
     ];

     public function __construct($email, $password)
     {
          $this->email = $email;
          $this->password = $password;
     }

     // Main function for signin process.
     protected function validateInput()
     {
          // Grab user information
          $userInfo = $this->getUser();

          /* Check if the getUser function return an array and if the password is correct 
             Note: the function will return an array once the user provide registered email address */
          if (is_array($userInfo) && password_verify($this->password, $userInfo['password'])) {

               // Assign session variable (user) with an associative array that stores user info.
               session_start();
               $_SESSION['userInfo'] = $userInfo;

               header('Location: ../../index.php');
               exit();
          } else {
               $this->errorMessage['password'] = '&#9888; Incorrect email or password.';
          }

          $this->checkEmptyInput();
          return $this->errorMessage;
     }

     // Get user information through email.
     private function getUser()
     {
          $sql = "SELECT * FROM user WHERE email = ?;";
          $stmt = $this->connect()->prepare($sql);

          // Error handler for statement execution.
          $this->executeStmt($stmt, [$this->email]);
  
          $userInfo = $stmt->fetch();
          $stmt = null;
          return $userInfo;
     }

     // Check for any empty input field.
     private function checkEmptyInput()
     {
          if (empty($this->email)) {
               $this->errorMessage['email'] = '* Email is a required field.';
          }
          if (empty($this->password)) {
               $this->errorMessage['password'] = '* Password is a required field.';
          }
     }
}
