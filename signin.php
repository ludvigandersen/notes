<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <?php include_once 'header.php' ?>
  <div id="signInDiv">
    <h1>Sign In</h1>
    <form action="index.php" id="signInForm" method="POST">
      <div>
        <input type="email" placeholder="Email" name="email" id="signInInput" required>
      </div>
      <div>
        <input type="password" placeholder="Password" name="password" id="signInInput" required>
      </div>
      <div>
        <input type="submit" value="Sign In" id="signInBtn">
      </div>
    </form>
  </div>
  <?php include_once 'footer.html' ?>
</body>
</html>