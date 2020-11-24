<?php 
  $entity = $_POST['entity'];
  $action = $_POST['action'];
  
  switch ($entity) {
    case 'user':
      require_once('user.php');
      $user = new User();

      switch ($action) {
        case 'post':
          $user->create($_POST);
          break;
        
        default:
          # code...
          break;
      }

      break;
    
    default:
      # code...
      break;
  }
?>