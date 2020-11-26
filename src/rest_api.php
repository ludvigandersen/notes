<?php   
  session_start();
  
  define('ENTITY', 3);
  define('ID', 4);

  $url = strtok($_SERVER['REQUEST_URI'], "?");

  if (substr($url, strlen($url) - 1) == '/') {
    $url = substr($url, 0, strlen($url) - 1);
  }

  header('Content-Type: application/json');
  header('Accept-version: v1');

  # ALLOW ONLY ACCESS FROM NOTES.COM
  # CURRENTLY WILDCARD - INSECURE
  header("Access-Control-Allow-Origin: *");

  $urlPieces = explode('/', urldecode($url));
  $pieces = count($urlPieces);

  if($pieces == "3") {
    echo APIDescription();
  } elseif ($pieces > "5") {
    echo "der er sgu fejl";
    echo json_encode($urlPieces);
  } else {

    $entity = $urlPieces[ENTITY];
    $method = $_SERVER['REQUEST_METHOD'];
  
    switch ($entity) {
      case 'validate':
        require_once('user.php');
        $user = new User();
        
        switch ($method) {
          case 'POST':
            echo json_encode($user->sign_in($_POST['email'], $_POST['password']));
            break;
        }
        break;

      case 'user':
        require_once('user.php');
        $user = new User();
        
        switch ($method) {
          case 'POST':
            $user->create($_POST);
            break;
        }
        break;
      
      case 'artist':
        require_once('artist.php');
        $artist = new Artist();

        switch ($method) {
          case 'GET':
            echo json_encode($artist->list());
            break;
          
          case 'POST':
            $artist->create($_POST['name']);
            break;

          case 'PUT':
            $artistName = file_get_contents('php://input');
            $id = $urlPieces[ID];
            $artist->update($id, $artistName);
          break;

          case 'DELETE':
            $id = $urlPieces[ID];
            $artist->delete($id);
            break;
        }

      default:
        # code...
        break;
    }    
  }


  function APIDescription(){
    $baseUrl = "http://php-rest-api/";

    $apiDescription['api-description'] = ['method' => 'GET', 'url' => $baseUrl];

    return json_encode($apiDescription);
  };
?>