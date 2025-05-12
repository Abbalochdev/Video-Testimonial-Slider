<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Register Video Slider Element with WPBakery
if (!function_exists('register_video_slider_element')) {
    function register_video_slider_element() {
        // Map the element
       vc_map(array(
    'name' => __('Video Slider', 'abbaloch-video-slider'),
    'base' => 'video_slider',
    'category' => __('Content', 'abbaloch-video-slider'),
    'icon' => 'vc_icon-vc-media-grid',
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __('Title', 'abbaloch-video-slider'),
            'param_name' => 'title',
            'value' => 'Video Slider',
            'admin_label' => true
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Heading Size', 'abbaloch-video-slider'),
            'param_name' => 'heading_size',
            'value' => array(
                __('H1', 'abbaloch-video-slider') => 'h1',
                __('H2', 'abbaloch-video-slider') => 'h2',
                __('H3', 'abbaloch-video-slider') => 'h3',
            ),
            'std' => 'h2'
        ),
        array(
            'type' => 'param_group',
            'heading' => __('Videos', 'abbaloch-video-slider'),
            'param_name' => 'videos',
            'params' => array(
                array(
                    'type' => 'attach_video',
                    'heading' => __('Video', 'abbaloch-video-slider'),
                    'param_name' => 'video_url',
                    'description' => __('Select video from media library', 'abbaloch-video-slider')
                )
            )
        )
    )
));
    }
    add_action('vc_before_init', 'register_video_slider_element');
}

// Create the shortcode class
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Video_Slider extends WPBakeryShortCode {
        protected function content($atts, $content = null) {
            // Enqueue required assets
            wp_enqueue_style('video-slider-style');
            wp_enqueue_script('video-slider-script');

            // Extract attributes
            extract(shortcode_atts(array(
                'title' => 'Video Slider',
                'heading_size' => 'h2',
                'videos' => ''
            ), $atts));

            // Parse videos
            $videos = vc_param_group_parse_atts($videos);
            
            // Start output buffer
            ob_start();
            ?>
            <div class="video-slider">
                <div class="video-slider-container">
                    <?php if (!empty($title)) : ?>
                        <<?php echo esc_attr($heading_size); ?> class="video-slider-title">
                            <?php echo esc_html($title); ?>
                        </<?php echo esc_attr($heading_size); ?>>
                    <?php endif; ?>

                    <div class="video-slider-list">
                        <?php 
                        if (!empty($videos)) {
                            foreach ($videos as $video) {
                                if (!empty($video['video_url'])) {
                                    ?>
                                    <div class="video-slider-item">
                                        <div class="video-wrapper">
                                            <video autoplay loop muted playsinline>
                                                <source src="<?php echo esc_url($video['video_url']); ?>" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }
    }
}