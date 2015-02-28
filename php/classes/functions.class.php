<?php

class Functions{
  protected $manageNews;

  public function __construct(){
    $this->manageNews=new ManageNews();
  }

  public function sanitizeString($var){
    $var=strip_tags($var);
    $var=htmlentities($var);
    if (get_magic_quotes_gpc())
      $var=stripslashes($var);
    return $var;
  }

  public function sanitizeData($data){
    if(is_array($data))
      foreach($data as &$x)
        $x=$this->sanitizeString($x);
  }

  public function sanitizeOutputData($formValues){
    foreach($formValues as $key=>&$x)
      if($key == 'content')
        $x=$this->trimString(strip_tags($x,"<b>"));
      else
        $x=$this->sanitizeString($x);
    return $formValues;
  }

  public function trimString($s){
    $s=preg_replace('/  +/',' ',$s);          //more than 1 spase
    $s=preg_replace('/^ | $/','',$s);         //spaces at the start/end of content
    return $s;
  }

  public function go($address) {
    header("Location: $address");
    exit();
  }

  public function uploadImage(){
    $upload_dir='../'.PREVIEW_IMAGES_PATH;
    $preview_url=PREVIEW_IMAGES_PATH;
    $filename='';
    $result='ERROR';
    $result_msg='';
    $allowed_image=array('image/gif','image/jpeg','image/jpg','image/pjpeg','image/png');

    if(!is_dir($upload_dir)) mkdir($upload_dir);

    if(isset($_FILES['imageFile'])){
      if($_FILES['imageFile']['error'] == UPLOAD_ERR_OK){
        if(in_array($_FILES['imageFile']['type'],$allowed_image)){
          if(filesize($_FILES['imageFile']['tmp_name']) <= PICTURE_SIZE_ALLOWED){
            $filename=$_FILES['imageFile']['name'];                                                      // filename
            $moveResult=move_uploaded_file($_FILES['imageFile']['tmp_name'],$upload_dir.$filename);
            $result='OK';
          }
          else{
            $filesize=filesize($_FILES['imageFile']['tmp_name']);
            $filetype=$_FILES['imageFile']['type'];
            $result_msg=PICTURE_SIZE;
          }
        }
        else
          $result_msg=SELECT_IMAGE;
      }
      elseif($_FILES['imageFile']['error'] == UPLOAD_ERR_INI_SIZE)
        $result_msg='The uploaded file exceeds the upload_max_filesize directive in php.ini';
      else
        $result_msg='Unknown error';
    }
    $filename=$this->sanitizeString($filename);

    echo '<script>'."\n";
    echo 'var parDoc = window.parent.document;';
    if($result != 'OK')
      echo "parDoc.getElementById('picture_error').innerHTML = '".$result_msg."';";
    if($filename != ''){
      echo "parDoc.getElementById('editNewsImage').src='$preview_url$filename';";       // an image
      echo "parDoc.getElementById('image').value='$preview_url$filename';";             // hidden field
    }
    echo "\n".'</script>';
    exit();
  }
}

?>
