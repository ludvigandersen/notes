<?php
  require_once('db_conn.php');  
  
  class User {

    public $userId;
    public $email;
    public $firstName;
    public $lastName;
    public $company;
    public $address;
    public $city;
    public $state;
    public $country;
    public $postalCode;
    public $phone;
    public $fax;

    # Validate user based on $email and $password
    function sign_in($email, $password){
      global $pdo;
      session_start();

$query = <<<'SQL'
      SELECT password, email, firstName, lastName, company, address, city, state, country, PostalCode, phone, fax, customerId
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


        $this->userId = $user['customerId'];
        $this->email = $email;
        $this->firstName = $user['firstName'];
        $this->lastName = $user['lastName'];
        $this->company = $user['company'];
        $this->address = $user['address'];
        $this->city = $user['city'];
        $this->state = $user['state'];
        $this->country = $user['country'];
        $this->postalCode = $user['PostalCode'];
        $this->phone = $user['phone'];
        $this->fax = $user['fax'];
        
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