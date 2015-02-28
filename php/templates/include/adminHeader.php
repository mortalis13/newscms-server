<script src="js/effects.js"></script>

<div class="adminHeader">
  <a class="homeLink" href="<?=$this->urls['adminURL']?>">News Portal Admin</a><br>
  <span class="adminHeaderInfo">You are logged in as <a id="profileLink" href="<?=$this->urls['profileURL']?>"><?=$_SESSION['username'] ?></a>.
  <a class="systemLink" href="<?=$this->urls['logoutURL']?>">Log out</a></span>
</div>