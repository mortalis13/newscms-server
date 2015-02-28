
function statusVanish(status){
  $(status).fadeOut(500)
}

function boldOver(image){                               //mouseover
  var source=image.src
  switch(image.id){
    case 'bold':
      image.src='images/system/bold_light.png'
      break
    case 'italic':
      image.src='images/system/italic_light.png'
      break
    case 'underline':
      image.src='images/system/underline_light.png'
      break
  }
  image.onmouseout=function(){
    image.src=source
  }
}

function previewOver(image){                                  //mouseover
  var source=image.src
  image.src='images/system/preview_light.png'
  $(image).mouseout(function(){
    image.src=source
  })
}
