<?php 
  require_once('db_conn.php');  
  
  class Artist {

    # Lists all existing artists
    function list(){
      global $pdo;

$query = <<< 'SQL'
      SELECT * FROM artist
SQL;
      
      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $result = $stmt->fetchAll();
      
      return $result;
    }

    # Create a new artist
    function create($name){
      global $pdo;

$query = <<< 'SQL'
      INSERT INTO artist (name)
      VALUES (?)
SQL;

      $stmt = $pdo->prepare($query);
      $result = $stmt->execute([$name]);

      # Check if query was successful
      if($result){
        echo true;
      } else {
        echo false;
      }
    }

    # Update artist by id
    function update($id, $name){
      global $pdo;

$query = <<< 'SQL'
      UPDATE artist
      SET name=?
      WHERE ArtistId=?
SQL;

      $stmt = $pdo->prepare($query);
      $result = $stmt->execute([$name, $id]);

      if($result){
        echo json_encode("artist update success");
      } else {
        echo json_encode("artist update failed");
      }
    }

    # Delete artist by id
    function delete($id){
      global $pdo;

      # Check if artist has an album
      # If yes then return message
$query = <<< 'SQL'
      SELECT AlbumId
      FROM album
      WHERE ArtistId=?
SQL;

      $stmt = $pdo->prepare($query);
      $stmt->execute([$id]);
      $result = $stmt->fetch();

      if($result > 1) {
        echo json_encode("artist has an album");
        return;
      }

      # If artist does not have an album, finish deletion
$query = <<< 'SQL'
      DELETE FROM artist
      WHERE ArtistId=?
SQL;

      $stmt = $pdo->prepare($query);
      $result = $stmt->execute([$id]);

      if($result){
        echo true;
      } else {
        echo false;
      }
    }
  }
?>