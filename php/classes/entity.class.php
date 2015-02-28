<?php

abstract class Entity{
  protected $db;
  protected $functions;
  protected $check;
  protected $messages;
  protected $url;
  protected $manageNews;
  protected $table;
  protected $results=array();

  public function __construct(){
    $this->db=Database::getConnection();
    $this->functions=new Functions();
    $this->check=new Check();
    $this->messages=new Messages();
    $this->url=new URL();
    $this->manageNews=new ManageNews();
    $this->table=DB_TABLE_PREFIX.DB_USER_TABLE;
  }

  public function __get($name){
    if(isset($this->results[$name]))
      return $this->results[$name];
    return "";
  }

  public function __set($name,$value){
    $this->results[$name]=$value;
  }

  protected function sanitizeData($data){
    $this->functions->sanitizeData($data);
  }

  protected function sanitizeString($data){
    return $this->functions->sanitizeString($data);
  }

  protected function go($address){
    $this->functions->go($address);
  }

  protected function show($template,$source){
    $this->header=TEMPLATE_PATH."/include/header.php";
    $this->footer=TEMPLATE_PATH."/include/footer.php";
    $this->class=isset($_GET['action'])?$_GET['action']:$source;
    if($source=="admin")
      $this->adminHeader=TEMPLATE_PATH."/include/adminHeader.php";
    $this->menu=TEMPLATE_PATH."/include/menu.php";
    
    $this->template=$template;
    $this->sitename=SITE_NAME;

    $this->setURLs($template);
    require(TEMPLATE_PATH."/$source/$template.php");
  }

  protected function setMessages(){
    if(isset($_GET['error'])) $this->errorMessage=$this->messages->get($_GET['error'],true);
    if(isset($_GET['status'])) $this->statusMessage=$this->messages->get($_GET['status'],true);
  }

  public function setURLs($page){
    $this->urls=$this->url->setURLs($page);
  }

  public function exportCSV($username=""){
    $this->manageNews->tocsv($username);
    $this->statusMessage=$this->messages->get("NEWS_EXPORTED");
  }

  abstract protected function getNews($newsId);
  abstract protected function setPages();
  abstract protected function setListData();
  abstract protected function setFillers();
}

?>
