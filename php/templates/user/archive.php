<?php include $this->header ?>
<script src="js/sort.js"></script>

<h1 class="pageHeader">News Archive</h1>

<?php if($this->totalRows>0){?>
<div class="table-responsive-custom">
  <table align="center" class="tNewsArchiveUser" id="tNewsArchiveUser" cellspacing="0">
    <thead>
      <th id="date"> <span>Public date</span> </th>
      <th id="title"> <span>News title</span> </th>
      <th id="user"> <span>Username</span> </th>
    </thead>
    <?php foreach ($this->news as $news) { ?>
      <tr onclick="location='<?=$this->urls['viewNewsURL']?><?=$news->id?>'">
        <td>
          <span id="pubDateArchive"> <?=$news->date?> </span>
        </td>
        <td class="tableTitle">
          <a id="newsArchiveTitle" href="<?=$this->urls['viewNewsURL']?><?=$news->id?>"> <?=$news->title?> </a>
        </td>
        <td><?=$news->username?></td>
      </tr>
    <?php } ?>
  </table>
</div>
<?php }else{?>
  <div align="center">    <!-- if there is no news -->
    <div id="noNewsDivArchive" align="center">There is no any news yet</div>
  </div>
<?php }?>

<div class="tPages">
  <div class="total">
    <b><?=$this->totalRows?></b> news in total
  </div>
</div>

<?php include $this->menu ?>

<!-- <div class="menu">
  <div><a class="operations" href="<?=$this->urls['homepageURL']?>"><span>Return to Homepage</span></a></div>
  <div><a class="operations" href="<?=$this->urls['exportCSVURL']?>"><span>Export All News To CSV</span></a></div>
</div> -->

<?php include $this->footer ?>

