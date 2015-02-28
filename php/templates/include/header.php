<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->sitename." - ".$this->pageTitle?></title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css" /> -->

    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/editNews.css" />
    <link rel="stylesheet" href="css/listNews.css" />
    <link rel="stylesheet" href="css/loginRegister.css" />
    <link rel="stylesheet" href="css/archive.css" />
    <link rel="stylesheet" href="css/homepage.css" />
    <link rel="stylesheet" href="css/viewNews.css" />
    <link rel="stylesheet" href="css/editProfile.css" />

    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="css/media.css" />

    <!-- <link rel="shortcut icon" href="images/system/favicon.png" type="image/x-icon"/> -->
    <!-- <link rel="icon" href="http://newscms.co.nf/images/system/favicon.png" type="image/png"/> -->
    <!-- <link rel="icon" type="image/png" href="favicon.png"/> -->
    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- <script src="js/jquery-2.0.0.min.js"></script>  -->
    <!-- <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script> -->

    <script src="js/custom.js"></script>
    <script src="js/add.js"></script>

    <?php if(isset($_SESSION['username'])){?>
    <script>
//      setTimeout(function(){location='admin.php?action=logout'},1000*60*5)    //5min auto logout
    </script>
    <?php }?>
  </head>
  <body>

    <div class="container <?=$this->template ?>">
      <header class="row">
        <div class="headerLogo"><a href="<?=$this->urls['homepageURL']?>"><img src="images/system/logo.jpg"/></a></div>
        <div class="headerTitle text-center"><a class="homeLink" href="<?=$this->urls['homepageURL']?>">Your News Portal</a></div>
      </header>
