

var $ = require('jquery');
require('lity');

// iFrames resizing
$(function () {
  var lastbreakPoint;

  function adjustIFrameHeight(ev) {
    $(ev.target).height(ev.target.contentWindow.document.body.offsetHeight + 'px');
  }


  $('.resize-iframe-toggle').click(function(event) {
    var breakpoint = $(event.target).data('breakpoint');
    
    $('iframe').each(function(index, iFrame) {

      if (lastbreakPoint) {
        $(iFrame).removeClass(lastbreakPoint);
      }
      $(iFrame).addClass(breakpoint);

      fillIFrameWithContent(null, iFrame)
      iFrame.onload = function(){console.log("onload"+iFrame); adjustIFrameHeight({target: iFrame})}
    })

    lastbreakPoint = breakpoint;
  });
})


// Navigation / Content loading
$(function() {

  $('.ck-navigation a').click(function(ev) {
    
    var targetElement = $($(this).attr('href'));
    

    $('.navigatable-content').hide();
    
    targetElement.find("iframe").each(fillIFrameWithContent)
    
    targetElement.show();
    targetElement.parents('.navigatable-content').show();
    targetElement.find('.navigatable-content').show();

    // preventDefault + stopPropagation
    return false;
  });

  $('.navigatable-content').hide();
});


/* helpers */
function fillIFrameWithContent(index, iframe){
  $(iframe).attr('srcdoc', $(iframe).data('srcdoc'));
  console.log("callbak")
}