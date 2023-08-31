<?php

function beez_business_hours_shortcode($atts) {
    $atts = shortcode_atts(array(), $atts);

    // Retrieve saved settings.
    $title = get_option('beez_title', '');
    $opening_message = get_option('beez_opening_message', '');
    $open_label = get_option('beez_open_label', '');
    $closing_message = get_option('beez_closing_message', '');
    $close_label = get_option('beez_close_label', '');
    $bg_color = get_option('beez_bg_color', '#ffffff');
    $text_color = get_option('beez_text_color', '#000000');
    $time_format = get_option('beez_time_format', '12-hour');

    $selected_timezone = get_option('beez_selected_timezone', 'UTC');
    date_default_timezone_set($selected_timezone);

    $current_day = date_i18n('l');
    $current_time = current_time('H:i');

    $opening_hours = get_option("beez_opening_hours_$current_day", '');
    $closing_hours = get_option("beez_closing_hours_$current_day", '');

    // Convert hours to selected time format
    if ($time_format === '12-hour') {
        $opening_hours = date('h:i A', strtotime($opening_hours));
        $closing_hours = date('h:i A', strtotime($closing_hours));
    }
    
    
    $is_open = ($current_time >= $opening_hours && $current_time <= $closing_hours);

    // Get current day and date
    $current_day = date_i18n('l');
    $current_date = date_i18n('F j, Y');

    // Create the HTML output
    $output = '<div class="beez-business-hours" style="border: 1px solid ' . esc_attr($bg_color) . '; width: 300px;">';
        $output .= '<div class="beez-header" style="padding: 2px; display: flex; flex-direction: column; justify-content: space-around; align-items: center; background-color: ' . esc_attr($bg_color) . '; color: ' . esc_attr($text_color) . ';">';
            $output .= '<h2>' . esc_html($title) . '</h2>';
            $output .= '<div class="beez-day-date">';
                $output .= '<p>' . esc_html($current_day) . ', ' . esc_html($current_date) . '</p>';
            $output .= '</div>';
            if ($is_open) {
                $output .= '<span class="open-label" style="background-color: ' . esc_attr($bg_color) . '; color: ' . esc_attr($text_color) . ';">' . esc_html($open_label) . '</span>';
            } else {
                $output .= '<span class="close-label" style="padding: 4px; border-radius: 5px; background-color: ' . esc_attr($bg_color) . '; color: ' . esc_attr($text_color) . ';">' . esc_html($close_label) . '</span>';
            }  
        $output .= '</div>';        
        
        $output .= '<p>' . esc_html__('Opening Hours:', 'beez-management') . ' ' . esc_html($opening_hours) . ' - ' . esc_html($closing_hours) . '</p>';
        
        $output .= '<div class="beez-display-message" style="margin-top: 20px; text-align: left;">';

            if ($is_open) {
                $output .= '<p>' . esc_html($opening_message) . '</p>';
            } else {
                $output .= '<p>' . esc_html($closing_message) . '</p>';
            }
        $output .= '</div>';

    $output .= '</div>';

    return $output;
}
add_shortcode('business_hours', 'beez_business_hours_shortcode');
