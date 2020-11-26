<?php
  session_start();

  if(isset($_SESSION['admin'])){
    header('Location: artist.php');
  }
  
  if(isset($_POST['email'])){
    require_once("src/user.php");
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();

    $results = $user->sign_in($email, $password);
    $verified = $results[0];

    if($verified){
      $_SESSION['admin'] = $results[1];

      header('Location: artist.php');
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <div>
        <input type="submit" value="Sign In" id="signInBtn">
      </div>
    </form>
  </div>
  <?php include_once 'footer.html' ?>
</body>
</html>