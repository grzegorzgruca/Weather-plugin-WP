<?php

add_action('admin_init', 'my_plugin_settings_init');

function my_plugin_settings_init() {
    register_setting('my_plugin_options_group', 'my_plugin_city');

    add_settings_section(
        'my_plugin_general_section',
        'Podstawowe ustawienia',
        null,
        'my-plugin-settings'
    );

    add_settings_field(
        'my_plugin_city_field',
        'Miasto',
        'my_plugin_city_render',
        'my-plugin-settings',
        'my_plugin_general_section'
    );

    add_settings_section( 
        'my_plugin_additionalC_section',
        'Additional default places',
        null,
        "my-plugin-settings"
    )

    add_settings_field(
        'my_plugin_default_place',
        'Miasto default',
        'my_plugin_default_place_render',
        'my-plugin-settings',
        'my_plugin_additionalC_section'
    );
}

function my_plugin_city_render() {
    $value = get_option('my_plugin_city');
    echo '<input type="text" name="my_plugin_city" value="' . esc_attr($value) . '" />';
}
function my_plugin_default_place_render() {
    $value = get_option('my_plugin_default_place');
    echo '<input type="text" name="my_plugin_default_place" value="' . esc_attr($value) . '" />';
}
