window.onload = adjustAllIframeHeight
window.sizer = adjustAllIframeWidth

var breakPoints = {
  s: "320px",
  m: "786px",
  l: "1200px"
}

require('lity')

var $ = document.querySelectorAll.bind(document)

/* Helpers */
function getAll(selector){
  return document.querySelectorAll(selector)
}


function adjustAllIframeHeight(){
  [].map.call(getAll('iframe'), adjustIFrameHeight)
}


function adjustAllIframeWidth(breakPoint){
  [].map.call(getAll('iframe'), function(iFrame){
    iFrame.style.width = breakPoints[breakPoint]
    adjustAllIframeHeight(iFrame)
  })
}


function adjustIFrameHeight(iframe){
    var realHeight = iframe.contentWindow.document.body.offsetHeight
    iframe.style.height = realHeight+"px"
    return
}