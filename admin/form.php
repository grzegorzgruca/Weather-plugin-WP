<div class="wrap">
    <h1>Plugin settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('my_plugin_options_group');
        do_settings_sections('my-plugin-settings');
        submit_button();
        ?>
    </form>
</div>
