<?php include $this->header ?>
<script src="js/effects.js"></script>

<div class="newsNavigation newsNavigationUser row">
  <div id="" class="col-md-3 col-xs-3 prev">
    <?php if($this->navigation['prev']){?>
      <a class="systemLink" href="<?=$this->urls['viewNewsURL']?><?=$this->navigation['prev']?>">&lt;&nbsp;<span>Previous<span> News</span></span></a>
    <?php }?>
  </div>

  <div id="" class="col-md-3 col-xs-3 first">
    <?php if($this->navigation['first']){?>
      <a class="systemLink" href="<?=$this->urls['viewNewsURL']?><?=$this->navigation['first']?>">&Lt;&nbsp;<span>First<span> News</span></span></a>
    <?php }?>
  </div>

  <div id="" class="col-md-3 col-xs-3 last">
    <?php if($this->navigation['last']){?>
      <a class="systemLink" href="<?=$this->urls['viewNewsURL']?><?=$this->navigation['last']?>"><span>Last<span> News</span></span>&nbsp;&Gt;</a>
    <?php }?>
  </div>

  <div id="" class="col-md-3 col-xs-3 next">
    <?php if($this->navigation['next']){?>
      <a class="systemLink" href="<?=$this->urls['viewNewsURL']?><?=$this->navigation['next']?>"><span>Next<span> News</span></span>&nbsp;&gt;</a>
    <?php }?>
  </div>
</div>

<div class="statusRowHidden">                 <!-- table to align status text without moving undelying elements -->
  <?php if ($this->errorMessage){ ?>
    <div align="center">
      <div id="errorMessage" class="errorMessage" onclick="statusVanish(this);">
        <?=$this->errorMessage ?> 
      </div>
    </div>
  <?php } ?>
  <?php if ($this->statusMessage){ ?>
    <div align="center">
      <div id="statusMessage" class="statusMessage" onclick="statusVanish(this);">
        <?=$this->statusMessage ?>
      </div>
    </div>
  <?php } ?>
</div>

<article id="viewNewsContainer">
  <h2 id="title"><?=$this->news->title?></h2>
  <img id="image" class="responsive-image" src="<?=$this->news->image?>">
  <div id="content"><?=$this->news->content?></div>
  <div class="clearfix"></div>
</article>

<div class="info">
  <div id="aNewsPubDate">Published on [<span id="userNewsDate"><?=$this->news->date?></span>]</div>
  <div id="aNewsUser">by "<u><?=$this->news->username?></u>"
    <?php if($this->news->userArchive==0){?>
      <a class="systemLink" id="editNewsLink" href="<?=$this->urls['editNewsURL']?><?=$this->news->id?>">[edit]</a>
    <?php }?>
  </div>
</div>

<?php include $this->menu ?>
  
<!-- <div class="menu">
  <div><a class="operations" href="<?=$this->urls['archiveURL']?>"><span>News Archive</span></a></div>
  <div><a class="operations" href="<?=$this->urls['homepageURL']?>"><span>Return to Homepage</span></a></div>
</div> -->

<?php include $this->footer ?>

