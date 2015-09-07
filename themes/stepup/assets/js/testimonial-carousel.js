jQuery(document).ready(function(){
    jQuery('#testimonialcarousel').carousel({
        interval: 4000
    });

// handles the carousel thumbnails
    jQuery('[id^=carousel-selector-]').click( function(){
        var id_selector = jQuery(this).attr("id");
        var id = id_selector.substr(id_selector.length -1);
        id = parseInt(id);
        jQuery('#testimonialcarousel').carousel(id);
        jQuery('[id^=carousel-selector-]').removeClass('selected');
        jQuery(this).addClass('selected');
    });

// when the carousel slides, auto update
    jQuery('#testimonialcarousel').on('slid', function (e) {
        var id = jQuery('.item.active').data('slide-number');
        id = parseInt(id);
        jQuery('[id^=carousel-selector-]').removeClass('selected');
        jQuery('[id=carousel-selector-'+id+']').addClass('selected');
    });
})