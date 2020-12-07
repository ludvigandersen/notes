<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="script-src http://notes.com/js/; img-src http://notes.com/; style-src http://notes.com/css/;">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/artist.js"></script>
  <title>Artists</title>
</head>
<body>
  <?php 
    session_start();
    
    if (!$_SESSION['admin']){
      header('Location: index.php');
    }
    include_once('header.php');

    if($_SESSION['admin'] == "true"){
  ?>
  
  <button id="createArtistBtn" class="createBtn">Create Artist</button>

  <?php } ?>

  <?php 
    if($_SESSION['admin'] == "false"){
  ?>
  <!-- Table for listing artists -->
  <div class="tableDiv">
    <table id="artists">
      <tr>
        <th>Artists</th>
      </tr>
    </table>
    <div>
      <button id="btnBackward" page="-1" disabled ><<<</button>
      <button id="btnForward" page="1">>>></button>
    </div>
  </div>

  <?php } else {?>

  <!-- Table for listing artists and CRUD options -->
  <div class="tableDiv">
    <table id="artistsAdmin">
        <tr>
          <th>Artists Admin</th>
        </tr>
    </table>
    <div>
      <button id="btnBackward" page="-1" disabled ><<<</button>
      <button id="btnForward" page="1">>>></button>
    </div>
  </div>
  <?php } ?>

  <!-- Modal for creating artists -->
  <div id="createModal" class="modal">
    <div class="modalContent">
      <h1>Create new Artist</h1>
      <form action="artist.php" method="POST" id="createArtistForm">
        <input type="text" placeholder="Artist name" name="name" id="name" required>
        <input type="submit" value="Create" id="finishCreate">
      </form>
      <button id="cancelCreate">Cancel</button>
    </div>
  </div>

  <!-- Modal for updating artists -->
  <div id="updateModal" class="modal">
    <div class="modalContent">
    <h1>Updating artist: <span id="artistName"></span></h1>
      <form action="artist.php" method="post" >
        <input type="text" placeholder="Artist name" id="nameUpdate" required>
        <input type="hidden" id="artistId">
        <input type="submit" id="finishUpdate">
      </form>
      <button id="cancelUpdate">Cancel</button>
    </div>
  </div>
  <?php include_once('footer.html') ?>
</body>
</html>