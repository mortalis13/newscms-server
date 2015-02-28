
function checkUsername(user){
  var out='#info_user'
  var res=usernameHelper(user)
  if(res!==true)
      printResult(out,res)
}

function checkUserAvail(event,user){
  var key=event.keyCode
  if(key==9 || key==16) return          //Tab or Shift (in Shift+Tab)

  var out='#info_user'
  if (user == ''){
      emptyResult(out)
      return
  }

  var res=usernameHelper(user)
  if(res===true){
    var params={user:user,checktype:"db"}
    $.post("add/checkuser.php",params,function(data){
        if (data!==null && data!=="" && data!=-1)
            printResult(out,data)
    })
  }else
    emptyResult(out)
}

function checkPassword(pass){
  var out='#info_pass'
  if(pass.length>0){
    if (pass.length < 5)
      printResult(out,"<span class='invalid'>&nbsp;&#x2718; " + "At least 5 symbols for <u>password</u></span>")
    else if (!/[a-z]/.test(pass) || !/[A-Z]/.test(pass) || !/[0-9]/.test(pass) || !/[!@#$%^&_-]/.test(pass))                       // if there is no one of those symbols
      printResult(out,"<span class='invalid'>&nbsp;&#x2718; " + "At least one of each \"a-z A-Z 0-9 !@#$%^&_-\" for <u>password</u></span>")
    else
      printResult(out,"<span class='valid'>&nbsp;&#x2714; " + "Correct password</span>")
  }
  else
    emptyResult(out)
}

function checkEmptyPass(event,pass){
  if(event.keyCode==9) return
  if(pass=="") emptyResult('#info_pass')
}

function checkRepeatPassword(repeatPass,pass){
  var out='#info_repeat_pass'
  if (repeatPass.length >= 5){    // start compare when there is enough length
    if (repeatPass != pass)
      printResult(out,"<span class='invalid'>&nbsp;&#x2718; " + "Incorrect repeat password</span>")
    else
      printResult(out,"<span class='valid'>&nbsp;&#x2714; " + "Correct repeat password</span>")
  }
  else if(repeatPass.length == 0)
    emptyResult(out)                            //clear message if field is empty
}


// ------------------------------------ service ------------------------------------


function printResult (container,text) {
  $(container).html(text)
  $(container).parent().show()
}

function emptyResult (container) {
  $(container).empty()
  var parent=$(container).parent()
  var children=parent.children()

  var hideInfo=true

  children.each(function(index,item) {
    if($(item).html()!=="")
      hideInfo=false
  })

  if(hideInfo)
    parent.hide()
}

function usernameHelper(user) {
  if(user.length>0){
    if (user.length < 5)
      return "<span class='invalid'>&nbsp;&#x2718; " + "At least 5 symbols for <u>username</u></span>"
    else if (/[^a-zA-Z0-9._-]/.test(user))
      return "<span class='invalid'>&nbsp;&#x2718; " + "Only a-z A-Z 0-9 ._- available for <u>username</u></span>"
  }
  return true
}
