window.onload = adjustIframeHeight


function adjustIframeHeight(){
  var iFrames = document.querySelectorAll('iframe')

  ;[].map.call(iFrames, (frame)=>{
    var realHeight = frame.contentWindow.document.body.offsetHeight
    frame.style.height = realHeight+"px"
    return
  })

}