<?php
require_once plugin_dir_path(__FILE__) . '../settingsRenderer.php';

function my_plugin_city_render() {
    $value = get_option('my_plugin_city_placeholder');
    echo '<input type="text" name="my_plugin_city_placeholder" value="' . esc_attr($value) . '" />';
}