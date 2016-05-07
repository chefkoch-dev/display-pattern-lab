window.onload = adjustIframeHeight
window.sizer = adjustIframeWidth

require('lity')

var $ = document.querySelectorAll

function displayIframe(iFrame){
  iframe.style
}


function adjustIframeWidth(size){
  var iFrames = $('iframe')

  ;[].map.call(iFrames, (frame)=>{
    debugger
    frame.style.width = size
    return
  })
}

function adjustIframeHeight(){
  var iFrames = $('iframe')

  ;[].map.call(iFrames, (frame)=>{
    var realHeight = frame.contentWindow.document.body.offsetHeight
    frame.style.height = realHeight+"px"
    return
  })

}