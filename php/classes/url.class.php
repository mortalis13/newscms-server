<?php

class URL{
  private $urls=array();

  public function __set($name,$value){
    $this->urls[$name]=$value;
  }

  public function setURLs($page) {
    $this->headerURLs();
    $this->footerURLs();

    switch($page){
      case "loginForm":
        $this->loginURLs();break;
      case "regForm":
        $this->regURLs();break;
      case "editProfile":
        $this->editProfileURLs();break;
      case "editNews":
        $this->editNewsURLs();break;
      case "listNews":
        $this->listNewsURLs();break;
      case "archive":
        $this->archiveURLs();break;
      case "viewNews":
        $this->viewNewsURLs();break;
      case "homepage":
        $this->homepageURLs();break;
    }
    return $this->urls;
  }

  public function headerURLs() {
    $this->homepageURL="index.php";
  }

  public function footerURLs() {
    $this->adminURL="admin.php";
  }

  /* admin */

  public function loginURLs() {
    $this->regURL="admin.php?action=register";
    $this->redirectURL="admin.php?action=listNews";
  }

  public function regURLs() {
    $this->loginURL="admin.php?action=login";
  }

  public function editProfileURLs() {
    $this->adminCommonURLs();
    $this->deleteProfileURL="admin.php?action=deleteProfile";
  }

  public function editNewsURLs() {
    $this->adminCommonURLs();
  }

  public function listNewsURLs() {
    $this->adminCommonURLs();
    $this->pageURL="admin.php?page=";
    $this->exportCSVURL="admin.php?action=exportCSV";
  }

  /* user */

  public function archiveURLs() {
    $this->userCommonURLs();
    $this->exportCSVURL="index.php?action=exportCSV";
  }

  public function viewNewsURLs() {
    $this->userCommonURLs();
    $this->editNewsURL="admin.php?action=editNews&amp;newsId=";
  }

  public function homepageURLs() {
    $this->userCommonURLs();
    $this->pageURL="index.php?page=";
    $this->exportCSVURL="index.php?action=exportCSV";
  }

  public function userCommonURLs() {
    $this->viewNewsURL="index.php?action=viewNews&amp;newsId=";
    $this->archiveURL="index.php?action=archive";
  }

  public function adminCommonURLs() {
    $this->profileURL="admin.php?action=editProfile";
    $this->logoutURL="admin.php?action=logout";
    $this->newNewsURL="admin.php?action=newNews";
    $this->deleteNewsURL="admin.php?action=deleteNews&amp;newsId=";
    $this->editNewsURL="admin.php?action=editNews&amp;newsId=";
  }
}

?>
