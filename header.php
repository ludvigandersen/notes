<header>
  <img src="img/music-notes-logo.jpg" alt="" id="logo">
  <?php 

    if(!isset($_SESSION)) { 
      session_start(); 
    }
    print_r($_SESSION);
    if (isset($_SESSION['admin'])){
  ?>
  <a href="artist.php">Artists</a>
  <a href="album.php">Albums</a>
  <a href="track.php">Tracks</a>

  <form action="index.php" id="signOutForm" method="POST">
    <input type="submit" name="signOut" value="Sign out">
  </form>
  <?php } else { ?>
    <a href="signin.php">Sign In</a>
    <a href="signup.php">Sign Up</a>
  <?php } ?>
</header>