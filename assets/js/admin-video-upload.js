(function($) {
    $(document).ready(function() {
        $('.upload_video_button').on('click', function(e) {
            e.preventDefault();
            var $button = $(this);
            var $input = $button.siblings('input');
            
            var mediaUploader = wp.media({
                title: 'Select Video',
                library: { type: 'video/mp4' },
                button: { text: 'Use this video' },
                multiple: false
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $input.val(attachment.id).trigger('change');
                $button.siblings('.video_preview').remove();
                $button.after('<div class="video_preview">' + attachment.filename + '</div>');
            });

            mediaUploader.open();
        });
    });
})(jQuery); 