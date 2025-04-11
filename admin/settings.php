<?php
wp_enqueue_script(
    'script',
    plugins_url('secondSection/script.js', __FILE__), // ścieżka względem settings.php
    array('jquery'), // lub pustą tablicę, jeśli nie używasz jQuery
    false,
    true
);
add_action('admin_init', 'my_plugin_settings_init');

function my_plugin_settings_init() {
    register_setting('my_plugin_options_group', 'my_plugin_city');
    register_setting('my_plugin_options_group', 'my_plugin_city_list');

    add_settings_section(
        'my_plugin_general_section',
        'General Settings',
        null,
        'my-plugin-settings'
    );

    add_settings_field(
        'my_plugin_city_field',
        'Other:',
        'my_plugin_city_render',
        'my-plugin-settings',
        'my_plugin_general_section'
    );

    add_settings_section( 
        'my_plugin_additionalC_section',
        'Additional default places',
        null,
        "my-plugin-settings"
    );

    add_settings_field(
        'my_plugin_city_list',
        'Places',
        'my_plugin_city_list_render',
        'my-plugin-settings',
        'my_plugin_additionalC_section'
    );
}

//first section
function my_plugin_city_render() {
    $value = get_option('my_plugin_city');
    echo '<input type="text" name="my_plugin_city" value="' . esc_attr($value) . '" />';
}
function my_plugin_city_list_render() {
    $cities = get_option('my_plugin_city_list', []);
    if (!is_array($cities)) {
        $cities = [];
    }
    ?>
    <div id="city-list-wrapper">
        <?php foreach ($cities as $index => $city): ?>
            <div class="city-row">
                <input type="text" name="my_plugin_city_list[]" value="<?php echo esc_attr($city); ?>" />
                <button type="button" class="remove-city">Usuń</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-city">Add new place</button>
    <?php
}