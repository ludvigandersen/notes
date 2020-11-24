<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <?php
    session_start();
    if (isset($_POST['email']) && $_POST['email'] != "") {
      require_once('src/user.php');
  
      $user = new User();
      $verified = $user->sign_in($_POST['email'], $_POST['password']); 
      if ($verified){
        header('Location: artist.php');
      }   
    } else if (isset($_POST['signOut'])) {
      session_destroy();
    }

    if(!isset($_SESSION['email'])){
      header('Location: signin.php');
    } else {
      header('Location: artist.php');
    }
  ?>
</body>
</html>