<?php

function beez_business_hours_shortcode($atts) {
    $atts = shortcode_atts(array(), $atts);

    // Retrieve saved settings
    $opening_hours = get_option('beez_opening_hours', '');
    $closing_hours = get_option('beez_closing_hours', '');
    $title = get_option('beez_title', '');
    $opening_message = get_option('beez_opening_message', '');
    $open_label = get_option('beez_open_label', '');
    $closing_message = get_option('beez_closing_message', '');
    $close_label = get_option('beez_close_label', '');
    $bg_color = get_option('beez_bg_color', '#ffffff');
    $text_color = get_option('beez_text_color', '#000000');

    // Determine if currently open
    $current_time = current_time('H:i');
    $is_open = ($current_time >= $opening_hours && $current_time <= $closing_hours);

    // Create the HTML output
    $output = '<div class="beez-business-hours" style="background-color: ' . esc_attr($bg_color) . '; color: ' . esc_attr($text_color) . ';">';
    $output .= '<h2>' . esc_html($title) . '</h2>';
    // $output .= '<p>' . esc_html($opening_message) . '</p>';

    if ( $is_open ) {
        $output .= '<p>' . esc_html($opening_message) . '</p>';
    } else {
        $output .= '<p>' . esc_html($closing_message) . '</p>';
    }
    
    if ($is_open) {
        $output .= '<span class="beez-label">' . esc_html($open_label) . '</span>';
    } else {
        $output .= '<span class="beez-label"> Today: ' . esc_html__($close_label) . '</span>';
    }
    
    $output .= '<p>' . esc_html__('Opening Hours:', 'beez-management') . ' ' . esc_html($opening_hours) . ' - ' . esc_html($closing_hours) . '</p>';
    $output .= '</div>';

    return $output;
}
add_shortcode('business_hours', 'beez_business_hours_shortcode');
