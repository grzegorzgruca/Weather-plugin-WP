<?php
//IMPORTS

require_once plugin_dir_path(__FILE__) . 'renderFunctions/firstSection.php';
require_once plugin_dir_path(__FILE__) . 'renderFunctions/secondSection.php';

add_action('admin_init', 'my_plugin_settings_init');
function my_plugin_sanitize_placeholder($value) {
    return sanitize_text_field($value);
}

function my_plugin_settings_init() {
    register_setting(
        'my_plugin_options_group',
        'my_plugin_city_placeholder',
        array(
            'sanitize_callback' => 'my_plugin_sanitize_placeholder'
        )
    );

    register_setting(
        'my_plugin_options_group',
        'my_plugin_city_list',
        array(
            'sanitize_callback' => 'my_plugin_save_settings_and_insert' // tylko tutaj logujemy
        )
    );

    add_settings_section(
        'my_plugin_general_section',
        'General plugin settings',
        null,
        'my-plugin-settings'
    );

    add_settings_field(
        'my_plugin_city_placeholder',
        'Placeholder <br> Default: Np. Warszawa',
        'my_plugin_city_render',
        'my-plugin-settings',
        'my_plugin_general_section'
    );

    add_settings_section( 
        'my_plugin_additionalC_section',
        'Additional default places',
        null,
        'my-plugin-settings'
    );

    add_settings_field(
        'my_plugin_city_list',
        'Places',
        'my_plugin_city_list_render',
        'my-plugin-settings',
        'my_plugin_additionalC_section'
    );
}
