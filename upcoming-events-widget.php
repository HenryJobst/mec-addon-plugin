<?php
/**
 * Widget for upcoming events of modern events calendar lite plugin
 *
 * @package    MEC-Addon-Plugin
 */

class MEC_Addon_Upcoming_Events extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_upcoming_events', 'description' => 'A list of upcoming events.' );
        parent::__construct( 'upcoming-events-widget', __( 'Upcoming Events', 'mec-addon-plugin' ), $widget_ops );
    }

    /**
     * @param $instance
     * @param string $url URL
     * @param string $button_text Short text for the url button
     * @param string $title_text Long text for the url button
     * @return false|string
     */
    private function add_link_button(array $instance, string $url, string $button_text, string $title_text): string
    {
        $link_class = 'button';
        if ($instance['urls_class']) {
            $link_class = $instance['urls_class'];
        }
        return ' ' . '<a class="'. $link_class .'" title="'. $title_text . '" href="' . $url . '" target="_blank" rel="noopener external noreferrer">' . '<span>' . $button_text . '</span>' . '</a>';
    }

    private function get_formated_date(string $date_field, string $date_format): string
    {
        $zone = new DateTimeZone('Europe/Berlin');
        $formated_event_date = '';
        if ($date_field) {
            $event_date = date_timestamp_get(date_create_immutable_from_format('Y-m-d', $date_field, $zone));
            if ($event_date) {
                $formated_event_date = wp_date($date_format, $event_date, $zone);
            }
        }
        return $formated_event_date;
    }

    /**
     * @param string $date_format date format
     * @return false|string
     */
    private function get_formated_event_date(string $date_format): string
    {
        $date_field = get_post_meta(get_the_ID(), 'mec_start_date', true);
        if ($date_field) {
            return $this->get_formated_date($date_field, $date_format);
        }
        return false;
    }

    private function get_formated_registration_date(string $date_format): string
    {
        $date_field = get_post_meta(get_the_ID(), 'om_date_register', true);
        if ($date_field) {
            return $this->get_formated_date($date_field, $date_format);
        }
        return false;
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     *
     * @return void Echoes it's output
     **/
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );

        $count = esc_attr( $instance['count'] );
        $count = 0 < $count && $count < 11 ? $count : 5;
        $date_format = esc_attr( $instance['date_format']);
        if (!$date_format) {
            $date_format = 'j. F Y';
        }

        $loop  = new WP_Query( array(
            'post_type'      => 'mec-events',
            'posts_per_page' => $count,
            'order'          => 'ASC',
            'orderby'        => 'meta_value',
            'meta_key'       => 'mec_start_date',
            'meta_query'     => array(
                array(
                    'key'     => 'mec_start_date',
                    'value'   => date('Y-m-d', time()),
                    'compare' => '>=',
                ),
            ),
        ) );

        if ( $loop->have_posts() ):

            echo $before_widget;

            if ($title = $instance['title'] ) {
                echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;
            }

            echo '<ul class="display-post-listing upcoming-events-widget">';

            while ( $loop->have_posts() ): $loop->the_post();
                global $post;

                $output = '';

                if ($instance['show_sports_type']) {
                    if ($sport_type = get_post_meta(get_the_ID(), 'om_sport', true)) {
                        $sport_type_url = null;
                        if (strcasecmp('OL', $sport_type) == 0) {
                            $sport_type_url = '<img class="wp-image-16984" src="/wp-content/uploads/2021/01/OL_Logo_bunt-300x261.png" alt="OL" width="20" height="17" />&nbsp;';
                        } else if (strcasecmp('MTB-O', $sport_type) == 0) {
                            $sport_type_url = '<img class="wp-image-16983" src="/wp-content/uploads/2021/01/MTB_O_Logo_bunt-300x261.png" alt="MTB-O" width="20" height="17" />&nbsp;';
                        } else if (strcasecmp('Crosslauf', $sport_type) == 0) {
                            $sport_type_url = '<img class="wp-image-18174" src="/wp-content/uploads/2021/02/Crosslauf-FARBIG-150x150.png" alt="Cross" width="20" height="20" />&nbsp;';
                        }
                        if ($sport_type_url) {
                            $output = $output . $sport_type_url;
                        } else {
                            $output = $output . '<span>' . $sport_type . '</span>';
                        }
                    }
                }

                $formated_event_date = $this->get_formated_event_date($date_format);
                $output = $output . '<a class="title" href="' . get_permalink() . '">' . get_the_title() . '</a> <span class="date nobr">' . $formated_event_date . '</span> ';

                $formated_date_register = $this->get_formated_registration_date($date_format);
                if ($formated_date_register) {
                    $output = $output . '<span class="register-date nobr">(' . __('M','mec-addon-plugin') . ': ' . $formated_date_register . ')</span> ';
                }

                if ($instance['show_urls']) {
                    $output = $output . '<span class="event-urls nobr">';
                    if ($announcement_url = get_post_meta(get_the_ID(), 'om_link_announcement', true)) {
                        $output = $output . $this->add_link_button($instance, $announcement_url, __('A', 'mec-addon-plugin'), __('Ausschreibung', 'mec-addon-plugin'));
                    }
                    if ($registration_url = get_post_meta(get_the_ID(), 'om_link_registration', true)) {
                        $output = $output . $this->add_link_button($instance, $registration_url, __('M', 'mec-addon-plugin'), __('Meldung', 'mec-addon-plugin'));
                    }
                    if ($hy_results_url = get_post_meta(get_the_ID(), 'om_link_hygiene_concept', true)) {
                        echo $this->add_link_button($instance, $hy_results_url, __('H', 'mec-addon-plugin'), __('Hygienekonzept', 'mec-addon-plugin'));
                    }
                    if ($ti_results_url = get_post_meta(get_the_ID(), 'om_link_technical_information', true)) {
                        echo $this->add_link_button($instance, $ti_results_url, __('T', 'mec-addon-plugin'), __('Technische Hinweise', 'mec-addon-plugin'));
                    }
                    if ($ci_results_url = get_post_meta(get_the_ID(), 'om_link_course_information', true)) {
                        echo $this->add_link_button($instance, $ci_results_url, __('B', 'mec-addon-plugin'), __('Bahndaten', 'mec-addon-plugin'));
                    }
                    if ($start_list_url = get_post_meta(get_the_ID(), 'om_link_startlist', true)) {
                        $output = $output . $this->add_link_button($instance, $start_list_url, __('S', 'mec-addon-plugin'), __('Startliste', 'mec-addon-plugin'));
                    }
                    $output = $output . '</span>';
                }

                echo '<li class="listing-item">' . apply_filters( 'mec_addon_events_manager_upcoming_widget_output', $output, $post ) . '</li>';

            endwhile;

            if ( $instance['more_text'] && $instance['more_link']) {
                echo '<li class="listing-item"><a href="' . esc_attr( $instance['more_link'] ) . '">' . esc_attr( $instance['more_text'] ) . '</a></li>';
            }
            echo '</ul>';

            echo $after_widget;

        endif;
        wp_reset_postdata();
    }

    /**
     * Deals with the settings when they are saved by the admin.
     * Here is where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     *
     * @return array The validated and (if necessary) amended settings
     **/
    function update( $new_instance, $old_instance ): array
    {
        $instance = $old_instance;

        $instance['title']     = wp_kses_post( $new_instance['title'] );
        $instance['count']     = (int) esc_attr( $new_instance['count'] );
        $instance['more_text'] = esc_attr( $new_instance['more_text'] );
        $instance['more_link'] = esc_attr( $new_instance['more_link'] );
        $instance['date_format'] = esc_attr( $new_instance['date_format'] );
        $instance['show_sports_type'] = esc_attr( $new_instance['show_sports_type'] );
        $instance['show_urls'] = esc_attr( $new_instance['show_urls'] );
        $instance['urls_class'] = esc_attr( $new_instance['urls_class'] );

        return $instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     *
     * @return void Echoes it's output
     **/
    function form( $instance ) {

        $defaults = array(
            'title'     => __( 'Upcoming Events', 'mec-addon-plugin'),
            'count'     => 3,
            'more_text' => __( 'Show All', 'mec-addon-plugin'),
            'more_link' => __( 'Permalink to the page that show all events', 'mec-addon-plugin'),
            'date_format' => __( 'd. F Y', 'mec-addon-plugin'),
            'show_sports_type' => false,
            'show_urls' => false,
            'urls_class' => 'button',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

        echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( 'Title:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . esc_attr( $instance['title'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'count' ) . '">' . esc_html__( 'How Many:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'count' ) . '" name="' . $this->get_field_name( 'count' ) . '" value="' . esc_attr( $instance['count'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'more_text' ) . '">' . esc_html__( 'More Text:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'more_text' ) . '" name="' . $this->get_field_name( 'more_text' ) . '" value="' . esc_attr( $instance['more_text'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'more_link' ) . '">' . esc_html__( 'More Link:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'more_link' ) . '" name="' . $this->get_field_name( 'more_link' ) . '" value="' . esc_attr( $instance['more_link'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'date_format' ) . '">' . esc_html__( 'Date Format:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'date_format' ) . '" name="' . $this->get_field_name( 'date_format' ) . '" value="' . esc_attr( $instance['date_format'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'show_sports_type' ) . '">' . esc_html__( 'Show Sports Type:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'show_sports_type' ) . '" name="' . $this->get_field_name( 'show_sports_type' ) . '" value="' . esc_attr( $instance['show_sports_type'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'show_urls' ) . '">' . esc_html__( 'Show Urls:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'show_urls' ) . '" name="' . $this->get_field_name( 'show_urls' ) . '" value="' . esc_attr( $instance['show_urls'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'urls_class' ) . '">' . esc_html__( 'Urls Class:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'urls_class' ) . '" name="' . $this->get_field_name( 'urls_class' ) . '" value="' . esc_attr( $instance['urls_class'] ) . '" /></label></p>';

    }

}

function mec_addon_register_upcoming_events_widget() {
    register_widget( 'MEC_Addon_Upcoming_Events' );
}

add_action( 'widgets_init', 'mec_addon_register_upcoming_events_widget' );