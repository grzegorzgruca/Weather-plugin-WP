<?php
 wp_enqueue_style(
        'my-plugin-admin-style',
        plugin_dir_url(__FILE__) . '../css/adminPanelStyle.css', // Ścieżka do Twojego CSS
        array(),
        '1.0'
    );
add_action('admin_menu', 'my_plugin_add_admin_menu');
function my_plugin_add_admin_menu() {
    add_menu_page(
        'Weather plugin',
        'Weather plugin',
        'manage_options',
        'my-plugin-settings',
        'my_plugin_settings_page'
    );
}

function my_plugin_settings_page() {
    include plugin_dir_path(__FILE__) . 'form.php';
}
?>