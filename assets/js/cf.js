jQuery(document).ready(function($) {
    var wpUploadMedia;

    $('.gf_custom_upload_button').click(function(e)
    {
        e.preventDefault();

        if (wpUploadMedia) {
            wpUploadMedia.open();
            return;
        }

        wpUploadMedia = wp.media.frames.file_frame = wp.media({
            title: 'Choose File',
            button: {
                text: 'Choose File'
            },
            multiple: false
        });

        wpUploadMedia.on('select', function()
        {
            var attachment = wpUploadMedia.state().get('selection').first().toJSON();
            $('#previewImage').html('<img src="'+attachment.url+'" style="width: 75px" />');
            $('#excerpt_input').val(attachment.id).trigger('change');
        });

        wpUploadMedia.open();
    });

    $('.gf_custom_delete_button').click(function(e)
    {
        e.preventDefault();
        $('#previewImage').html('');
        $('#excerpt_input').val('').trigger('change');
    });
});
