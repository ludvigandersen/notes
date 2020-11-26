<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/artist.js"></script>
  <title>Document</title>
</head>
<body>
  <?php include_once('header.php') ?>
  
  <button id="createArtistBtn">Create Artist</button>

  <?php 
    if($_SESSION['admin'] == "false"){
  ?>
  <!-- Table for listing artists -->
  <div>
    <table id="artists">
      <tr>
        <th>Artists</th>
      </tr>
    </table>
  </div>

  <?php } else {?>

  <!-- Table for listing artists and CRUD options -->
  <div>
    <table id="artistsAdmin">
      <tr>
        <th>Artists Admin</th>
      </tr>
    </table>
  </div>
  <?php } ?>

  <!-- Modal for creating artists -->
  <div id="createModal" class="modal">
    <div class="modalContent">
      <h1>Create new Artist</h1>
      <form action="artist.php" method="post">
        <input type="text" placeholder="Artist name" id="name" required>
        <input type="submit" id="finishCreate">
      </form>
      <button id="cancelCreate">Cancel</button>
    </div>
  </div>

  <!-- Modal for updating artists -->
  <div id="updateModal" class="modal">
    <div class="modalContent">
    <h1>Updating artist: <span id="artistName"></span></h1>
      <form action="artist.php" method="post">
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