var $ = require('jquery');
require('lity');

$(document).ready(function () {
  var lastbreakPoint;

  $('.resize-iframe-toggle').click(function () {
    var breakpoint = $(this).data('breakpoint');
    $('iframe').each(function () {
      if (lastbreakPoint) {
        $(this).removeClass(lastbreakPoint);
      }
      $(this).addClass(breakpoint);
    })
    lastbreakPoint = breakpoint;
  }).first().click();

  $(window).load(function() {
    $('iframe').each(function () {
      $(this).height(this.contentWindow.document.body.offsetHeight + 'px');
    });
  });
})