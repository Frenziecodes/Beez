<?php

function beez_menu_settings_page() {
    // Save Settings
     if (isset($_POST['submit'])) {
        // Save opening and closing hours
        update_option('beez_opening_hours', sanitize_text_field($_POST['opening_hours']));
        update_option('beez_closing_hours', sanitize_text_field($_POST['closing_hours']));

        // Save messages and labels
        update_option('beez_title', sanitize_text_field($_POST['title']));
        update_option('beez_opening_message', sanitize_text_field($_POST['opening_message']));
        update_option('beez_open_label', sanitize_text_field($_POST['open_label']));
        update_option('beez_closing_message', sanitize_text_field($_POST['closing_message']));
        update_option('beez_close_label', sanitize_text_field($_POST['close_label']));
 
        // Save colors
        update_option('beez_bg_color', sanitize_hex_color($_POST['bg_color']));
        update_option('beez_text_color', sanitize_hex_color($_POST['text_color']));
    }

    // Retrieve settings
    $opening_hours = get_option('beez_opening_hours', '');
    $closing_hours = get_option('beez_closing_hours', '');
    $title = get_option('beez_title', '');
    $opening_message = get_option('beez_opening_message', '');
    $open_label = get_option('beez_open_label', '');
    $closing_message = get_option('beez_closing_message', '');
    $close_label = get_option('beez_close_label', '');
    $bg_color = get_option('beez_bg_color', '#ffffff');
    $text_color = get_option('beez_text_color', '#000000');
    ?>
    <div class="wrap">
        <h2><?php esc_html_e('Business Hours Settings', 'beez-management'); ?></h2>
        <form method="post">
            <h3><?php esc_html_e('Opening and Closing Hours', 'beez-management'); ?></h3>
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
