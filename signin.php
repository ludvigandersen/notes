<?php include_once 'header.php' ?>

<form action="index.php" id="signInForm" method="POST">
  <fieldset>
    <legend>Sign in</legend>
    <input type="email" placeholder="Email" name="email" required>
    <input type="password" placeholder="Password" name="password" required>
    <input type="submit" value="Sign In">
  </fieldset>
</form>

<?php include_once 'footer.html' ?>