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
  <?php include_once('header.php') ?>
  <div class="userDiv">
  <form action="signup.php" id="signUpForm" method="POST">
    <fieldset>
      <legend>Sign up</legend>
      <input type="text" placeholder="First Name" name="firstName" id="firstName" required>
      <input type="text" placeholder="Last Name" name="lastName" id="lastName" required>
      <input type="text" placeholder="Company" name="company" id="company">
      <input type="text" placeholder="Address" name="adress" id="address">
      <input type="text" placeholder="City" name="city" id="city">
      <input type="text" placeholder="State" name="state" id="state">
      <input type="text" placeholder="Country" name="country" id="country">
      <input type="text" placeholder="Postal Code" name="postalCode" id="postalCode">
      <input type="text" placeholder="Phone number" name="phoneNumber" id="phoneNumber">
      <input type="text" placeholder="Fax" name="fax" id="fax">
      <input type="email" placeholder="Email" name="emailSignUp" id="emailSignUp" required>
      <input type="password" placeholder="Password" name="password" id="password" required>
      <input type="password" placeholder="Repeat Password" name="passwordRepeat" id="passwordRepeat" required>
      <input type="submit" value="Sign Up">
    </fieldset>
  </form>
  </div>
  <?php include_once('footer.html') ?>
</body>
</html>