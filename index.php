<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="script-src http://notes.com/js/; img-src http://notes.com/; style-src http://notes.com/css/;">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <?php
    session_start();
    if (isset($_POST['email']) && $_POST['email'] != "") {
      require_once('src/user.php');
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