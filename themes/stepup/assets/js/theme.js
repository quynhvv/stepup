jQuery(document).ready(function(){
    // Top toolbar
    var $btn = jQuery('.top-toolbar-trigger');
//    $btn.click(function(){
//        jQuery(this).closest('.top-toolbar-container').toggleClass('active');
//    });
    $btn.on('mouseenter', function(){
        jQuery(this).closest('.top-toolbar-container').toggleClass('active');
    });
    jQuery('body').on('click',function(e){
        if(jQuery(e.target).closest('.top-toolbar-container').length == 0){
            jQuery('.top-toolbar-container').each(function(){
                jQuery(this).removeClass('active');
            })
        }
    });
});


function addEmploymentInfo($obj) {
    var $formId = $('.employment-history').length;

    if ($formId > 10) {
        bootbox.alert("Can't add more than 11 'Employment Info'.");
        return false;
    }

    $.ajax({
        url: $obj.attr('href'),
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status === 'success') {
                $('.employment-history-wrapper').append(data.content);
            }
        }
    });
}

function delEmploymentInfo($obj) {
    if ($('.employment-history').length == 1) {
        bootbox.alert('Can\'t delete');
        return false;
    }

    bootbox.confirm('Delete this employment information?', function(result) {
        if (result) {
            $wrapper = $obj.parents('.employment-history');
            $modelId = $wrapper.find('.employment-history-id').val();
            if ($modelId == '') {
                $wrapper.remove();
            } else {
                $.ajax({
                    url: $obj.attr('href'),
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'success') {
                            $wrapper.remove();
                        }
                    }
                });
            }
        }
    });
}

function favourite($obj){
    $.ajax({
        url: $obj.attr('href'),
        type: 'post',
        dataType: 'json',
        data: {
            object_id: $obj.attr('data-id'), 
            object_type: $obj.attr('data-type')
        },
        beforeSend: function(){
          $obj.addClass('loading');
        },
        success: function (result) {
            $obj.removeClass('loading');
            if (result.status === 'ok' && result.action === 'add') {
                $obj.removeClass('un-favourites').addClass('favourites');
            }else if (result.status === 'ok' && result.action === 'remove') {
                $obj.removeClass('favourites').addClass('un-favourites');
            }
            bootbox.alert(result.message);
        }
    });
}