<?php

class SuperAdmin extends Entity{
  protected function addUser($user,$pass) {
    $token=hash('md5',PASS_SALT.$pass.PASS_SALT);
    $sql="INSERT INTO $this->table VALUES (:name, :password)";
    $this->db->queryMysql($sql,$user,$token);
    $_SESSION['username']=$user;                                        //username for a session to surf through the site with one account
  }

  private function getUser($user) {
    $sql="SELECT password FROM $this->table WHERE name = :name";
    $st=$this->db->queryMysql($sql,$user);
    return $st->fetch();
  }

  protected function checkUserLogin($user,$pass) {
    $userData=$this->getUser($user);

    if(!$userData) return false;
    if(isset($_COOKIE['password']))
      $token=$pass;
    else
      $token=hash('md5',PASS_SALT.$pass.PASS_SALT);

    if($token != $userData['password']) return false;
    $_SESSION['username']=$user;
    if(!isset($_COOKIE['username'])){                               //remember user and pass
//      setcookie("username",$user,time() + 3600 * 24 * 1,"/");
//      setcookie("password",$token,time() + 3600 * 24 * 1,"/");
    }
    return true;
  }

  protected function destroySession(){
    $_SESSION=array();
    if(session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(),'',time() - 2592000,'/');
    if(isset($_COOKIE['username'])){
      setcookie("username",'',time() - 2592000,'/');
      setcookie("password",'',time() - 2592000,'/');
    }
    session_destroy();
  }

  protected function addNews($data){
    $news=new News();
    $formValues=$this->functions->sanitizeOutputData($data);
    $formValues['image']=$this->moveImageOnSave($formValues['image']);
    $news->storeFormValues($formValues);
    $news->insert();
  }

  protected function saveNews($data){
    $formValues=$this->functions->sanitizeOutputData($data);
    if(!$news=$this->manageNews->getById((int)$formValues['newsId']))
      $this->go("admin.php?error=noNewsId");
    $formValues['image']=$this->moveImageOnSave($formValues['image']);
    $news->storeFormValues($formValues);
    $news->update();
    if($formValues['image']!=$formValues['inputImage'])
      $this->manageNews->deleteOldImage($formValues['inputImage']);
  }

  protected function getNews($newsId){
    $news=$this->manageNews->getById((int)$newsId,1,$_SESSION['username']);
    if(!$news) return false;

    $this->news=$news['news'];
    $this->news->content=$this->functions->trimString($this->news->content);
    $this->navigation=$news['navigation'];

    if(isset($_SERVER['HTTP_REFERER'])){                    //prepare source page data
      $referer=$_SERVER['HTTP_REFERER'];                    //will be used in case of Cancel button clicked
      if(strpos($referer,"viewNews"))
        $this->referer=$referer;
    }

    return true;
  }

  protected function setPages(){
    if(isset($_POST['newsOnPage'])){
      $newsOnPage=$this->sanitizeString($_POST['newsOnPage']);
      setcookie("newsOnPageAdmin",$newsOnPage,time() + 3600 * 24 * 1,"/");    //1 day lifetime
    }
    elseif(isset($_COOKIE['newsOnPageAdmin']))
      $newsOnPage=$this->sanitizeString($_COOKIE['newsOnPageAdmin']);
    else
      $newsOnPage=NEWS_ON_PAGE;

    if(isset($_GET['page'])) $page=$this->sanitizeString($_GET['page']);
    else $page=1;

    $pagesCount=ceil($this->totalRows / $newsOnPage);
    if($page > $pagesCount) $this->go("admin.php?error=noPage");

    if($page == 1){
      $prev=1;
      $next=2;
    }
    elseif($page == $pagesCount){
      $prev=$page - 1;
      $next=$page;
    }
    else{
      $prev=$page - 1;
      $next=$page + 1;
    }

    $maxOutPages=$pagesCount;
    $startPage=2;
    $showRestPages=false;
    $useEllipsis=false;

    if($pagesCount >= MAX_PAGES * 2){
      $useEllipsis=true;
      $maxOutPages=MAX_PAGES;
      if($page >= MAX_PAGES)
        $maxOutPages=$page + 1;
      if($page >= MAX_PAGES * 2)
        $startPage=$page - MAX_PAGES + 1;
      if($page >= $pagesCount - MAX_PAGES + 1){
        $showRestPages=true;
        $maxOutPages=$pagesCount;
        if($page < $pagesCount - MAX_PAGES + 3)
          $startPage=$page - 1;
        else
          $startPage=$pagesCount - MAX_PAGES + 1;
      }
    }

    $this->pagesCount=$pagesCount;
    $this->newsOnPage=$newsOnPage;
    $this->maxOutPages=$maxOutPages;
    $this->startPage=$startPage;

    $this->showRestPages=$showRestPages;
    $this->useEllipsis=$useEllipsis;

    $this->page=$page;
    $this->prev=$prev;
    $this->next=$next;
  }

  protected function setListData(){
    if($this->totalRows=$this->manageNews->getRowsCount($_SESSION['username'])){
	  $this->sort=DEFAULT_SORT;
      $this->setPages();

      $startRow=($this->page - 1) * $this->newsOnPage;
      $news=$this->manageNews->getList($_SESSION['username'],$startRow,$this->newsOnPage,$this->sort,$this->subSort);
      $this->news=$news;
    }
    else{
      $this->newsOnPage=NEWS_ON_PAGE;
    }
  }

  protected function setFillers(){
    $this->fillerHeight=false;
    $newsOnPageCount=count($this->news);                    //place pages numbers dynamically (up/down) in relation to the number of table rows
    $newsOnPage=$this->newsOnPage;
    if($newsOnPageCount < $newsOnPage && $this->pagesCount > 1){
      $emptyRowsCount=$newsOnPage - $newsOnPageCount;
      $rowHeight=50;
      $this->fillerHeight=$emptyRowsCount * $rowHeight + 16;
    }
  }

  protected function show($template,$source=""){
    parent::show($template,"admin");
  }

  protected function deleteTempImage(){
    $dir=PREVIEW_IMAGES_PATH;
    if(is_dir($dir)){
      $files=scandir($dir);
      if(count($files > 2))
        for($i=2; $i < count($files); $i++)
          if(!is_dir($files[$i]))
            unlink($dir.$files[$i]);
      if(count(scandir($dir) == 2))
        rmdir($dir);
    }
  }

  protected function moveImageOnSave($image){
    $movedImage=IMAGES_PATH.basename($image);
    rename($image,$movedImage);
    $this->deleteTempImage($image);
    return $movedImage;
  }
}

?>
