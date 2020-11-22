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
    
    if (!$_SESSION['email']){
      header('Location: index.php');
    }
    include_once('header.php') 
  ?>
    <h1>velkommen til artists</h1>


  <?php include_once('footer.html') ?>
</body>
</html>