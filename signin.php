<?php
  session_start();

  if(!isset($_SESSION['csrf'])){
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  }
  

  if(isset($_SESSION['admin'])){
    header('Location: artist.php');
  }
  
  if(isset($_POST['token'])){
    if($_POST['token'] != $_SESSION['csrf']){
      # Render some error
      return;
    } else {
      if(isset($_POST['email'])){
        require_once("src/user.php");

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User();

        $results = $user->sign_in($email, $password);
        $verified = $results[0];

        if($verified){
          $csrf_token = bin2hex(random_bytes(32));

          $_SESSION['admin'] = $results[1];
          $_SESSION['csrf'] = $csrf_token;

          $_SESSION['userId'] = $user->userId;
          $_SESSION['email'] = $email;
          $_SESSION['firstName'] = $user->firstName;
          $_SESSION['lastName'] = $user->lastName;
          $_SESSION['company'] = $user->company;
          $_SESSION['address'] = $user->address;
          $_SESSION['city'] = $user->city;
          $_SESSION['state'] = $user->state;
          $_SESSION['country'] = $user->country;
          $_SESSION['postalCode'] = $user->postalCode;
          $_SESSION['phone'] = $user->phone;
          $_SESSION['fax'] = $user->fax;

          header('Location: artist.php');
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="script-src http://notes.com/js/; img-src http://notes.com/; style-src http://notes.com/css/;">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/script.js"></script>
  <title>Document</title>
</head>
<body>
  <?php include_once 'header.php' ?>
  <div id="signInDiv">
    <h1>Sign In</h1>
    <form action="signin.php" id="signInForm" method="POST">
      <div>
        <input type="email" placeholder="Email" name="email" id="signInEmail" required>
      </div>
      <div>
        <input type="password" placeholder="Password" name="password" id="signInPassword" required>
      </div>
      <input type="hidden" name="token" value=<?= $_SESSION['csrf']?>>
      <div>
        <input type="submit" value="Sign In" id="signInBtn">
      </div>
    </form>
  </div>
  <?php include_once 'footer.html' ?>
</body>
</html>