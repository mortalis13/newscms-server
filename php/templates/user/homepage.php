<!DOCTYPE HTML>
<?php include $this->header ?>
<script src="js/effects.js"></script>

<div class="statusRow"> <!-- table to align staus text without moving undelying elements -->
  <h1 class="statusPageTitle pageHeader">News</h1>    <!-- first cell -->

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

<?php if($this->totalRows>0){?>
<table class="tNewsUser" align="center" cellspacing="0">
  <?php foreach ($this->news as $news) { ?>
    <tr onclick="location='<?=$this->urls['viewNewsURL']?><?=$news->id?>'">
      <td id="date"><span id="pubDateUser"><?=$news->date?></span></td>
      <td class="tableTitle">
        <a href="<?=$this->urls['viewNewsURL']?><?=$news->id?>"> <?=$news->title?> </a>
      </td>
    </tr>
  <?php } ?>
</table>
<?php }else{?>
  <div align="center">    <!-- if there is no news -->
    <div id="noNewsDivUser" align="center">There is no any news yet</div>
  </div>
<?php }?>

<!-- same as in the listNews.php -->

<?php if($this->fillerHeight){?>
  <div style="height:<?=$this->fillerHeight?>px"></div>
<?php }?>

<div class="tPages">
  <div class="pagesNavigation">
    Pages:
    <?php if($this->pagesCount>1){?>
      <a class="otherPages" href="<?=$this->urls['pageURL']?>1">&Lt;</a>
      <a class="otherPages" href="<?=$this->urls['pageURL']?><?=$this->prev?>">&lt;</a>
      <a href="<?=$this->urls['pageURL']?>1" class="<?php if($this->page==1){?>currentPage<?php }else{?>otherPages<?php }?>">1</a>
      <?php if($this->startPage > MAX_PAGES){?>
        ...
      <?php }?>
      <?php
        for ($i=$this->startPage;$i<=$this->maxOutPages;$i++) {
          if($i==$this->page) $class="currentPage";
          else $class="otherPages";?>
          <a href="<?=$this->urls['pageURL']?><?=$i?>" class="<?=$class ?>"><?=$i?></a>
      <?php }if($this->useEllipsis&&!$this->showRestPages){?>
          ...
          <a class="otherPages" href="<?=$this->urls['pageURL']?><?=$this->pagesCount?>"><?=$this->pagesCount?></a>
      <?php }?>
        <a class="otherPages" href="<?=$this->urls['pageURL']?><?=$this->next?>">&gt;</a>
        <a class="otherPages" href="<?=$this->urls['pageURL']?><?=$this->pagesCount?>">&Gt;</a>
      <?php }else{?>
        <a href="<?=$this->urls['pageURL']?>1" class="currentPage">1</a>
      <?php } ?>
  </div>
  <div class="total">
    <b><?=$this->totalRows?></b> news in total
  </div>

  <div class="clearfix"></div>

  <form class="pagesSelectForm" action="index.php" method="post">
    <label for="newsOnPage" class="newsOnPageLabel" onclick="">News on page:</label>
    <div id="nppdiv">
      <select id="newsOnPage" name="newsOnPage" onchange="form.submit()">
        <option <?=$this->newsOnPage == 5?"selected='selected'":""?>>5</option>
        <option <?=$this->newsOnPage == 10?"selected='selected'":""?>>10</option>
        <option <?=$this->newsOnPage == 15?"selected='selected'":""?>>15</option>
        <option <?=$this->newsOnPage == 20?"selected='selected'":""?>>20</option>
        <option value="<?=$this->totalRows?>" <?=$this->newsOnPage == $this->totalRows?" selected='selected'":""?>>All</option>
      </select>
    </div>
  </form>
</div>

<?php include $this->menu ?>

<!-- <div class="menu">
  <div><a class="operations" href="<?=$this->urls['archiveURL']?>"><span>News Archive</span></a></div>
  <div><a class="operations" href="<?=$this->urls['exportCSVURL']?>"><span>Export All News To CSV</span></a></div>
</div> -->

<?php include $this->footer ?>

