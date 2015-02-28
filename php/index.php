<?php

require_once "config.php";

$user=new User();
$action = isset($_GET['action']) ? $_GET['action'] : "";

switch ($action){
  case 'viewNews':
    $user->viewNews();
    break;
  case 'archive':
    $user->archive();
    break;
  case 'exportCSV':
    $user->exportCSV();
    break;
  default:
    $user->homepage();
}

?>
