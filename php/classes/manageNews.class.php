<?php

class ManageNews extends SuperNews{
  public function getById($id,$navigation=0,$user=""){
    $sql = "SELECT * FROM $this->table WHERE id = :id";
    $st=$this->db->queryMysql($sql,$id);

    $row = $st->fetch();
    if(!$row) return false;
    if(!$navigation) return new News($row);
    return (array ("news" => new News($row), "navigation"=>$this->getNavigationPages($id,$user)));     //get news ids to set navigation links
  }

  public function getList($username="", $startRow=0, $numRows=1000000, $order="date DESC",$subSort=0) {
    if($subSort){                                       //search within a portion of data (within newsOnPage)
      $sql = "SELECT * FROM (SELECT * FROM $this->table ";
      if($username!="")
        $sql.="WHERE user=:username AND user_archive=0 ORDER BY date DESC LIMIT :startRow,:numRows) n ORDER BY $order";
      else
        $sql.="ORDER BY date DESC LIMIT :startRow,:numRows) n ORDER BY $order";
    }
    else{
      $sql = "SELECT * FROM $this->table ";
      if($username!="")
        $sql.="WHERE user=:username AND user_archive=0 ORDER BY $order LIMIT :startRow,:numRows";
      else
        $sql.="ORDER BY $order LIMIT :startRow,:numRows";
    }
    $st=$this->db->queryMysql($sql,$username,$startRow,$numRows);

    $news = array();
    while ($row = $st->fetch())
      $news[] = new News($row);
    return $news;
  }

  public function getListAll($username="", $order="date DESC") {
    $sql = "SELECT * FROM $this->table ";
    if($username!="") $sql.="WHERE user=:username ORDER BY $order";
    else $sql.="ORDER BY $order";

    $st=$this->db->queryMysql($sql,$username);

    $news = array();
    while ($row = $st->fetch())
      $news[] = new News($row);
    return $news;
  }

  public function deleteAll($user){
    $sql="DELETE FROM $this->table WHERE user='$user'";
    $this->db->queryMysql($sql);
  }

  public function tocsv($user=""){
    if($user)
      $sql = "SELECT * FROM $this->table WHERE user=':user'";
    else
      $sql = "SELECT * FROM $this->table";
    $st=$this->db->queryMysql($sql,$user);

    $dir="tmp";
    if (!is_dir($dir)) mkdir($dir);
    $filename = "tmp/db_news_export_".date('dmy_His',time())."_".substr(microtime(), 2,4).".csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('Id','Date','Title','Content','Image','User'));
    foreach($results as $row) {
      fputcsv($handle, array($row['id'], $row['date'], $row['title'], $row['content'], $row['image'], $row['user']));
    }
    fclose($handle);

    header("Content-Type: application/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=".$filename);
    readfile($filename);
  }

  private function getNavigationPages($id,$user){
    if($user != "") $sql="SELECT id FROM $this->table WHERE user=:user ORDER BY date DESC";
    else $sql="SELECT id FROM $this->table ORDER BY date DESC";

    $st=$this->db->queryMysql($sql,$user);
    $rows=$st->fetchAll();

    $first=$last=$prev=$next="";
    if($rows&&count($rows)>1){
      for($i=0;$i<count($rows);$i++){
        if($rows[$i]['id']==$id){
          if($i==0){                            //first news
            $last=$rows[count($rows)-1]['id'];
            $next=$rows[$i+1]['id'];
            break;
          }
          elseif($i==count($rows)-1){           //last news
            $first=$rows[0]['id'];
            $prev=$rows[$i-1]['id'];
            break;
          }
          else{                                 //other news
            $first=$rows[0]['id'];
            $last=$rows[count($rows) - 1]['id'];
            $prev=$rows[$i - 1]['id'];
            $next=$rows[$i + 1]['id'];
            break;
          }
        }
      }
    }
    return (array("first"=>$first,"last"=>$last,"prev"=>$prev,"next"=>$next));
  }

  public function getRowsCount($username=""){
    if($username!="") $sql="select count(id) FROM $this->table where user=:user AND user_archive=0";                                    // all rows in the table
    else $sql="select count(id) from $this->table";                                    // all rows in the table
    $st=$this->db->queryMysql($sql,$username);
    $row=$st->fetch();
    if(!$row) return false;
    return $row[0];
  }

  public function moveToArchive($user) {
    $sql="update $this->table set user_archive=1 where user=:user and user_archive=0";
    $this->db->queryMysql($sql,$user);
  }

  public function deleteOldImage($image) {
    $sql="select id from $this->table where image=:image";
    $st=$this->db->queryMysql($sql,$image);
    if(!$st->rowCount()) unlink($image);
  }

  public function getUserByNews($newsId){
    $sql="SELECT user FROM $this->table WHERE id=$newsId";
    $st=$this->db->queryMysql($sql,$newsId);
    $row = $st->fetch();
    if(!$row) return false;
    return $row['user'];
  }
}

?>
