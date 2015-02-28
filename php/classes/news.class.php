<?php

class News extends SuperNews{
  public $id;
  public $date;
  public $title;
  public $content;
  public $image;
  public $username;
  public $userArchive;

  public function __construct($data=array()) {
    parent::__construct();

    if (isset($data['id'])) $this->id = (int) $data['id'];
    if (isset($data['date'])) $this->date = $this->format->date($data['date']);
    else $this->date = $this->format->date("now");                                  //if new news

    if (isset($data['title'])) $this->title = $data['title'];
    if (isset($data['content'])) $this->content = $data['content'];
    if (isset($data['image'])) $this->image=$data['image'];
    else $this->image=DEFAULT_IMAGE;

    if (isset($data['user'])) $this->username=$data['user'];
    elseif (isset($data['username'])) $this->username=$data['username'];

    if (isset($data['user_archive'])) $this->userArchive=$data['user_archive'];
  }

  public function storeFormValues ($data){
    $this->__construct($data);
  }

  public function insert() {
    if (!is_null($this->id))
      trigger_error ("News::insert(): Attempt to insert a News object that already has its ID property set (to $this->id).", E_USER_ERROR);

    $sql = "INSERT INTO $this->table (date, title, content,image,user) VALUES (:date, :title, :content,:image, :username)";
    $this->db->queryMysql($sql,$this->date,$this->title,$this->content,$this->image,$this->username);
  }

  public function update() {
    if (is_null($this->id))
      trigger_error ("News::update(): Attempt to update a News object that does not have its ID property set.", E_USER_ERROR);
    $sql = "UPDATE $this->table SET date=:date, title=:title, content=:content, image=:image WHERE id = :id";
    $this->db->queryMysql($sql,$this->date,$this->title,$this->content,$this->image,$this->id);
  }

  public function delete() {
    if (is_null($this->id)) trigger_error ("News::delete(): Attempt to delete a News object that does not have its ID property set.", E_USER_ERROR);
    $sql="DELETE FROM $this->table WHERE id = :id LIMIT 1";
    $this->db->queryMysql($sql,$this->id);
  }
}

?>
