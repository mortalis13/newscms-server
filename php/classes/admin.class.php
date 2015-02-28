<?php

class Admin extends SuperAdmin{
  public function editProfile(){
    $this->pageTitle="Admin: Edit Profile";
    $this->show("editProfile");
  }

  public function deleteProfile(){
    $sql="DELETE FROM $this->table WHERE name=:user";
    $this->db->queryMysql($sql,$_SESSION['username']);
    $this->manageNews->moveToArchive($_SESSION['username']);
    $this->logout();
  }

  public function register(){
    $this->pageTitle="Admin: Register";

    if(isset($_POST['register'])){
      $user=$_POST['username'];
      $pass=$_POST['password'];
      $repeatPass=$_POST['repeat_password'];
      $this->sanitizeData([&$user,&$pass,&$repeatPass]);

      $checkData=$this->check->checkRegisterData($user,$pass,$repeatPass);
      if($checkData!==true){
        $this->errorMessage=$checkData;
        $this->show("regForm");
      }
      else{
        $this->addUser($user, $pass);
        $this->go("admin.php?action=login&register=true");           //auto login from the page
      }
    }
    else{
      if(isset($_SESSION['username']))
        $this->go("admin.php?error=registerTry");
      else{
        $this->setURLs("regForm");
        $this->show("regForm");
      }
    }
  }

  public function login(){
    $this->pageTitle="Admin: Login";

    if(isset($_SESSION['username'])){
      if(isset($_GET['register'])){
        $this->register=true;
        $this->show("loginForm");          //first visit (no attempts to login)
      }
      else
        $this->go("admin.php");
    }
    elseif(isset($_POST['login'])||isset($_COOKIE['username'])){
      if(isset($_COOKIE['username'])){
        $user=$_COOKIE['username'];
        $pass=$_COOKIE['password'];
      }
      else{
        $user=$_POST['username'];
        $pass=$_POST['password'];
      }
      $this->sanitizeData([&$user,&$pass]);

      if(!$this->checkUserLogin($user, $pass)){
        $this->errorMessage=$this->messages->get("LOGIN_INCORRECT");
        $this->show("loginForm");
      }
      else{
        if(isset($_POST['redirect']) && $_POST['redirect'])             //redirect to the editNews if came from a user news article
          $this->go($_POST['redirect']);
        else
          $this->go("admin.php");                                //login and go to listNews
      }
    }
    else{
      if(isset($_SERVER['REQUEST_URI'])){                            //before redirect prepare the data
        $requestURI=$_SERVER['REQUEST_URI'];                            //if user selected [edit] link and admin is not logged in
        $part=substr($requestURI,strrpos($requestURI, "/")+1);
        if($part!='admin.php'&&$part!='admin.php?action=login')
          $this->redirect=$this->sanitizeString($requestURI);
      }
      $this->show("loginForm");      //first enter to login form page
    }
  }

  public function logout(){
    $this->destroySession();
    $this->go("admin.php");                    //to login page
  }

  public function newNews(){
    $this->pageTitle = "Admin: New News";
    $this->formAction = "newNews";

    if (isset($_POST['saveChanges'])){
      $this->addNews($_POST);
      $this->go("admin.php?status=changesSaved");
    }
    elseif (isset($_POST['cancel'])){
      $this->deleteTempImage();
      $this->go("admin.php");
    }
    else{
      $this->news = new News();
      $this->show("editNews");           //new news form
    }
  }

  public function editNews(){
    $this->pageTitle = "Admin: Edit News";
    $this->formAction = "editNews";

    if (isset($_POST['saveChanges'])){
      $this->saveNews($_POST);
      $this->go("admin.php?status=changesSaved");
    }
    elseif (isset($_POST['cancel'])){
      if(isset($_POST['referer'])&&$_POST['referer'])          //detects the previous page which requested this news article
        $this->go($_POST['referer']);                 //if it came from a user news ([edit] link) and then cancelled
      else{
        $this->deleteTempImage();
        $this->go("admin.php");                          //or from admin listNews page
      }
    }
    elseif (isset($_GET['newsId'])){
      $newsId=$this->sanitizeString($_GET['newsId']);
      if(!$this->getNews($newsId))
        $this->go("admin.php?error=noNewsId");
      else{
        $user=$this->manageNews->getUserByNews($newsId);
        if($user==$_SESSION['username'])
          $this->show("editNews");
        else
          $this->go("index.php?action=viewNews&newsId=$newsId&error=incorrectUser");
      }
    }
  }

  public function previewNews(){                                 //preview before saving
    if(isset($_POST['preview'])){
      $this->pageTitle="Admin: Preview News";
      $this->news=new News($_POST);
      $this->news->content=nl2br($this->functions->trimString($this->news->content));
      $this->show("previewNews");
    }
  }

  public function deleteNews(){
    if (isset($_GET['newsId'])){
      $newsId=$this->sanitizeString($_GET['newsId']);
      if (!$news = $this->manageNews->getById((int)$newsId))
        $this->go("admin.php?error=noNewsId");
      $news->delete();
      $this->go("admin.php?status=newsDeleted");
    }
    elseif(isset($_GET['newsRange'])){                        //can be set to a range of news to delete
      $range=$_GET['newsRange'];                              //but initially the request delets all news from the DB
      if($range=='all'){
        $this->manageNews->deleteAll($_SESSION['username']);
        $this->go("admin.php?status=allNewsDeleted");
      }
    }
  }

  public function listNews(){
    $this->pageTitle = "Admin: All News";
    $this->setListData();
    $this->setMessages();
    $this->setFillers();
    $this->show("listNews");
  }
}

?>
