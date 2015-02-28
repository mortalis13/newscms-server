<?php

class Database{
  private static $db = null;
  private $conn;

  public static function getConnection(){
    if(self::$db == null) self::$db=new Database();
    return self::$db;
  }

  private function __construct(){
    $this->conn=new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
    $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    $this->conn->query("SET NAMES 'utf8'");
  }

  public function queryMysql(){
    $sql=func_get_arg(0);
    $st=$this->conn->prepare($sql);
    preg_match_all("/:.+?\b/",$sql,$preparedArgs);              //all parameters :param_name

    $paramIdx=0;
    if($preparedArgs[0] != null){
      for($i=1; $i < func_num_args(); $i++){
        $arg=func_get_arg($i);
        if($arg==="") continue;
        switch(gettype($arg)){
          case "integer":
            $type=PDO::PARAM_INT;break;
          case "string":
            $type=PDO::PARAM_STR;break;
          case "boolean":
            $type=PDO::PARAM_BOOL;break;
        }
        $st->bindValue($preparedArgs[0][$paramIdx++],$arg,$type);
      }
    }

	try{
    	$st->execute();
	}
	catch(Exception $e){
		var_dump($e->getMessage());
	}
    return $st;
  }

  public function __destruct(){
    if($this->conn) $this->conn=null;
  }
}

?>
