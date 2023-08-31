<?php

function beez_get_timezones() {
    $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    $timezones_list = array();

    foreach ($timezones as $timezone) {
        $timezones_list[$timezone] = $timezone;
    }

    return $timezones_list;
}


function beez_menu_settings_page() {
    // Save Settings
     if (isset($_POST['submit'])) {

        $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
        foreach ($days as $day) {
            update_option("beez_opening_hours_$day", sanitize_text_field($_POST["opening_hours_$day"]));
            update_option("beez_closing_hours_$day", sanitize_text_field($_POST["closing_hours_$day"]));
        }

        update_option('beez_title', sanitize_text_field($_POST['title']));
        update_option('beez_opening_message', sanitize_text_field($_POST['opening_message']));
        update_option('beez_open_label', sanitize_text_field($_POST['open_label']));
        update_option('beez_closing_message', sanitize_text_field($_POST['closing_message']));
        update_option('beez_close_label', sanitize_text_field($_POST['close_label']));

        $time_format = isset($_POST['time_format']) ? sanitize_text_field($_POST['time_format']) : '12-hour';
        update_option('beez_time_format', $time_format);

        $selected_timezone = sanitize_text_field($_POST['selected_timezone']);
        update_option('beez_selected_timezone', $selected_timezone);
 
        update_option('beez_bg_color', sanitize_hex_color($_POST['bg_color']));
        update_option('beez_text_color', sanitize_hex_color($_POST['text_color']));
    }

    // Retrieve settings
    $time_format = get_option('beez_time_format', '12-hour');
    $opening_hours = get_option('beez_opening_hours', '');
    $closing_hours = get_option('beez_closing_hours', '');
    $title = get_option('beez_title', '');
    $opening_message = get_option('beez_opening_message', '');
    $open_label = get_option('beez_open_label', '');
    $closing_message = get_option('beez_closing_message', '');
    $close_label = get_option('beez_close_label', '');
    $bg_color = get_option('beez_bg_color', '#ffffff');
    $text_color = get_option('beez_text_color', '#000000');
    $selected_timezone = get_option('beez_selected_timezone', 'UTC');
    $available_timezones = beez_get_timezones();
    ?>
    <div class="wrap">
        <h2><?php esc_html_e('Business Hours Settings', 'beez-management'); ?></h2>
        <form method="post">
            <h3><?php esc_html_e('Opening and Closing Hours', 'beez-management'); ?></h3>

            <?php
            $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
            foreach ($days as $day) {
                echo '<label for="opening_hours_' . $day . '">' . esc_html(ucfirst($day)) . ' ' . esc_html__('Opening Hours:', 'beez-management') . '</label>';
                echo '<input type="text" name="opening_hours_' . $day . '" id="opening_hours_' . $day . '" value="' . esc_attr(get_option("beez_opening_hours_$day", '')) . '" />';
                
                echo '<label for="closing_hours_' . $day . '">' . esc_html(ucfirst($day)) . ' ' . esc_html__('Closing Hours:', 'beez-management') . '</label>';
                echo '<input type="text" name="closing_hours_' . $day . '" id="closing_hours_' . $day . '" value="' . esc_attr(get_option("beez_closing_hours_$day", '')) . '" />';
            }
            ?>

            <label for="opening_hours"><?php esc_html_e('Opening Hours:', 'beez-management'); ?></label>
            <input type="text" name="opening_hours" id="opening_hours" value="<?php echo esc_attr($opening_hours); ?>" />

            <label for="closing_hours"><?php esc_html_e('Closing Hours:', 'beez-management'); ?></label>
            <input type="text" name="closing_hours" id="closing_hours" value="<?php echo esc_attr($closing_hours); ?>" />

            <label for="title"><?php esc_html_e('Title:', 'beez-management'); ?></label>
            <input type="text" name="title" id="title" value="<?php echo esc_attr($title); ?>" />

            <label for="opening_message"><?php esc_html_e('Opening Message:', 'beez-management'); ?></label>
            <input type="text" name="opening_message" id="opening_message" value="<?php echo esc_attr($opening_message); ?>" />

            <label for="open_label"><?php esc_html_e('Opening label:', 'beez-management'); ?></label>
            <input type="text" name="open_label" id="open_label" value="<?php echo esc_attr($open_label); ?>" />

            <label for="closing_message"><?php esc_html_e('Closing Message:', 'beez-management'); ?></label>
            <input type="text" name="closing_message" id="closing_message" value="<?php echo esc_attr($closing_message); ?>" />

            <label for="close_label"><?php esc_html_e('Closing label:', 'beez-management'); ?></label>
            <input type="text" name="close_label" id="close_label" value="<?php echo esc_attr($close_label); ?>" />


            <h3><?php esc_html_e('Time Format', 'beez-management'); ?></h3>
            <label>
                <input type="radio" name="time_format" value="12-hour" <?php checked($time_format, '12-hour'); ?>>
                <?php esc_html_e('12-hour Format', 'beez-management'); ?>
            </label>
            <label>
                <input type="radio" name="time_format" value="24-hour" <?php checked($time_format, '24-hour'); ?>>
                <?php esc_html_e('24-hour Format', 'beez-management'); ?>
            </label>

            <h3><?php esc_html_e('Timezone', 'beez-management'); ?></h3>
            <label for="selected_timezone"><?php esc_html_e('Select Timezone:', 'beez-management'); ?></label>
            <select name="selected_timezone" id="selected_timezone">
                <?php foreach ($available_timezones as $timezone_value => $timezone_label) {
                    echo '<option value="' . esc_attr($timezone_value) . '" ' . selected($selected_timezone, $timezone_value, false) . '>' . esc_html($timezone_label) . '</option>';
                } ?>
            </select>

            <h3><?php esc_html_e('Appearance', 'beez-management'); ?></h3>
            <label for="bg_color"><?php esc_html_e('Background Color:', 'beez-management'); ?></label>
            <input type="color" name="bg_color" id="bg_color" value="<?php echo esc_attr($bg_color); ?>" />

            <label for="text_color"><?php esc_html_e('Text Color:', 'beez-management'); ?></label>
            <input type="color" name="text_color" id="text_color" value="<?php echo esc_attr($text_color); ?>" />

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'beez-management'); ?>">
            </p>
        </form>
    </div>
    <?php
}
