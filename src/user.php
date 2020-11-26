<?php
  require_once('db_conn.php');  
  
  class User {
    
    # Inset user into database
    function create($data){
      global $pdo;

      if ($data['password'] != $data['passwordRepeat']){
        echo json_encode("passwords are not matching");
        return;
      }

$query = <<<'SQL'
      INSERT INTO customer
      (FirstName, LastName, Password, Company, Address, City, State, Country, PostalCode, Phone, Fax, Email)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
SQL;

      $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $stmt = $pdo->prepare($query);
      $insert_data = array(
        $data['firstName'], $data['lastName'], $pass_hash,
        $data['company'], $data['address'], $data['city'],
        $data['state'], $data['country'], $data['postalCode'],
        $data['phoneNumber'], $data['fax'], $data['email']
      );
      $result = $stmt->execute($insert_data);

      # Check if query was successful
      if($result){
        echo true;
      } else {
        echo false;
      }
    }

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

        // $_SESSION['email'] = $_POST['email'];
        if(password_verify($password, $admin[0])) {
          $admin = "true";
        } else {
          $admin = "false";
        }
        return [password_verify($password, $user['password']), $admin];  
      }
      return [password_verify($password, $user['password'])];
    }
  }
?>