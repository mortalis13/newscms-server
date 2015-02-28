<?php

class Check{
  protected $db;
  protected $messages;
  protected $table;

  public function __construct(){
    $this->db=Database::getConnection();
    $this->messages=new Messages();
    $this->table=DB_TABLE_PREFIX.DB_USER_TABLE;
  }

  public function checkUsernameAjax(){
    if(isset($_POST['user'])){                  // check username availability in the db
      $user=$_POST['user'];
      if($_POST['checktype'] == 'db'){
        $checkUsernameAvail=$this->checkUsernameAvail($user);
        if($checkUsernameAvail===true)
          return "<span class='valid'>&nbsp;&#x2714; ".$this->messages->get("USERNAME_AVAILABLE")."</span>";
        else
          return "<span class='invalid'>&nbsp;&#x2718; ".$checkUsernameAvail."</span>";
      }
    }
  }

  public function checkRegisterData($user,$pass,$repeatPass){
    $checkUsername=$this->checkUsername($user);
    if($checkUsername!==true) return $checkUsername;

    if($this->checkUsernameAvail($user)!==true) return $this->messages->get("USERNAME_TAKEN");

    $checkPassword=$this->checkPassword($pass,$repeatPass);
    if($checkPassword!==true) return $checkPassword;

    return true;
  }

  private function checkUsername($user){
    if(strlen($user) < USER_LENGTH) return $this->messages->get("USERNAME_INCORRECT_LENGTH");
    if(preg_match("/[^a-zA-Z0-9._-]/",$user)) return $this->messages->get("USERNAME_INCORRECT_CONTENT");
    return true;
  }

  private function checkUsernameAvail($user) {
    $sql="SELECT * FROM $this->table WHERE name=:user";
    $st=$this->db->queryMysql($sql,$user);
    if($st->rowCount()) return $this->messages->get("USERNAME_TAKEN");
    return true;
  }

  private function checkPassword($pass,$repeatPass){
    if(strlen($pass) < PASS_LENGTH) return $this->messages->get("PASSWORD_INCORRECT_LENGTH");
    if(!preg_match("/[a-z]/",$pass) || !preg_match("/[A-Z]/",$pass)
       || !preg_match("/[0-9]/",$pass) || !preg_match("/[!@#$%^&_-]/",$pass))
          return $this->messages->get("PASSWORD_INCORRECT_CONTENT");
    if($pass!=$repeatPass) return $this->messages->get("PASSWORDS_NOT_EQUAL");
    return true;
  }
}

?>
