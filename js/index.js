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

  var toggleContent = function(id) {
    var targetElement = $(id)
    currentNavigationSelected = targetElement

    $('.navigatable-content').hide();

    // init all iframes that can be found inside
    toArray(targetElement.find("iframe"))
        .forEach(initIFrame)

    targetElement.show();
    targetElement.parents('.navigatable-content').show();
    targetElement.find('.navigatable-content').show();
  }

  $('.ck-navigation a').click(function(ev) {
    
    toggleContent($(this).attr('href'));

    return false;  // preventDefault + stopPropagation
  });

  $('.navigatable-content').hide();

  if (document.location.hash) {
    toggleContent(document.location.hash);
  }
});


/* helpers */

// jquerys .each sucks because index and item are reversed
function toArray(object){
  return [].slice.call(object)
}


function initIFrame(iFrame){
  fillIFrameWithContent(iFrame)
  iFrame.onload = function(ev){ 
    console.log("readyiframe"+ev.target)
    setTimeout(function() {adjustIFrameHeight(iFrame)}, 200) 
  }
}


function fillIFrameWithContent(iframe){
  $(iframe).attr('srcdoc', $(iframe).data('srcdoc'))
}


function adjustIFrameHeight(iFrame) {
  console.log("adjust height"); 
  console.log(iFrame.contentWindow.document.body.offsetHeight)
  return $(iFrame).height(100+iFrame.contentWindow.document.body.offsetHeight + 'px');
}