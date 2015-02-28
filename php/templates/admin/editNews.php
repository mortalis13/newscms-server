<?php include $this->header ?>
<script src="js/style.js"></script>
<?php include $this->adminHeader ?>

<h1 class="pageHeader"><?=$this->pageTitle?></h1>

<?php $showToolbar=false ?>

<!-- Navigation -->

<?php if($this->formAction=='editNews'){?>
  <div class="newsNavigation newsNavigationAdmin row">
    <div id="" class="col-md-3 col-xs-3 prev">
      <?php if($this->navigation['prev']){?>
        <a href="<?=$this->urls['editNewsURL']?><?=$this->navigation['prev']?>">&lt;&nbsp;<span>Previous<span> News</span></span></a>
      <?php }?>
    </div>

    <div id="" class="col-md-3 col-xs-3 first">
      <?php if($this->navigation['first']){?>
        <a href="<?=$this->urls['editNewsURL']?><?=$this->navigation['first']?>">&Lt;&nbsp;<span>First<span> News</span></span></a>
      <?php }?>
    </div>

    <div id="" class="col-md-3 col-xs-3 last">
      <?php if($this->navigation['last']){?>
        <a href="<?=$this->urls['editNewsURL']?><?=$this->navigation['last']?>"><span>Last<span> News</span></span>&nbsp;&Gt;</a>
      <?php }?>
    </div>

    <div id="" class="col-md-3 col-xs-3 next">
      <?php if($this->navigation['next']){?>
        <a href="<?=$this->urls['editNewsURL']?><?=$this->navigation['next']?>"><span>Next<span> News</span></span>&nbsp;&gt;</a>
      <?php }?>
    </div>
  </div>
<?php }else{?>
  <div id="navDivNewNews"></div>
<?php }?>

<!-- Main form -->

<form id="editNewsForm" class="form-horizontal inputForms editNewsForm" action="admin.php?action=<?=$this->formAction?>" method="post" enctype="multipart/form-data">
  <?php if ($this->errorMessage) {?>
    <div align="center"><div class="errorMessage"><?=$this->errorMessage ?></div></div>
  <?php }?>

  <div id="editNewsDate" class="text-center formHeader">
    <div id="newsDate"><?=$this->news->date?></div>
    <img id="previewNewsAdmin" title="Preview"
         onclick='previewNews(<?php json_encode($this->news);?>)'
         onmouseover="previewOver(this)" src="images/system/preview3.png"/>
    <?php if($this->formAction=='editNews'){?>
      <div id="viewNewsAdmin" title="View"
           onclick="viewNewsAdmin(<?=$this->news->id?>)"
           onmouseup="viewNewsAdminMouseUp(event,<?=$this->news->id?>)"
           onmousedown="viewNewsAdminMouseDown(event)">
      </div>
    <?php }?>
  </div>

  <div class="form-group">
    <label for="editNewsImage" class="lEditNews control-label col-sm-4" onclick="$('#editNewsImage').click()">News Image</label>
    <img id="editNewsImage" class="responsive-image" src="<?=$this->news->image ?>" onclick="$('#imageFile').click()"/>
    <span id="picture_error"></span>
    <input type="file" name="imageFile" id="imageFile" onchange="return imageUpload(this)" style="display:none"/>
  </div>

  <div class="form-group">
    <label for="editNewsTitle" class="lEditNews control-label col-sm-4 col-xs-4">News Title</label>
    <div class="col-sm-8 col-xs-8 control-wrapper control-input">
      <input type="text" class="form-control" name="title" id="editNewsTitle" required autofocus maxlength="255"
             value="<?=$this->news->title?>" onfocus="this.select()" autocomplete="off"
             onkeyup="editKey(event)"/>
    </div>
  </div>

  <?php if($showToolbar): ?>
    <div id="textMenu">
        <img id="bold" src="images/system/bold.png" title="Bold" onclick="setBold(editNewsContent)" onmouseover="boldOver(this)"/>
        <img id="italic" src="images/system/italic.png" title="Italic" onmouseover="boldOver(this)"/>
        <img id="underline" src="images/system/underline.png" title="Underline" onmouseover="boldOver(this)"/>
    </div>
  <?php endif; ?>

  <div class="form-group">
    <label for="editNewsContent" class="lEditNews control-label col-sm-4 col-xs-4">News Content</label>
    <div class="col-sm-8 col-xs-8 control-wrapper control-input">
      <textarea class="form-control" name="content" id="editNewsContent" required maxlength="1000000"
                onkeyup="editKey(event)"><?=$this->news->content?></textarea>
    </div>
  </div>

  <div class="buttons">
    <input type="submit" name="saveChanges" value="Save Changes" accesskey="s"/>
    <input type="submit" name="cancel" formnovalidate value="Cancel" accesskey="c"/>
  </div>

  <input type="hidden" name="newsId" value="<?=$this->news->id ?>"/>
  <input type="hidden" name="username" value="<?=$_SESSION['username'] ?>" id="adminUsername"/>
  <input type="hidden" name="image" id="image" value="<?=$this->news->image?>"/>
  <input type="hidden" name="inputImage" id="inputImage" value="<?=$this->news->image?>"/>
  <input type="hidden" name="referer" value="<?php if($this->referer) echo $this->referer;?>"/>
</form>

<!-- Hidden form to send data -->

<form id="previewForm" action="admin.php?action=previewNews" target="_blank" method="post" style="display:none">
  <input type="hidden" name="preview" value="true"/>
  <input type="hidden" name="date"/>
  <input type="hidden" name="title"/>
  <input type="hidden" name="content"/>
  <input type="hidden" name="image"/>
  <input type="hidden" name="username"/>
</form>

<iframe name="upload_iframe" id="upload_iframe" style="display:none;"></iframe>

<!-- Buttons -->

<?php include $this->menu ?>

<!-- <div class="menu">
  <div><a class="operations" href="<?=$this->urls['newNewsURL']?>" accesskey="a"><span>Add a News</span></a></div>
  <?php if ($this->news->id) {?>
    <div><a class="operations delete" href="<?=$this->urls['deleteNewsURL']?><?=$this->news->id ?>"
          onclick="return confirm('Delete This News?')"><span>Delete This News</span></a></div>
  <?php }?>
</div> -->

<?php include $this->footer ?>

