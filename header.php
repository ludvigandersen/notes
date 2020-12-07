<header>
  <!-- <img src="img/music-notes-logo.jpg" alt="" id="logo"> -->
  <?php 

    if(!isset($_SESSION)) { 
      session_start(); 
    }

    if (isset($_SESSION['admin'])){
  ?>
  <ul>
    <li><a href="artist.php">Artists</a></li>
    <li><a href="album.php">Albums</a></li>
    <li><a href="track.php">Tracks</a></li>
    <?php if($_SESSION['admin'] != "true"){ ?>
    <li><a href="cart.php">Cart</a></li>
    <?php } ?>
    <li class="rightHeader"><a href="user_update.php">Settings</a></li>
    
    <form action="index.php" id="signOutForm" method="POST">
      <li>
      <input type="submit" name="signOut" value="Sign out" id="signOut">
      </li>
    </form>
  </ul>
  
  <?php } else { ?>
  <ul>
    <li><a href="signin.php">Sign In</a></li>
    <li><a href="signup.php">Sign Up</a></li>
  </ul>
  <?php } ?>
  
</header>