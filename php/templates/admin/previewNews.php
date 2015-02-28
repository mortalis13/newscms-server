<?php include $this->header ?>

<script>
  function previewKeys(e){
    if(e.keyCode==27)
      window.close()
  }
  document.onkeyup=function(event){previewKeys(event)}
</script>

<div id="viewNewsContainer">
  <h2 id="title"><?=$this->news->title?> <span id="previewSpan">{preview}</span></h2>
  <img id="image" src="<?=$this->news->image?>">
  <div id="content"><?=$this->news->content?></div>
</div>

<span id="aNewsPubDate">Published on [<span id="userNewsDate"><?=$this->news->date?></span>]</span>
<br><span id="aNewsUser">by "<u><?=$this->news->username?></u>"</span>

<?php include $this->footer ?>

