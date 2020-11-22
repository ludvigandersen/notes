<?php
  require_once('db_conn.php');  
  
  class User {

    # Validate user based on $email and $password
    function sign_in($email, $password){
      global $pdo;
      session_start();

$query = <<<'SQL'
      SELECT password, email
      FROM customer
      WHERE email=?
SQL;

      # Prepare and execute statement for retrieving user based on email
      $stmt = $pdo->prepare($query);
      $stmt->execute(array($email));
      $user = $stmt->fetch();

      $verify = password_verify($password, $user['password']);
      if($verify){

$query = <<<'SQL'
        SELECT *
        FROM admin
SQL;

        # Prepare and execute statement for retrieving Admin password
        # If given $password is equal to Admin password, set admin session token
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($pass_hash));
        $admin = $stmt->fetch();

        $_SESSION['email'] = $_POST['email'];
        if(password_verify($password, $admin[0])) {
          $_SESSION['admin'] = "true";
        } else {
          $_SESSION['admin'] = "false";
        }
        
      }
      return password_verify($password, $user['password']);
    }
  }
?>