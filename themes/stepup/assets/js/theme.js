jQuery(document).ready(function(){
    // Top toolbar
    var $btn = jQuery('.top-toolbar-trigger');
    $btn.click(function(){
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
        alert("Can't add more than 11 'Employment Info'.");
        return;
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
        alert('Can\'t delete');
    } else if (confirm('Delete this employment information?')) {
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
}
