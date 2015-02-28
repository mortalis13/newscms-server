<?php

class SuperUser extends Entity{
  protected function getNews($newsId){
    $news=$this->manageNews->getById((int)$newsId,1);
    if(!$news) return false;

    $this->news=$news['news'];
    $this->pageTitle="User: ".$this->news->title;
    $this->news->content=nl2br($this->functions->trimString($this->news->content));
    $this->navigation=$news['navigation'];

    return true;
  }

  protected function setPages(){
    if(isset($_POST['newsOnPage'])){
      $newsOnPage=$this->sanitizeString($_POST['newsOnPage']);
      setcookie("newsOnPageUser",$newsOnPage,time() + 3600 * 24 * 1,"/");    //1 day lifetime
    }
    elseif(isset($_COOKIE['newsOnPageUser']))
      $newsOnPage=$this->sanitizeString($_COOKIE['newsOnPageUser']);
    else
      $newsOnPage=NEWS_ON_PAGE;

    if(isset($_GET['page'])) $page=$this->sanitizeString($_GET['page']);
    else $page=1;

    $pagesCount=ceil($this->totalRows / $newsOnPage);
    if($page > $pagesCount) $this->go("index.php?error=noPage");

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

    if($pagesCount>=MAX_PAGES*2){
      $useEllipsis=true;
      $maxOutPages=MAX_PAGES;
      if($page>=MAX_PAGES)
        $maxOutPages=$page+1;
      if($page>=MAX_PAGES*2)
        $startPage=$page-MAX_PAGES+1;
      if($page>=$pagesCount-MAX_PAGES+1){
        $showRestPages=true;
        $maxOutPages=$pagesCount;
        if($page<$pagesCount-MAX_PAGES+3)
          $startPage=$page-1;
        else
          $startPage=$pagesCount-MAX_PAGES+1;
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
    if($this->totalRows=$this->manageNews->getRowsCount()){
      $this->setPages();
      $startRow=($this->page - 1) * $this->newsOnPage;
      $news=$this->manageNews->getList("",$startRow,$this->newsOnPage);
      $this->news=$news;
    }
    else{
      $this->newsOnPage=NEWS_ON_PAGE;
    }
  }

  protected function setArchiveData(){
    if($this->totalRows=$this->manageNews->getRowsCount()){
	  $this->sort=DEFAULT_SORT;
      $news=$this->manageNews->getListAll("",$this->sort);
      $this->news=$news;
    }
  }

  protected function setFillers(){
    $this->fillerHeight=false;
    $newsOnPageCount=count($this->news);                    //place pages numbers dynamically (up/down) in relation to the number of table rows
    $newsOnPage=$this->newsOnPage;
    if($newsOnPageCount < $newsOnPage && $this->pagesCount > 1){
      $emptyRowsCount=$newsOnPage - $newsOnPageCount;
      $rowHeight=45;
      $this->fillerHeight=$emptyRowsCount * $rowHeight + 6;
    }
  }

  protected function show($template,$source=""){
    parent::show($template,"user");
  }
}

?>
