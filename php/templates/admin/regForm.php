<?php include $this->header ?>

<script src='js/checkuser.js'></script>

<div class="regInfo">
  <div class="infoContainer">
    <div id='info_user'></div>
    <div id='info_pass'></div>
    <div id='info_repeat_pass'></div>
  </div>
</div>

<form id="regForm" class="inputForms form-horizontal" action="admin.php?action=register" method="post">
  <input type="hidden" name="register" value="true" />

  <div id="regErrorDiv" align="center">
    <?php if ($this->errorMessage){ ?>
      <script>showErrorMessage=1</script>
      <?php if (strlen($this->errorMessage)>40){ ?>
        <script>longErrorMessage=1</script>
      <?php } ?>
      <div id="regErrorMessage"><?=$this->errorMessage ?></div>
    <?php } ?>
  </div>

  <script>
    if(showErrorMessage==1) 
      $('#regErrorDiv').css("paddingTop",0)
    if(longErrorMessage==1) 
      $('#regErrorMessage').css("width","98%")
  </script>

  <div class="form-group">
    <label for="regUsername" class="regLabel1 control-label col-sm-4 col-xs-4">New Username</label>
    <div class="col-sm-8 col-xs-8 control-input">
      <input type="text" class="form-control" name="username" id="regUsername" required autofocus maxlength="15" autocomplete="off"
            onblur="checkUsername(this.value)" onkeyup="checkUserAvail(event,this.value)"/>
    </div>
  </div>

  <div class="form-group">
    <label for="regPassword" class="regLabel1 control-label col-sm-4 col-xs-4">Your Password</label>
    <div class="col-sm-8 col-xs-8 control-input">
      <input type="password" class="form-control" name="password" id="regPassword" required maxlength="20" autocomplete="off"
             onkeyup='checkEmptyPass(event,this.value)' onblur='checkPassword(this.value)'/>
    </div>
  </div>

  <div class="form-group">
    <label for="regRepeatPassword" class="regLabel1 control-label col-sm-4 col-xs-4">Repeat Password</label>
    <div class="col-sm-8 col-xs-8 control-input">
      <input type="password" class="form-control" name="repeat_password" id="regRepeatPassword" required maxlength="20"
             autocomplete="off" onkeyup='checkRepeatPassword(this.value,password.value)'/>
    </div>
  </div>

  <div class="text-center redirectBox">
    <a class="regLoginLink" href="<?=$this->urls['loginURL']?>">Login</a>
  </div>

  <div class="buttons">
    <input type="submit" name="register" value="Register" />
  </div>
</form>

<?php include $this->footer ?>

