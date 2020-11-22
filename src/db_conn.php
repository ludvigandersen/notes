<?php
  $host = 'localhost';
  $db = 'chinook_abridged';
  $user  = 'root';
  $pwd = 'root';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

  try {
    $pdo = new PDO($dsn, $user, $pwd);
  } catch (\PDOException $e){
    echo $e;
  }
?>