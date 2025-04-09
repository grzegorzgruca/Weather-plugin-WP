<?php
/*
Plugin Name: Weather Widget
Description: Prosty widget pogodowy
Version: 1.0
Author: Grzegorz
*/

function ww_register_weather_widget() {
    require_once plugin_dir_path(__FILE__) . 'includes/api-functions.php';
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
    wp_enqueue_style('ww-weather-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('ww-weather-script', plugins_url('js/script.js', __FILE__), array(), false, true);

    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/widget-display.php';
    return ob_get_clean();
}
add_shortcode('weather_form', 'ww_weather_shortcode');