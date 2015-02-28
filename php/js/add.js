var viewNewsActive

$(function(){
	setMouseUpFocus()
  $('.delete').click(function() {
    return confirm('Delete This News?')
  })
})

// countdown for new user to login automatically
function autoLogin(){
  timeLimit=5
  setInterval(function(){
    timeLimit-=1
    $('#time').html(timeLimit)
  },1000)
  
  setTimeout(function(){
    location="admin.php?action=listNews"
  },5500)
}

function setMouseUpFocus(){                                              //remove dotted border around links when mouse is up
  $("a").not($(".newsNavigation a")).bind("mousedown mouseup",function(e){
    var a=$(e.target)
    a.add(a.find("*")).css("border","1px solid transparent")
  })

	$(".newsNavigation a").bind("mousedown mouseup",function(e){
		var a=$(e.target)
    $(this).css("border","1px solid transparent")
	})

	$("div.buttons input").bind("mousedown mouseup",function(e){
		$("<style>div.buttons input:focus::-moz-focus-inner{border:1px solid transparent}</style>").appendTo("head")
	})
}

/* ************************************************************************** */

function imageUpload(upfield){
  var re_text = /\.jpg|\.jpeg|\.gif|\.png/i;
  var filename = upfield.value;                   //image path
  if (filename.search(re_text) == -1){
    alert("File should be jpg, jpeg, gif or jpeg");
    return false;
  }

  var prev_action=document.forms[0].getAttribute('action');   //current form action
  upfield.form.action = 'add/upload-picture.php';             //upload image program
  upfield.form.target = 'upload_iframe';                      //load its results to the iframe and put the image to appropriate img tag
  upfield.form.submit();
  upfield.form.action = prev_action;
  upfield.form.target = '';

  $('#editNewsTitle').focus();
  return true;
}

/* ************************************************************************** */

function editKey(event){
  if(event.keyCode==27){
    $("[name=cancel]")[0].click()
  }
  else if(event.altKey)
    if(event.keyCode==65){
      location='admin.php?action=newNews'
    }
}

function deleteAll(){
  var delAll=confirm('Delete All News?')
  if(delAll){
    location='admin.php?action=deleteNews&newsRange=all'
  }
}

/* ************************************************************************** */

function viewNewsAdmin(nid){                                        //go to the user viewNews page
  var url='index.php?action=viewNews&newsId='+nid
  window.open(url, '_blank')
  viewNewsActive=true
}
function viewNewsAdminMouseUp(e,nid){
  if(e.button==1){                                           		   	//mouse wheel
    var div=$(e.target)
	div.hover(function(){div.attr("style",'box-shadow: 1px 1px 4px rgba(0,0,0,0.2);')},
			  function(){div.attr("style",'box-shadow: 1px 1px 5px rgba(0,0,0,0);')})
    viewNewsAdmin(nid)
  }
}
function viewNewsAdminMouseDown(e){
  if(e.button==1){													//mouse wheel
	var div=$(e.target)
    div.attr("style",'box-shadow: 1px 1px 5px rgba(0,0,0,0);')
  }
}

function editNews(nid){                                               //edit link for the user (go to admin edit page)
  if(!viewNewsActive)
    location='admin.php?action=editNews&newsId='+nid
  else
    viewNewsActive=false
}

function previewNews(news){                                           //preview from admin
  var form=$('#previewForm')[0]
  form.date.value=$('#newsDate').html()
  form.title.value=$('#editNewsTitle').val()
  form.content.value=$('#editNewsContent').val()
  form.image.value=$('#editNewsImage').attr('src')
  form.username.value=$('#adminUsername').val()
  form.submit();
}
