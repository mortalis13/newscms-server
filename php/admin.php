<?php

require_once "config.php";

$admin=new Admin();
$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

if ($action != "login" && $action != "logout" && $action != "register" && !$username){    //if first visit and no username login
  $admin->login();
  exit;
}

switch ($action){
  case 'register':
    $admin->register();
    break;
  case 'login':
    $admin->login();
    break;
  case 'logout':
    $admin->logout();
    break;
  case 'editProfile':
    $admin->editProfile();
    break;
  case 'newNews':
    $admin->newNews();
    break;
  case 'editNews':
    $admin->editNews();
    break;
  case 'previewNews':
    $admin->previewNews();
    break;
  case 'deleteNews':
    $admin->deleteNews();
    break;
  case 'deleteProfile':
    $admin->deleteProfile();
    break;
  case 'exportCSV':
    $user->exportCSV($_SESSION['username']);
    break;
  default:
    $admin->listNews();
}

?>
