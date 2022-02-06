<?php

namespace Model;

class Signup extends \Config\DbConn
{
     private $email;
     private $username;
     private $password;
     private $passwordRepeat;
     private $errorMessage = [
          'email' => '',
          'username' => '',
          'password' => '',
          'passwordRepeat' => ''
     ];

     public function __construct($postData)
     {
          $this->email = $postData['email'];
          $this->username = $postData['username'];
          $this->password = $postData['password'];
          $this->passwordRepeat = $postData['passwordRepeat'];
     }

     // Main function to validate all input fields.
     protected function validateInput()
     {
          // Run all functions that check for input fields.
          $this->checkEmail();
          $this->checkUsername();
          $this->checkPassword();
          $this->checkPasswordRepeat();
          $this->checkDuplicateEmail();
          $this->checkEmptyInput();

          // Check if there is no empty or invalid input fields.
          if (!array_filter($this->errorMessage)) {

               // Generate unique user ID.
               $userId = uniqid('N');

               // Encrypt user password.
               $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

               $this->createUser($userId, $hashedPassword);

               // Session variable (userInfo) serves as an associative array that stores user info.
               session_start();
               $_SESSION['userInfo'] = [
                    'user_id' => $userId,
                    'email' => $this->email,
                    'username' => $this->username,
                    'password' => $hashedPassword,
               ];

               header('Location: ../../index.php');
          }
          return $this->errorMessage;
     }

     // Insert user details into database.
     private function createUser($userId, $hashedPassword)
     {
          $sql = "INSERT INTO user (user_id, email, username, password)
                  VALUES (?, ?, ?, ?);";
          $stmt = $this->connect()->prepare($sql);

          // Error handler for statement execution.
          $this->executeStmt($stmt, [
               $userId,
               $this->email,
               $this->username,
               $hashedPassword
          ]);

          // Clear prepared statement.
          $stmt = null;
     }

     // Check for invalid email address.
     private function checkEmail()
     {
          if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
               $this->errorMessage['email'] = '&#9888; Invalid email address.';
          }
     }

     // Check for invalid username.
     private function checkUsername()
     {
          if (!preg_match("/^[a-z]{8,30}$/i", $this->username)) {
               $this->errorMessage['username'] = '&#9888; Invalid username.';
          }
     }

     // Check for invalid password.
     private function checkPassword()
     {
          if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/", $this->password)) {
               $this->errorMessage['password'] = '&#9888; Invalid password.';
          }
     }

     // Check if repeating password is matched.
     private function checkPasswordRepeat()
     {
          if ($this->password != $this->passwordRepeat) {
               $this->errorMessage['passwordRepeat'] = "&#9888; Those passwords didn't match.";
          }
     }

     // Check if there is duplicated email address.
     private function checkDuplicateEmail()
     {
          $sql = "SELECT * FROM user WHERE email = ?;";
          $stmt = $this->connect()->prepare($sql);

          // Error handler for statement execution.
          $this->executeStmt($stmt, [$this->email]);

          // Check sql records row number.
          if ($stmt->rowCount() > 0) {
               $this->errorMessage['email'] = '&#9888; This email is already taken.';
          }
     }

     // Check for any empty input field.
     private function checkEmptyInput()
     {
          if (empty($this->email)) {
               $this->errorMessage['email'] = '* Email is a required field.';
          }
          if (empty($this->username)) {
               $this->errorMessage['username'] = '* Username is a required field.';
          }
          if (empty($this->password)) {
               $this->errorMessage['password'] = '* Password is a required field.';
          }
          if (empty($this->passwordRepeat)) {
               $this->errorMessage['passwordRepeat'] = '* Please repeat your password.';
          }
     }
}
