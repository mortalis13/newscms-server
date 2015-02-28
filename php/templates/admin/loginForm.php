<?php include $this->header ?>

<?php if (isset($_SESSION['username'])&&$this->register) {?>
  <div class="newUsername" align="center"><b>"<?=$_SESSION['username'] ?>"</b> is registered successfully</div><br>
  <div align="center">You will be logged in automatically within <span id="time">5</span> seconds...</div>
  <div align="center">Or press <a id="redirectLink" href="<?=$this->urls['redirectURL']?>">this link</a> to login</div>
  <script>autoLogin()</script>
<?php die(); } ?>

<form id="loginForm" class="form-horizontal inputForms" action="admin.php?action=login" method="post">
  <div id="loginErrorDiv" align="center">
    <?php if ($this->errorMessage){ ?>
      <script>showErrorMessage=1</script>
      <div id="loginErrorMessage"><?=$this->errorMessage ?></div>
    <?php } ?>
  </div>

  <script>if(showErrorMessage==1) S('loginErrorDiv').paddingTop=0</script>

  <div class="form-group">
    <label for="username" class="loginLabel1 control-label col-sm-4 col-xs-4">Username</label>
    <div class="col-sm-8 col-xs-8 control-input">
      <input type="text" class="form-control" name="username" id="username" required maxlength="20" autocomplete="off" autofocus onfocus="this.select()"/>
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="loginLabel1 control-label col-sm-4 col-xs-4">Password</label>
    <div class="col-sm-8 col-xs-8 control-input">
      <input type="password" class="form-control" name="password" id="password" required maxlength="20" autocomplete="off"/>
    </div>
  </div>

  <div class="text-center redirectBox">
    <a class="regLoginLink" href="<?=$this->urls['regURL']?>">Register</a>
  </div>

  <div class="buttons">
    <input type="submit" name="login" value="Login" />
  </div>

  <input type="hidden" name="login" value="true" />
  <input type="hidden" name="redirect"value="<?php if($this->redirect) echo $this->redirect;?>" />
</form>

<?php include $this->footer ?>

