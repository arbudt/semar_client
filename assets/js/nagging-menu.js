function moveScroller() {
    var move = function() {
        var st = $(window).scrollTop();
        var ot = $("#topmenu-anchor").offset().top;
        var s = $("#topmenu");
        if(st > ot) {
        	s.removeClass('default').addClass('fixed');
        } else {
            if(st <= ot) {
            	s.removeClass('fixed').addClass('default');
            }
        }
    };
    $(window).scroll(move);
    move();
}

$(function() {
    moveScroller();
});