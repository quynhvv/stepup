jQuery(document).ready(function(){
    var sticky = jQuery('.main-header');
    if (sticky.length > 0) {
        var navHeight = sticky.height();
        jQuery(window).scroll(function(){
            if (jQuery(window).scrollTop() > navHeight) {
                sticky.addClass('sticky-nav');
            }
            else {
                sticky.removeClass('sticky-nav');
            }
        });
    }
});