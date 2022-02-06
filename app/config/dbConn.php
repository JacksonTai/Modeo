<?php

namespace Config;

use PDO;
use PDOException;

class DbConn
{
     private $hostname = 'localhost';
     private $database = 'modeo';
     private $username = 'root';
     private $password = '';
     private $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

     protected function connect()
     {
          try {
               $dsn = 'mysql:host=' . $this->hostname . ';dbname=' . $this->database;
               $pdo = new PDO($dsn, $this->username, $this->password, $this->options);
               return $pdo;
          } catch (PDOException $e) {
               die('<h2>Failed to connect database!</h2> Error: ' . $e->getMessage());
          }
     }

     // Error handler for statement execution.
     protected function executeStmt($stmt, $values = null)
     {
          if ($values) {
               try {
                    $stmt->execute($values);
               } catch (PDOException $e) {
                    die("<h2>SQL statement execution failed.</h2> Error: " . $e->getMessage());
               }
          } else {
               try {
                    $stmt->execute();
               } catch (PDOException $e) {
                    die("<h2>SQL statement execution failed.</h2> Error: " . $e->getMessage());
               }
          }
     }
}
