<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="script-src http://notes.com/js/; img-src http://notes.com/; style-src http://notes.com/css/;">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/album.js"></script>
  <title>Document</title>
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

  <button id="createAlbumBtn"  class="createBtn">Create Album</button>
  
  <?php } ?>

  <?php 
    if($_SESSION['admin'] == "false"){
  ?>
  <!-- Table for listing albums -->
  <div class="tableDiv">
    <table id="albums">
      <tr>
        <th>Artist</th>
        <th>Title</th>
      </tr>
    </table>
    <button id="btnBackward" page="-1" disabled ><<<</button>
    <button id="btnForward" page="1">>>></button>
  </div>

  <?php } else {?>

  <!-- Table for listing albums and CRUD options -->
  <div class="tableDiv">
    <table id="albumsAdmin">
      <tr>
        <th>Artist</th>
        <th>Title</th>
      </tr>
    </table>
    <button id="btnBackward" page="-1" disabled ><<<</button>
    <button id="btnForward" page="1">>>></button>
  </div>
  <?php } ?>

  <!-- Modal for creating albums -->
  <div id="createModal" class="modal">
    <div class="modalContent">
      <h1>Create new Album</h1>
      <form action="album.php" method="post">
        <input type="text" placeholder="Album name" id="name" required>
        <select name="artists" id="artistsDropdownCreate">
        </select>
        <input type="submit" id="finishCreate">
      </form>
      <button id="cancelCreate">Cancel</button>
    </div>
  </div>

  <!-- Modal for updating albums -->
  <div id="updateModal" class="modal">
    <div class="modalContent">
    <h1>Updating album: <span id="albumName"></span></h1>
      <form action="artist.php" method="post">
        <input type="text" placeholder="Album name" id="nameUpdate" required>
        <select name="artists" id="artistsDropdownUpdate">
          <option value="">None</option>
        </select>
        <input type="hidden" id="albumId">
        <input type="hidden" id="artistId">
        <input type="submit" id="finishUpdate">
      </form>
      <button id="cancelUpdate">Cancel</button>
    </div>
  </div>


  <?php include_once('footer.html') ?>
</body>
</html>