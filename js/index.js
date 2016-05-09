

var $ = require('jquery');
require('lity');

// iFrames resizing
$(document).ready(function () {
  var lastbreakPoint;

  function adjustIFrameHeight(iframe) {
    $(iframe).height(iframe.contentWindow.document.body.offsetHeight + 'px');
  }

  $('.resize-iframe-toggle').click(function () {
    var breakpoint = $(this).data('breakpoint');
    $('iframe').each(function () {
      if (lastbreakPoint) {
        $(this).removeClass(lastbreakPoint);
      }
      $(this).addClass(breakpoint);

      // adjust height
      adjustIFrameHeight(this);

      // reload (mobile/desktop switches)
      this.contentWindow.location.reload();
    })

    lastbreakPoint = breakpoint;
  });

  $(window).load(function() {
    $('iframe').each(function() {
      adjustIFrameHeight(this);
    });

    $('.resize-iframe-toggle').first().click();
  });
})


// Navigation / Content loading
$(document).ready(function() {

  function fillIFrameWithContent(iframe){
    $(iframe).attr('srcdoc', $(iframe).data('srcdoc'));
  }

  $('.ck-nav-bar a').click(function() {
    var targetElement = $($(this).attr('href'));

    $('.pattern,.directory').hide();
    
    targetElement.show();
    targetElement.parents().show();
    targetElement.contents().show();

    lastTarget = targetElement;

    // preventDefault + stopPropagation
    return false;
  });
});
