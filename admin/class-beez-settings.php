<?php

function beez_get_timezones() {
    $timezones = DateTimeZone::listIdentifiers( DateTimeZone::ALL );
    $timezones_list = array();

    foreach ( $timezones as $timezone ) {
        $timezones_list[$timezone] = $timezone;
    }

    return $timezones_list;
}


function beez_menu_settings_page() {
    // Save Settings
     if ( isset( $_POST['submit'] ) ) {

        $days = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );
        foreach ( $days as $day ) {
            update_option( "beez_opening_hours_$day", sanitize_text_field( $_POST["opening_hours_$day"] ) );
            update_option( "beez_closing_hours_$day", sanitize_text_field( $_POST["closing_hours_$day"] ) );
        }

        update_option( 'beez_title', sanitize_text_field( $_POST['title'] ) );
        update_option( 'beez_opening_message', sanitize_text_field( $_POST['opening_message'] ) );
        update_option( 'beez_open_label', sanitize_text_field( $_POST['open_label'] ) );
        update_option( 'beez_closing_message', sanitize_text_field( $_POST['closing_message'] ) );
        update_option( 'beez_close_label', sanitize_text_field( $_POST['close_label'] ) );

        $time_format = isset( $_POST['time_format'] ) ? sanitize_text_field( $_POST['time_format'] ) : '12-hour';
        update_option( 'beez_time_format', $time_format );

        $selected_timezone = sanitize_text_field( $_POST['selected_timezone'] );
        update_option( 'beez_selected_timezone', $selected_timezone );
 
        update_option( 'beez_bg_color', sanitize_hex_color( $_POST['bg_color'] ) );
        update_option( 'beez_text_color', sanitize_hex_color( $_POST['text_color'] ) );
        update_option( 'beez_font_size', sanitize_text_field( $_POST['font_size'] ) );

        $display_timezone_message = isset( $_POST['display_timezone_message'] ) ? 'on' : 'off';
        update_option( 'beez_display_timezone_message', $display_timezone_message );

        $display_local_time_message = isset( $_POST['display_local_time_message'] ) ? 'on' : 'off';
        update_option( 'beez_display_local_time_message', $display_local_time_message );
    }

    // Retrieve settings
    $time_format                = get_option( 'beez_time_format', '12-hour' );
    $opening_hours              = get_option( 'beez_opening_hours', '08:00' );
    $closing_hours              = get_option( 'beez_closing_hours', '17:00' );
    $display_timezone_message   = get_option( 'beez_display_timezone_message', 'off' );
    $display_local_time_message = get_option( 'beez_display_local_time_message', 'on' );
    $title                      = get_option( 'beez_title', 'Business Hours' );
    $opening_message            = get_option( 'beez_opening_message', 'We are currently open!' );
    $open_label                 = get_option( 'beez_open_label', 'open' );
    $closing_message            = get_option( 'beez_closing_message', 'Sorry we are curently closed!' );
    $close_label                = get_option( 'beez_close_label', 'closed' );
    $bg_color                   = get_option( 'beez_bg_color', '#ffffff' );
    $text_color                 = get_option( 'beez_text_color', '#000000' );
    $font_size                  = get_option( 'beez_font_size', '14px');
    $selected_timezone          = get_option( 'beez_selected_timezone', 'UTC' );
    $available_timezones        = beez_get_timezones();
    ?>
    <div class="wrap" style="width: 100%; display: flex;">
        <section style="width: 100%;">        
            <div class="beez-tabs">
                <div class="beez-tab" id="tab1"><?php esc_html_e( 'General', 'beez-management' ); ?></div>
                <div class="beez-tab" id="tab2"><?php esc_html_e( 'Messages', 'beez-management' ); ?></div>
                <div class="beez-tab" id="tab3"><?php esc_html_e( 'Advanced', 'beez-management' ); ?></div>
                <div class="beez-tab" id="tab4"><?php esc_html_e( 'Appearance', 'beez-management' ); ?></div>
            </div>

            <form method="post" class="settings-content">
                <!-- start of tab -->
                <div id="content-tab1" class="beez-tab-content" style="display: block;">
                <p><span class="copy-business-hours-shortcode"> short code to use [business_hours]</span></p>

                    <?php
                    $current_local_time = date( 'H:i', current_time( 'timestamp', true ) );
                    echo '<p>Enter time hours in 24-hour format e.g ' . esc_html( $current_local_time ) . '</p>';
                    ?>

                    <?php
                    $days = array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' );
                    echo '<div style="display: grid; grid-template-columns: repeat( 7, 1fr ); grid-gap: 20px;">';

                    // Days row
                    echo '<div style="display: flex; flex-direction: column; text-align: left;">';
                    echo '<label style="margin-bottom: 20px;"></label>';
                    foreach ( $days as $day ) {
                        echo '<p style="margin-top: 5.5px; margin-bottom: 5.5px;">' . esc_html( ucfirst( $day ) ) . '</p>';
                    }
                    echo '</div>';

                    // Opening Hours row
                    echo '<div style="display: flex; flex-direction: column; align-items: center;">';
                    echo '<label style="margin-bottom: 5px;">' . esc_html__( 'Opening Hours', 'beez-management' ) . '</label>';
                    foreach ( $days as $day ) {
                        echo '<input type="text" name="opening_hours_' . $day . '" value="' . esc_attr( get_option( "beez_opening_hours_$day", '' ) ) . '" />';
                    }
                    echo '</div>';

                    // Closing Hours row
                    echo '<div style="display: flex; flex-direction: column; align-items: center;">';
                    echo '<label style="margin-bottom: 5px;">' . esc_html__( 'Closing Hours', 'beez-management' ) . '</label>';
                    foreach ( $days as $day ) {
                        echo '<input type="text" name="closing_hours_' . $day . '" value="' . esc_attr( get_option( "beez_closing_hours_$day", '' ) ) . '" />';
                    }
                    echo '</div>';

                    echo '</div>';

                    ?>
                </div>
                
                <!-- end of tab  -->

                <!-- start of tab -->
                <div id="content-tab2" class="beez-tab-content">
                    <section class="beez-hours-inputs" style="display: flex; flex-direction: column; max-width: 520px; margin-top: 30px;">               

                    <div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
                        <label for="title" style="width: 26%;"><?php esc_html_e( 'Title:', 'beez-management' ); ?></label>
                        <input type="text" style="width: 74%;" name="title" id="title" value="<?php echo esc_attr( $title ); ?>" />
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
                        <label for="opening_message" style="width: 26%;"><?php esc_html_e( 'Opening Message:', 'beez-management' ); ?></label>
                        <input type="text" style="width: 74%; min-height: 50px;" name="opening_message" id="opening_message" value="<?php echo esc_attr( $opening_message ); ?>" />
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
                    <label for="open_label" style="width: 26%;"><?php esc_html_e( 'Opening label:', 'beez-management' ); ?></label>
                    <input type="text" style="width: 74%;" name="open_label" id="open_label" value="<?php echo esc_attr( $open_label ); ?>" />
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
                    <label for="closing_message" style="width: 26%;"><?php esc_html_e( 'Closing Message:', 'beez-management' ); ?></label>
                    <input type="text" style="width: 74%; min-height: 50px;" name="closing_message" id="closing_message" value="<?php echo esc_attr( $closing_message ); ?>" />
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
                    <label for="close_label" style="width: 26%;"><?php esc_html_e( 'Closing label:', 'beez-management' ); ?></label>
                    <input type="text" style="width: 74%;" name="close_label" id="close_label" value="<?php echo esc_attr( $close_label ); ?>" />
                    </div>

                    </section>
                </div>           

                <!-- End of Tab -->

                <!-- start of tab  -->

                <div id="content-tab3" class="beez-tab-content">
                    <h3><?php esc_html_e( 'Time Format', 'beez-management' ); ?></h3>
                    <div>
                        <label>
                            <input type="radio" name="time_format" value="12-hour" <?php checked( $time_format, '12-hour' ); ?>>
                            <?php esc_html_e( '12-hour Format', 'beez-management' ); ?>
                        </label>
                        <label>
                            <input type="radio" name="time_format" value="24-hour" <?php checked( $time_format, '24-hour' ); ?>>
                            <?php esc_html_e( '24-hour Format', 'beez-management' ); ?>
                        </label>
                    </div>

                    <h3><?php esc_html_e( 'Timezone', 'beez-management' ); ?></h3>
                    <label for="selected_timezone"><?php esc_html_e( 'Select Timezone:', 'beez-management' ); ?></label>
                    <select name="selected_timezone" id="selected_timezone">
                        <?php foreach ( $available_timezones as $timezone_value => $timezone_label ) {
                            echo '<option value="' . esc_attr( $timezone_value ) . '" ' . selected( $selected_timezone, $timezone_value, false ) . '>' . esc_html( $timezone_label ) . '</option>';
                        } ?>
                    </select>


                    <h3><?php esc_html_e( 'Display Messages', 'beez-management' ); ?></h3>
                    <div  style="display: flex; flex-direction:column;">
                        <label style="margin-bottom: 10px;">
                            <input type="checkbox" class="checkbox" name="display_timezone_message" <?php checked( $display_timezone_message, 'on' ); ?>>
                            <?php esc_html_e( 'Display Timezone Message', 'beez-management' ); ?>
                        </label>
                        <label>
                            <input type="checkbox" name="display_local_time_message" <?php checked( $display_local_time_message, 'on' ); ?>>
                            <?php esc_html_e( 'Display Local Time Message', 'beez-management' ); ?>
                        </label>
                    </div>               

                </div>

                <!-- End of tab -->

                <!-- start of tab -->
                <div id="content-tab4" class="beez-tab-content">           
                    <h3><?php esc_html_e( 'Appearance', 'beez-management' ); ?></h3>
                    <label for="bg_color"><?php esc_html_e( 'Background Color:', 'beez-management' ); ?></label>
                    <input type="color" name="bg_color" id="bg_color" value="<?php echo esc_attr( $bg_color ); ?>" />

                    <label for="text_color"><?php esc_html_e( 'Text Color:', 'beez-management' ); ?></label>
                    <input type="color" name="text_color" id="text_color" value="<?php echo esc_attr( $text_color ); ?>" />


                    <label for="font_size"><?php esc_html_e( 'Font Size:', 'beez-management' ) ?></label>
                    <input type="text" name="font_size" id="font_size" value="<?php echo esc_attr( $font_size ); ?>" />
                </div>
                <!-- end of tab -->

                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button" style="margin-left: 5px; border: 2px solid #fff; color: white; background-color: rgb( 151, 25, 122 );" value="<?php esc_attr_e( 'Save Changes', 'beez-management' ); ?>">
                </p>

            </form>
        </section>
    </div>
    <?php
}


