<?php
defined('ABSPATH') or die;

// 1) Inicjalizacja połączenia do changelog
global $changelog_db;
$changelog_db = new wpdb('root', '', 'changelog', 'localhost');

// 2) Tworzenie tabeli przez bezpośrednie query()
function my_plugin_create_table() {
    global $changelog_db;

    // Nazwa tabeli z prefixem
    $table_name = $changelog_db->prefix . 'entries';

    // Pobieramy COLLATE z instancji
    $charset_collate = $changelog_db->get_charset_collate();

    // SQL z IF NOT EXISTS
    $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
        id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        entry_value INT NOT NULL DEFAULT 1,
        user_login VARCHAR(255) NOT NULL,
        created_at DATETIME NOT NULL,
        city_placeholder VARCHAR(255) NOT NULL,
        city_list TEXT NOT NULL,
        PRIMARY KEY (id)
    ) {$charset_collate};";

    $res = $changelog_db->query( $sql );
    if ( false === $res ) {
        error_log( "Changelog: błąd tworzenia tabeli — " . $changelog_db->last_error );
    }
}

function get_current_time_and_user() {
    // Pobieranie aktualnego czasu
    $current_time = current_time('mysql');

    // Pobieranie nazwy aktualnie zalogowanego użytkownika
    $user = wp_get_current_user();
    $user_login = $user->user_login;

    return array(
        'current_time' => $current_time,
        'user_login' => $user_login,
    );
}

// 3) Funkcja zapisu – też upewni się, że tabela istnieje, i potem wstawi wiersz
function my_plugin_save_settings_and_insert( $new_value ) {
    global $changelog_db;

    $data = get_current_time_and_user();
    $user_login = $data['user_login'];
    $current_time = $data['current_time'];

    $city_placeholder = get_option('my_plugin_city_placeholder');
    $city_list = get_option('my_plugin_city_list');

    // 🔥 Zamieniamy tablicę na string (np. oddzielany przecinkami)
    if (is_array($city_list)) {
        $city_list = implode(', ', array_map('sanitize_text_field', $city_list));
    } else {
        $city_list = sanitize_text_field($city_list);
    }

    my_plugin_create_table();

    $inserted = $changelog_db->insert(
        $changelog_db->prefix . 'entries',
        array(
            'entry_value' => 1,
            'user_login'  => $user_login,
            'created_at'  => $current_time,
            'city_placeholder' => sanitize_text_field($city_placeholder),
            'city_list' => $city_list
        ),
        array( '%d', '%s', '%s', '%s', '%s' )
    );

    if ( false === $inserted ) {
        error_log( "Changelog: błąd wstawiania rekordu — " . $changelog_db->last_error );
    }

    return $new_value;
}
