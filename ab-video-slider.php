<?php
/*
Plugin Name: AB Video Slider
Description: Video slider with autoplay queue
Version: 1.2.0
Author: Abbalochdev
*/

if (!defined('ABSPATH')) exit;

class AB_Video_Slider {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('vc_before_init', array($this, 'register_vc_element'));
        add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
    }

    public function frontend_scripts() {
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'ab_video_slider')) {
            wp_enqueue_style(
                'ab-video-slider', 
                plugins_url('assets/css/slider.css', __FILE__), 
                array(), 
                '1.0.0'
            );
            wp_enqueue_script(
                'ab-video-slider',
                plugins_url('assets/js/slider.js', __FILE__),
                array('jquery'),
                '1.0.0',
                true
            );
        }
    }

    public function register_vc_element() {
        if (!function_exists('vc_map')) return;

        vc_map(array(
            'name' => 'AB Video Slider',
            'base' => 'ab_video_slider',
            'category' => __('Content', 'ab-video-slider'),
            'icon' => 'vc_icon-vc-media-grid',
            'params' => array(
                array(
                    'type' => 'param_group',
                    'heading' => __('Video Items', 'ab-video-slider'),
                    'param_name' => 'videos',
                    'value' => '',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Video Title', 'ab-video-slider'),
                            'param_name' => 'title',
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'single_image_upload',
                            'heading' => __('Video File (MP4)', 'ab-video-slider'),
                            'param_name' => 'video_url',
                            'description' => __('Upload MP4 video', 'ab-video-slider'),
                            'value' => '',
                            'admin_label' => true
                        )
                    )
                )
            )
        ));
    }
}

// Initialize plugin
AB_Video_Slider::get_instance();

// Register shortcode
function ab_video_slider_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Video Slider',
        'heading_size' => 'h2',
        'videos' => ''
    ), $atts);

    $title        = $atts['title'];
    $heading_size = $atts['heading_size'];
    $videos       = vc_param_group_parse_atts($atts['videos']);
    if (empty($videos)) return '';

    ob_start();
    ?>
    <div class="ab-video-slider">
        <div class="ab-video-track">
            <?php 
            foreach ($videos as $index => $item): 
                if (!empty($item['video_url'])):
                    $video_url = wp_get_attachment_url($item['video_url']);
                    if ($video_url):
            ?>
                <div class="ab-video-item">
                    <div class="video-wrapper" data-index="<?php echo esc_attr($index); ?>">
                        <video 
                            class="lazy-video"
                            muted 
                            playsinline 
                            loop
                            preload="none"
                            data-src="<?php echo esc_url($video_url); ?>"
                        >
                            <source type="video/mp4">
                        </video>
                    </div>
                    <?php if (!empty($item['title'])): ?>
                        <h3 class="video-title"><?php echo esc_html($item['title']); ?></h3>
                    <?php endif; ?>
                </div>
            <?php 
                    endif;
                endif;
            endforeach; 
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ab_video_slider', 'ab_video_slider_shortcode');

// Custom field type for video upload
function single_image_upload_field_callback($settings, $value) {
    ob_start();
    ?>
    <div class="video_upload_field">
        <input type="hidden" name="<?php echo esc_attr($settings['param_name']); ?>" 
               class="wpb_vc_param_value" 
               value="<?php echo esc_attr($value); ?>">
        <button class="button upload_video_button">
            <?php _e('Upload Video', 'ab-video-slider'); ?>
        </button>
        <?php if ($value): ?>
            <div class="video_preview">
                <?php echo esc_html(basename(wp_get_attachment_url($value))); ?>
            </div>
        <?php endif; ?>
    </div>
    <script>
    jQuery(document).ready(function($) {
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
    </script>
    <?php
    return ob_get_clean();
}
if ( function_exists( 'vc_add_shortcode_param' ) ) {
    vc_add_shortcode_param('single_image_upload', 'single_image_upload_field_callback');
}

function ab_video_slider_admin_scripts() {
    wp_enqueue_script(
        'ab-video-upload',
        plugins_url('assets/js/admin-video-upload.js', __FILE__),
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('admin_enqueue_scripts', 'ab_video_slider_admin_scripts');