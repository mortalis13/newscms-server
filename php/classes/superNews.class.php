<?php

class SuperNews{
  protected $db;
  protected $check;
  protected $format;
  protected $table;

  public function __construct() {
    $this->db=Database::getConnection();
    $this->check=new Check();
    $this->format=new Format();
    $this->table=DB_TABLE_PREFIX.DB_NEWS_TABLE;
  }
}

?>
