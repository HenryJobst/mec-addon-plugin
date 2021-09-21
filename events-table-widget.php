<?php
/**
 * Widget for a table of events of modern events calendar lite plugin
 *
 * @package    MEC-Addon-Plugin
 */

function add_evtw_year_parameter_to_queryvars( $qvars ) {
    $qvars[] = 'evtw_year';
    return $qvars;
}

add_filter( 'query_vars', 'add_evtw_year_parameter_to_queryvars' );

class MEC_Addon_Events_Table_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_events_table', 'description' => 'A table of events.' );
        parent::__construct( 'events-table-widget', __( 'Events Table', 'mec-addon-plugin' ), $widget_ops );
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

    private function add_nav_links($url, $year) {
        $result = '<p><div class="pagination"><a class="prev_page-numbers" data-wpel-link="internal" href="' . $url . '/?evtw_year=' . ($year-1) . '">« Zurück</a>';
        $result .= ' <a class="next_page-numbers" data-wpel-link="internal" href="' . $url . '/?evtw_year=' . ($year+1) . '">Weiter »</a></div></p>';
        return $result;
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

        $date_format = esc_attr( $instance['date_format']);
        if (!$date_format) {
            $date_format = 'j. F Y';
        }

        $actual_year = date('Y', time());
        
        global $wp_query;
        if (isset($wp_query->query_vars['evtw_year'])) {
            $year_param = sanitize_text_field($wp_query->query_vars['evtw_year']);
            $actual_year = $year_param;
        }

        $start_date = $actual_year . "-01-01";
        $end_date = $actual_year . "-12-31";

        $loop  = new WP_Query( array(
            'post_type'      => 'mec-events',
            'nopaging'       => true,
            'order'          => 'ASC',
            'orderby'        => 'meta_value',
            'meta_key'       => 'mec_start_date',
            'meta_query'     => array(
                array(
                    'key'     => 'mec_start_date',
                    'value'   => array($start_date, $end_date),
                    'compare' => 'BETWEEN',
                    'type'    => 'DATE',
                ),
            ),
        ) );

        echo $before_widget;

        if ($title = $instance['title'] ) {
            echo $before_title . apply_filters( 'widget_title', $title ) . '&nbsp;' . $actual_year . $after_title;
        }
        
        global $wp;
        $this_url = home_url($wp->request);

        echo $this->add_nav_links($this_url, $actual_year);

        if ( $loop->have_posts() ) {

            echo '<table class="events-table-widget-table">';
            echo '<thead>';
            echo '<tr class="etw-table-row">';
            echo '<th>' . __('Termin', 'mec-addon-plugin') . '</th>';
            echo '<th>' . __('Meldetermin', 'mec-addon-plugin') . '</th>';
            echo '<th>' . __('Sportart', 'mec-addon-plugin') . '</th>';
            echo '<th>' . __('Rubrik', 'mec-addon-plugin') . '</th>';
            echo '<th>' . __('Wettkampf', 'mec-addon-plugin') . '</th>';
            echo '<th>' . __('Links', 'mec-addon-plugin') . '</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ( $loop->have_posts() ): $loop->the_post();
                global $post;

                echo '<tr class="etw-table-row">';

                $formated_event_date = $this->get_formated_event_date($date_format);
                echo '<td><span class="etw-date nobr">' . $formated_event_date . '</span></td>';

                $formated_register_date = $this->get_formated_registration_date($date_format);
                if ($formated_register_date) {
                    echo '<td><span class="etw-register-date nobr">' . $formated_register_date . '</span></td>';
                } else {
                    echo '<td><span class="etw-register-date nobr">&nbsp;</span></td>';
                }

                echo '<td>';
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
                            echo '<div class="etw-type">' . $sport_type_url . '</div>';
                        } else {
                            echo '<span class="etw-type">' . $sport_type . '</span>';
                        }
                    }
                } else {
                    if ($sport_type = get_post_meta(get_the_ID(), 'om_sport', true)) {
                        echo '<span class="etw-type">' . $sport_type . '</span>';
                    } else {
                        echo '<span class="etw-type">' . '&nbsp;' . '</span>';
                    }
                }
                echo '</td>';

                echo '<td>';
                if ($classification = get_post_meta(get_the_ID(), 'om_classification', true)) {
                    echo '<span class="etw-classification">' . $classification . '</span>';
                } else {
                    echo '<span class="etw-classification">' . '&nbsp;' . '</span>';
                }
                echo '</td>';

                echo '<td><a class="etw-title" href="' . get_permalink() . '">' . get_the_title() . '</a></td>';

                echo '<td>';
                if ($instance['show_urls']) {
                    echo '<span class="etw-urls nobr">';
                    if ($announcement_url = get_post_meta(get_the_ID(), 'om_link_announcement', true)) {
                        echo $this->add_link_button($instance, $announcement_url, __('A', 'mec-addon-plugin'), __('Ausschreibung', 'mec-addon-plugin'));
                    }
                    if ($registration_url = get_post_meta(get_the_ID(), 'om_link_registration', true)) {
                        echo $this->add_link_button($instance, $registration_url, __('M', 'mec-addon-plugin'), __('Meldung', 'mec-addon-plugin'));
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
                        echo $this->add_link_button($instance, $start_list_url, __('S', 'mec-addon-plugin'), __('Startliste', 'mec-addon-plugin'));
                    }
                    if ($results_url = get_post_meta(get_the_ID(), 'om_link_results', true)) {
                        echo $this->add_link_button($instance, $results_url, __('E', 'mec-addon-plugin'), __('Ergebnisse', 'mec-addon-plugin'));
                    }
                    if ($si_results_url = get_post_meta(get_the_ID(), 'om_link_resultsplits', true)) {
                        echo $this->add_link_button($instance, $si_results_url, __('Si', 'mec-addon-plugin'), __('Splittzeiten', 'mec-addon-plugin'));
                    }
                    if ($ws_results_url = get_post_meta(get_the_ID(), 'om_link_winsplits', true)) {
                        echo $this->add_link_button($instance, $ws_results_url, __('W', 'mec-addon-plugin'), __('WinSplits', 'mec-addon-plugin'));
                    }
                    if ($rg_results_url = get_post_meta(get_the_ID(), 'om_link_routegadget', true)) {
                        echo $this->add_link_button($instance, $rg_results_url, __('R', 'mec-addon-plugin'), __('RouteGadget', 'mec-addon-plugin'));
                    }
                    echo '</span>';
                } else {
                    echo '<span class="etw-urls nobr">&nbsp;</span>';
                }
                echo '</td>';

                echo '</tr>';

            endwhile;

            echo '</tbody>';
            echo '</table>';

        } else {
            echo __('No events available.', 'mec-addon-plugin');
        }

        echo $this->add_nav_links($this_url, $actual_year);

        echo $after_widget;

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
            'date_format' => __( 'd. F Y', 'mec-addon-plugin'),
            'show_sports_type' => false,
            'show_urls' => false,
            'urls_class' => 'button',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

        echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( 'Title:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . esc_attr( $instance['title'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'date_format' ) . '">' . esc_html__( 'Date Format:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'date_format' ) . '" name="' . $this->get_field_name( 'date_format' ) . '" value="' . esc_attr( $instance['date_format'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'show_sports_type' ) . '">' . esc_html__( 'Show Sports Type:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'show_sports_type' ) . '" name="' . $this->get_field_name( 'show_sports_type' ) . '" value="' . esc_attr( $instance['show_sports_type'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'show_urls' ) . '">' . esc_html__( 'Show Urls:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'show_urls' ) . '" name="' . $this->get_field_name( 'show_urls' ) . '" value="' . esc_attr( $instance['show_urls'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'urls_class' ) . '">' . esc_html__( 'Urls Class:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'urls_class' ) . '" name="' . $this->get_field_name( 'urls_class' ) . '" value="' . esc_attr( $instance['urls_class'] ) . '" /></label></p>';

    }

}

function mec_addon_register_events_table_widget() {
    register_widget( 'MEC_Addon_Events_Table_Widget' );
}

add_action( 'widgets_init', 'mec_addon_register_events_table_widget' );
