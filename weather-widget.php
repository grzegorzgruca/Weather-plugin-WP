<?php
/*
Plugin Name: Weather Widget
Description: Prosty widget pogodowy
Version: 2.0
Author: Grzegorz
*/

//ATTACHED FILES
require_once plugin_dir_path(__FILE__) . 'changelogLogger.php';
register_activation_hook( __FILE__, 'my_plugin_create_table' );


require_once plugin_dir_path(__FILE__) . 'admin/pageRenderer.php';
require_once plugin_dir_path(__FILE__) . 'admin/settingsRenderer.php';
function ww_register_weather_widget() {
    register_widget('WW_weather_widget');
}
add_action('widgets_init', 'ww_register_weather_widget');

class WW_weather_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'ww_weather_widget',
            __('Weather_Widget', 'text_domain'),
            array('description' => __('Show current weather data from any place.', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        include plugin_dir_path(__FILE__) . 'templates/widget-display.php';
        echo $args['after_widget'];
    }
}

// Shortcode: [weather_form]
function ww_weather_shortcode() {
    wp_enqueue_style('ww-weather-style', plugins_url('css/frontEndStyle.css', __FILE__));
    wp_enqueue_script('ww-weather-script', plugins_url('js/renderData.js', __FILE__), array(), false, true);
    //enable modules
    function ww_add_module_type_to_script($tag, $handle, $src) {
        if ($handle === 'ww-weather-script') {
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }
    add_filter('script_loader_tag', 'ww_add_module_type_to_script', 10, 3);
    
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/widget-display.php';
    return ob_get_clean();
}
add_shortcode('weather_form', 'ww_weather_shortcode');