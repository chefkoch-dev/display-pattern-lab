var $ = require('jquery');
var currentNavigationSelected; //only load iframes currently selected (much much much faster)

require('lity');
hljs.initHighlightingOnLoad();

// code show/hide buttons
$(function(){
  $("button.codetoggle").click(function(ev){
    $(ev.target.nextElementSibling).toggle()
  })
})

// iFrames resizing
$(function () {
  var lastbreakPoint;

  $('.resize-iframe-toggle').click(function(event) {
    var breakpoint = $(event.target).data('breakpoint');
    
    // only iframes within this navi section
    currentNavigationSelected.find("iframe").each(function(index, iFrame) {

      if (lastbreakPoint) {
        $(iFrame).removeClass(lastbreakPoint);
      }
      $(iFrame).addClass(breakpoint);

      initIFrame(iFrame)
    })

    lastbreakPoint = breakpoint;
  });
})


// Navigation / Content loading
$(function() {

  $('.ck-navigation a').click(function(ev) {
    
    var targetElement = $($(this).attr('href'));
    currentNavigationSelected = targetElement
    
    $('.navigatable-content').hide();
    
    // init all iframes that can be found inside
    toArray(targetElement.find("iframe")).forEach(initIFrame)
    
    targetElement.show();
    targetElement.parents('.navigatable-content').show();
    targetElement.find('.navigatable-content').show();


    return false;  // preventDefault + stopPropagation
  });

  $('.navigatable-content').hide();
});


/* helpers */

// because jquerys .each sucks ass because index and item are reversed
function toArray(object){
  return [].slice.call(object)
}


function initIFrame(iFrame){
  fillIFrameWithContent(iFrame)
  iFrame.onload = function(ev){ setTimeout(function() {adjustIFrameHeight(iFrame)}, 100) }
}


function fillIFrameWithContent(iframe){
  $(iframe).attr('srcdoc', $(iframe).data('srcdoc'))
}


function adjustIFrameHeight(iFrame) {
  console.log(iFrame.contentWindow.document.body.offsetHeight)
  return $(iFrame).height(iFrame.contentWindow.document.body.offsetHeight + 'px');
}