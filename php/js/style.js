/* working functions for bolding textarea pieces of text */

function setBoldTags(text,start,end){
  var x1,x2,x3
  x1=text.substring(0,start)
  x2='<b>'+text.substring(start,end)+'</b>'
  x3=text.substring(end,text.length)
  newSelectionStart=start+3                       //select the bolded text after applying the style
  newSelectionEnd=end+3
  return x1+x2+x3
}
function removeBoldTags(text,start,end,tagStart,tagEnd){
  var x1,x2,x3
  x1=text.substring(0,tagStart)
  x2=text.substring(start,end)
  x3=text.substring(tagEnd+4,text.length)
  newSelectionStart=start-3
  newSelectionEnd=end-3
  return x1+x2+x3
}

function setBold(text){
  var start=text.selectionStart
  var end=text.selectionEnd

  if(start!=end){
    var txaText=text.value,x

    if(start>2&&end<txaText.length-3){                      //not first/last word (if there are bold tags)
      var tagStart=start-3
      var tagEnd=end
      var startTag=txaText.substring(tagStart,tagStart+3)
      var endTag=txaText.substring(tagEnd,tagEnd+4)

      if(startTag=='<b>'&&endTag=='</b>')                       //if bolded
        x=removeBoldTags(txaText,start,end,tagStart,tagEnd)
      else                                                      //not bolded
        x=setBoldTags(txaText,start,end)
    }
    else
      x=setBoldTags(txaText,start,end)                          //first/last word
    var currentScroll=text.scrollTop                            //scrollbar restore
    text.value=x
    text.scrollTop=currentScroll+20

    text.selectionStart=newSelectionStart                       //selection restore
    text.selectionEnd=newSelectionEnd
  }
  text.focus()
}
