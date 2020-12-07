<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="script-src http://notes.com/js/; img-src http://notes.com/; style-src http://notes.com/css/;">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/cart.js"></script>
  <title>Cart</title>
</head>
<body>
  <?php 
    session_start();

    if (!$_SESSION['admin']){
      header('Location: index.php');
    }
    include_once('header.php');
  ?>

  <div class="tableDiv">
    <table id="cart">
      <tr>
        <th>Title</th>
        <th>Album</th>
        <th>Genre</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
      </tr>

      <?php
        $full_amount = 0;
        foreach ($_COOKIE as $key => $value) {
          $cookie = $_COOKIE[$key];
          $cookie = stripslashes($cookie);
          $track_array = json_decode($cookie, true);
          $full_amount += $track_array['total'];
      ?>

      <tr class="invoiceLine">
        <td><?= $track_array['title']?></td>
        <td><?= $track_array['album']?></td>
        <td><?= $track_array['genre']?></td>
        <td><?= $track_array['quantity']?></td>
        <td><?= $track_array['price']?></td>
        <td><?= $track_array['total']?></td>
        <input type="hidden" id="price" value="<?php echo $track_array['price'];?>">
        <input type="hidden" id="quantity" value="<?php echo $track_array['quantity'];?>">
        <input type="hidden" id="trackId" value="<?php echo $track_array['trackId'];?>">
      </tr>

      <?php } ?>
      <tr>
        <td>
          <button id="purchase">Purchase</button>
        </td>
      </tr>
    </table>
  </div>

  <!-- Modal for accepting purchase -->
  <div id="purchaseModal" class="modal">
    <div class="modalContent">
      <form action="track.php" method="post" id="purchaseForm">
        <input type="hidden" value="<?php echo $_SESSION['userId'];?>" id="userId" required>
        <input type="text" placeholder="Billing Address" value="<?php echo $_SESSION['address'];?>" id="billingAddress" name="billingAddress" required>
        <input type="text" placeholder="Billing City" value="<?php echo $_SESSION['city'];?>" id="billingCity" required>
        <input type="text" placeholder="Billing Country" value="<?php echo $_SESSION['country'];?>" id="billingCountry" required>
        <input type="text" placeholder="Billing State" value="<?php echo $_SESSION['state'];?>" id="billingState" required>
        <input type="text" placeholder="Billing Postal Code" value="<?php echo $_SESSION['postalCode'];?>" id="billingPostalCode" required>
        <input type="text" placeholder="Total" value="<?php echo $full_amount;?>" id="billingTotal" disabled required>
        <input type="submit" id="finishPurchase" value="Accept">
      </form>
      <button id="cancelPurchase">Cancel</button>
    </div>
  </div>

  <?php include_once('footer.html') ?>
</body>
</html>