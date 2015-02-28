<?php

// require_once "config.php";

// $docRoot=$_SERVER['DOCUMENT_ROOT'];
// require_once $docRoot.'/config.php';

class Messages{
  private $data;

  public function __construct(){
    $file=MESSAGES_FILE;
    if(!file_exists(MESSAGES_FILE)) $file="../".MESSAGES_FILE;
    $this->data=parse_ini_file($file);
  }

  public function get($name,$format=false){
    if($format) return $this->data[$this->formatMessage($name)];
    return $this->data[$name];
  }

  private function formatMessage($text){
    $tmp="";
    for($i=0; $i < strlen($text); $i++)
      if(ctype_upper($text[$i]))
        $tmp.="_".$text[$i];
      else
        $tmp.=$text[$i];
    $tmp=strtoupper($tmp);
    return $tmp;
  }
}
?>