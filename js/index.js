

var $ = require('jquery');
require('lity');

// iFrames resizing
$(function () {
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
$(function() {

  function fillIFrameWithContent(iframe){
    $(iframe).attr('srcdoc', $(iframe).data('srcdoc'));
  }

  $('.ck-nav-bar a').click(function() {
    var targetElement = $($(this).attr('href'));

    $('.navigatable-content').hide();
    
    targetElement.show();
    targetElement.parents('.navigatable-content').show();
    targetElement.find('.navigatable-content').show();

    // preventDefault + stopPropagation
    return false;
  });

  $('.navigatable-content').hide();
});
