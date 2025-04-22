<?php
function my_plugin_render_changelog_table() {
    global $changelog_db;

    $table_name = $changelog_db->prefix . 'entries';
    $results = $changelog_db->get_results("SELECT * FROM {$table_name} ORDER BY created_at DESC LIMIT 20");

    if (empty($results)) {
        echo '<p>Brak zmian do wyświetlenia.</p>';
        return;
    }

    echo '<h2>Ostatnie zmiany</h2>';
    echo '<table class="widefat fixed striped">';
    echo '<thead>
            <tr>
                <th>ID</th>
                <th>Użytkownik</th>
                <th>Data</th>
                <th>Placeholder</th>
                <th>Miasta</th>
            </tr>
          </thead><tbody>';

    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . esc_html($row->id) . '</td>';
        echo '<td>' . esc_html($row->user_login) . '</td>';
        echo '<td>' . esc_html($row->created_at) . '</td>';
        echo '<td>' . esc_html($row->city_placeholder) . '</td>';
        echo '<td>' . esc_html($row->city_list) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}
?>

<div class="wrap">
    <h1>Plugin settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('my_plugin_options_group');
        do_settings_sections('my-plugin-settings');
        submit_button();
        my_plugin_render_changelog_table();
        ?>
    </form>
</div>

