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

    $display_timezone_message = get_option('beez_display_timezone_message', 'off');
    $display_local_time_message = get_option('beez_display_local_time_message', 'off');

    $selected_timezone = get_option('beez_selected_timezone', 'UTC');
    date_default_timezone_set($selected_timezone);

    $current_day = date_i18n('l');
    $current_time =  date('H:i', current_time('timestamp', true));
   

    $opening_hours = get_option("beez_opening_hours_$current_day", '');
    $closing_hours = get_option("beez_closing_hours_$current_day", '');

    $is_open = ($current_time >= $opening_hours && $current_time <= $closing_hours);

    // Get current day and date
    $current_day = date_i18n('l');
    $current_date = date_i18n('F j, Y');

    // Convert hours to selected time format for display only
    if ($time_format === '12-hour') {
        $opening_hours_display = !empty($opening_hours) ? date('h:i A', strtotime($opening_hours)) : 'Closed';
        $closing_hours_display = !empty($closing_hours) ? date('h:i A', strtotime($closing_hours)) : '';
    } else {
        $opening_hours_display = !empty($opening_hours) ? $opening_hours : 'Closed';
        $closing_hours_display = !empty($closing_hours) ? $closing_hours : '';
    }

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
        
        // Display opening and closing hours for each day
        $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
        $output .= '<ul class="beez-opening-hours-list">';
        foreach ($days as $day) {
            $opening_hours = get_option("beez_opening_hours_$day", '');
            $closing_hours = get_option("beez_closing_hours_$day", '');

            // Convert hours to selected time format for display only
            if ($time_format === '12-hour') {
                $opening_hours_display = !empty($opening_hours) ? date('h:i A', strtotime($opening_hours)) : 'Closed';
                $closing_hours_display = !empty($closing_hours) ? date('h:i A', strtotime($closing_hours)) : '';
            } else {
                $opening_hours_display = !empty($opening_hours) ? $opening_hours : 'Closed';
                $closing_hours_display = !empty($closing_hours) ? $closing_hours : '';
            }

            $output .= '<li><strong>' . esc_html(ucfirst($day)) . ':</strong> ' . esc_html($opening_hours_display);
            if (!empty($closing_hours_display)) {
                $output .= ' - ' . esc_html($closing_hours_display);
            }
            $output .= '</li>';
        }
        $output .= '</ul>';

        $output .= '<div class="beez-display-message" style="margin-top: 20px; text-align: left;">';
            if ($is_open) {
                $output .= '<p>' . esc_html($opening_message) . '</p>';
            } else {
                $output .= '<p>' . esc_html($closing_message) . '</p>';
            }
        $output .= '</div>';
        // Display timezone message if enabled
    if ($display_timezone_message === 'on') {
        $output .= '<div class="">';
        $output .= '<p>Our hours are displayed in ' . esc_html($selected_timezone) . ' timezone.</p>';
        $output .= '</div>';
    }

    // Display local time message if enabled
    if ($display_local_time_message === 'on') {
        $current_local_time = date('H:i l, F j, Y', current_time('timestamp', true));
        $output .= '<div class="">';
        $output .= '<p>Our local time is ' . esc_html($current_local_time) . '.</p>';
        $output .= '</div>';
    }

    $output .= '</div>';

    return $output;
}
add_shortcode('business_hours', 'beez_business_hours_shortcode');

