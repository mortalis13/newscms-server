
<div class="menu">
<?php 
  $links="";

/*
  $menuItems=[
    'Return to Homepage'=>$this->urls['homepageURL'],
    'News Archive'=>$this->urls['archiveURL'],
    'Export All News To CSV'=>$this->urls['exportCSVURL'],
    'Add a News'=>$this->urls['newNewsURL'],
    'Delete This News'=>$this->urls['deleteNewsURL'].$this->news->id
  ];
*/
  
  switch($this->template){
    case 'homepage':
      $links=array('News Archive'=>$this->urls['archiveURL'],
                   'Export All News To CSV'=>$this->urls['exportCSVURL']); 
    break;

    case 'archive':
      $links=array('Return to Homepage'=>$this->urls['homepageURL'],
                   'Export All News To CSV'=>$this->urls['exportCSVURL']); 
    break;

    case 'viewNews':
      $links=array('Return to Homepage'=>$this->urls['homepageURL'],
                   'News Archive'=>$this->urls['archiveURL']);
    break;

    case 'listNews':
      $links=array('Add a News'=>$this->urls['newNewsURL'],
                   'Export All News To CSV'=>$this->urls['exportCSVURL']);
    break;

    case 'newNews':
      $links=array('Add a News'=>$this->urls['newNewsURL']);
      break;

    case 'editNews':
      $links=array('Add a News'=>$this->urls['newNewsURL']);
      if ($this->news->id)
        $links['Delete This News']=$this->urls['deleteNewsURL'].$this->news->id;
    break;
  }
?>

<?php foreach($links as $title=>$link){ ?>
  <?php 
    $class="";
    if($this->template=='editNews' && $title=='Delete This News')
      $class="delete";
  ?>
  <div><a class="operations <?=$class?>" href="<?=$link?>"><span><?=$title?></span></a></div>
<?php } ?>
</div>