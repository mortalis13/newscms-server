<?php

class User extends SuperUser{
  public function archive(){
    $this->pageTitle = "User: News Archive";
    $this->setArchiveData();
    $this->show("archive");
  }

  public function viewNews() {
    $this->setMessages();
    if (!isset($_GET["newsId"]) || !$_GET["newsId"])
      $this->go("index.php");

    $newsId=$this->sanitizeString($_GET['newsId']);
    if(!$this->getNews($newsId))
      $this->go("index.php?error=noNewsId");
    else
      $this->show("viewNews");
  }

  public function homepage() {
    $this->pageTitle = "User: Homepage";
    $this->setListData();
    $this->setMessages();
    $this->setFillers();
    $this->show("homepage");
  }
}
?>
