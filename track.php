<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="script-src http://notes.com/js/; img-src http://notes.com/; style-src http://notes.com/css/;">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/track.js"></script>
  <title>Tracks</title>
</head>
<body>
  <?php
    session_start();

    if (!$_SESSION['admin']){
      header('Location: index.php');
    }

    if(isset($_POST['billingAddress'])){
      $cookies = $_COOKIE;
      foreach($cookies as $key => $cookie){
        $k = explode('_', $key);
        if($k[0] == 'track'){
          setcookie($key, "", time() - 3600, '/', 'notes.com', false, true);
        }
      }
    }
    
    include_once('header.php');

    if($_SESSION['admin'] == "true"){
  ?>

  <button id="createTrackBtn" class="createBtn">Create Track</button>

  <?php } ?>
  <div id="searchDiv">
    <input type="text" id="searchTitle" placeholder="Title">
    <button id="btnSearch">Search</button>
    <input type="text" id="searchAlbum" placeholder="Album">
    <button id="btnSearchAlbum">Search</button>
  </div>
  <?php
    if(isset($_POST['trackId'])){
      if(isset($_COOKIE['track_' . $_POST['trackId']])){
        # If specific item has been added to the cart once, modify existing cookie data: Quantity, Total
        $cookie = $_COOKIE['track_' . $_POST['trackId']];
        $cookie = stripslashes($cookie);
        $track_array = json_decode($cookie, true);
        $quantity = ++$track_array['quantity'];
        $track_array['quantity'] = $quantity;
        $track_array['total'] = $quantity * $track_array['price'];
        setcookie('track_' . $track_array['trackId'], json_encode($track_array), time() + 86400, '/', 'notes.com', false, true);
      } else {
        # If specific item has not been added to the cart, add it.
        $data = array("title" => $_POST['title'], "album" => $_POST['album'], "genre" => $_POST['genre'], "price" => $_POST['price'], "trackId" => $_POST['trackId'], "quantity" => 1, "total" => $_POST['price']);
        setcookie("track_" . $_POST['trackId'], json_encode($data), time() + 86400, '/', 'notes.com', false, true);
      }
    }

    if($_SESSION['admin'] == "false"){
  ?>
  <!-- Table for listing albums -->
  <div class="tableDiv">
    <table id="tracks">
      <tr>
        <th>Title</th>
        <th>Album</th>
        <th>Genre</th>
        <th>Price</th>
      </tr>
    </table>
    <div>
      <button id="btnBackward" page="-1" disabled ><<<</button>
      <button id="btnForward" page="1">>>></button>
    </div>
  </div>

  <?php } else {?>

  <!-- Table for listing albums and CRUD options -->
  <div class="tableDiv">
    <table id="tracksAdmin">
      <tr>
        <th>Title</th>
        <th>Album</th>
        <th>Genre</th>
        <th>Price</th>
      </tr>
    </table>
    <button id="btnBackward" page="-1" disabled ><<<</button>
    <button id="btnForward" page="1">>>></button>
  </div>
  <?php } ?>

  <!-- Modal for creating tracks -->
  <div id="createModal" class="modal">
    <div class="modalContent">
      <h1>Create new Album</h1>
      <form action="track.php" method="post">

      <div>
        <label for="name">Track title: </label>
        <input type="text" placeholder="Track name" id="name" required>
        <label for="albums">Album: </label>
        <select name="albums" id="albumsDropdownCreate">
        </select>
      </div>

      <div>
        <label for="price">Price: </label>
        <input type="number" name="price" id="price" step=".01" min="0">
        <label for="genres">Genre: </label>
        <select name="genres" id="genresDropdownCreate">
        </select>
      </div>

      <div>
        <label for="composer">Composers: </label>
        <input type="text" name="composer" id="composers">
        <label for="mediaType">Media type: </label>
        <select name="mediaType" id="mediaTypesDropdownCreate">
          <option value="1">MPEG Audio File</option>
          <option value="2">Protected AAC audio file</option>
          <option value="3">Protected MPEG-4 video file</option>
          <option value="4">Purchased AAC audio file</option>
          <option value="5">AAC audio file</option>
        </select>
      </div>

      <div>
        <label for="length">Length in seconds: </label>
        <input type="number" name="length" id="length" min="0" step="1">
        <input type="submit" id="finishCreate">  
      </div>

        
      </form>
      <button id="cancelCreate">Cancel</button>
    </div>
  </div>

  <!-- Modal for updating tracks -->
  <div id="updateModal" class="modal">
    <div class="modalContent">
    <h1>Updating track: <span id="trackName"></span></h1>
      <form action="track.php" method="post" id="updateForm">

        <div>
          <label for="nameUpdate">Title: </label>
          <input name="nameUpdate" type="text" placeholder="Track name" id="nameUpdate" required>
          <select name="albums" id="albumsDropdownUpdate" required>
            <option value="">None</option>
          </select>
        </div>

        <div>
          <select name="genres" id="genresDropdownUpdate" required>
            <option value="">None</option>
          </select>
          <label for="price">Price: </label>
          <input type="number" name="price" id="priceUpdate" step=".01" min="0" required>
        </div>

        <div>
          <label for="mediaType">Media type: </label>
          <select name="mediaType" id="mediaTypesDropdownUpdate" required>
            <option value="1">MPEG Audio File</option>
            <option value="2">Protected AAC audio file</option>
            <option value="3">Protected MPEG-4 video file</option>
            <option value="4">Purchased AAC audio file</option>
            <option value="5">AAC audio file</option>
          </select>

          <label for="composer">Composers: </label>
          <input type="text" name="composer" id="composersUpdate" required>
        </div>

        <div>
          <label for="length">Length in seconds: </label>
          <input type="number" name="length" id="lengthUpdate"  step="1" min="0" required>
          <input type="submit" id="finishUpdate">
        </div>
        
        <input type="hidden" id="trackId" required>

        <input type="hidden" id="artistId" required>

        
      </form>
      <button id="cancelUpdate">Cancel</button>
    </div>
  </div>

  <?php include_once('footer.html') ?>
</body>
</html>