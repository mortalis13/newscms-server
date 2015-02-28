<?php include $this->header ?>
<script src="js/style.js"></script>
<?php include $this->adminHeader ?>

<h1 class="pageHeader"><?=$this->pageTitle?></h1>

<div id="profile">
  <div class="property">
    <div class="title">
      <div class="line"><span>change image</span></div>
    </div>
    <div class="content">
      <img src="images/users/roman.png"/>
    </div>
  </div>

  <div class="property">
    <div class="title">
      <div class="line"> <span>change username</span></div>
    </div>
    <div class="content">
      <label for="newUsername">New username</label>
      <input type="text" id="newUsername"/>
    </div>
  </div>

  <div class="property">
    <div class="title">
      <div class="line"> <span>change password</span></div>
    </div>
    <div class="content">
      <label for="oldpassword">Old password</label>
      <input type="password" id="oldpassword"/>
    </div>
    <div class="content">
      <label for="newpassword">New password</label>
      <input type="password" id="newpassword"/>
    </div>
    <div class="content">
      <label for="repeatpassword">Repeat password</label>
      <input type="password" id="repeatpassword"/>
    </div>
  </div>

  <div class="actions">
    <div class="title">
      <div class="line"></div>
    </div>
    <div class="profileButtons">
      <input type="submit" name="save" value="Save" accesskey="s"/>
      <input type="submit" name="cancel" formnovalidate  value="Cancel" accesskey="c"/>
    </div>
  </div>
  <div class="endLine"></div>

  <div id="delete">
    <a id="deleteProfile" href="<?=$this->urls['deleteProfileURL']?>" onclick="return confirm('Delete your profile?')">Delete Profile</a>
  </div>
</div>

<?php include $this->footer ?>

