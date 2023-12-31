<?php

// Menu and submenu creation
function beez_add_menu() {
    add_menu_page(
        __('Business Hours', 'beez-management'),
        __('Business Hours', 'beez-management'),
        'manage_options',
        'beez_menu',
        'beez_menu_manage_page',
		'dashicons-clock'
    );
    
    add_submenu_page(
        'beez_menu',
        __('Settings', 'beez-management'),
        __('Settings', 'beez-management'),
        'manage_options',
        'beez_menu_settings',
        'beez_menu_settings_page'
    );
    remove_submenu_page( 'beez_menu', 'beez_menu' );
}
add_action( 'admin_menu', 'beez_add_menu' );

