window.onload = adjustAllIframeHeight
window.sizer = adjustAllIframeWidth
window.goto = goto


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
    
    // adjust height
    adjustAllIframeHeight(iFrame)
    
    // reload (mobile/desktop switches)
    iFrame.contentWindow.location.reload()
  })
}


function adjustIFrameHeight(iframe){
    var realHeight = iframe.contentWindow.document.body.offsetHeight
    iframe.style.height = realHeight+"px"
    return
}


function fillIFrameWithContent(iFrame){
  iFrame.srcdoc = iFrame.attributes['data-srcdoc'].textContent
}


function goto(id){
  console.log('click'+id)
  event.preventDefault()
  event.stopPropagation()
  document.location.hash = id
}