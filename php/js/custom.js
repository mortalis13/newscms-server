
$(function(){
  var path='images/system/';
  var images=['bold_light','italic_light','preview_light','underline_light','view_light'];
  for(var i in images)
  	(new Image()).src=path+images[i]+'.png';
})

