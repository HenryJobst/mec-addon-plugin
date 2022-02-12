<?php
/**
 * Widget for past events of modern events calendar lite plugin
 *
 * @package    MEC-Addon-Plugin
 */

class MEC_Addon_Past_Events extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'widget_past_events', 'description' => 'A list of past events.' );
        parent::__construct( 'past-events-widget', __( 'Past Events', 'mec-addon-plugin' ), $widget_ops );
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
    
    private function add_extra_link_button(array $instance, string $om_link_extra, string $om_title_extra, string $om_symbol_extra, string $om_mode_extra): string
    {
        if ($extra_list_url = get_post_meta(get_the_ID(), $om_link_extra, true)) {
            if ($extra_mode = get_post_meta(get_the_ID(), $om_mode_extra, true)) {
                if ($extra_mode == '2') {
                    // 2 - show only for upcomming events => ignore in this widget
                    return '';
                }
            }
            $extra_title = __('Extra', 'mec-addon-plugin');
            if ($extra_title_meta = get_post_meta(get_the_ID(), $om_title_extra, true)) {
                $extra_title = $extra_title_meta;
            }
            $extra_symbol = __('E', 'mec-addon-plugin');
            if ($extra_symbol_meta = get_post_meta(get_the_ID(), $om_symbol_extra, true)) {
                $extra_symbol = $extra_symbol_meta;
            }
            return $this->add_link_button($instance, $extra_list_url, $extra_symbol, $extra_title);
        }

        return '';
    }

    /**
     * @param string $date_format date format
     * @return false|string
     */
    private function get_formated_event_date(string $date_format): string
    {
        $zone = new DateTimeZone('Europe/Berlin');
        $formated_event_date = '';
        $date_field = get_post_meta(get_the_ID(), 'mec_start_date', true);
        if ($date_field) {
            $event_date = date_timestamp_get(date_create_immutable_from_format('Y-m-d', $date_field, $zone));
            if ($event_date) {
                $formated_event_date = wp_date($date_format, $event_date, $zone);
            }
        }
        return $formated_event_date;
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
            'order'          => 'DESC',
            'orderby'        => 'meta_value',
            'meta_key'       => 'mec_start_date',
            'meta_query'     => array(
                array(
                    'key'     => 'mec_start_date',
                    'value'   => date('Y-m-d', time()),
                    'compare' => '<=',
                ),
            ),
        ) );

        if ( $loop->have_posts() ):

            echo $before_widget;

            if ($title = $instance['title'] ) {
                echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;
            }

            echo '<ul class="display-post-listing past-events-widget">';

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
                        } else if (strcasecmp('Ski-OL', $sports_type) == 0) {
                            $sport_type_url = '<img class="wp-image-23012" src="/wp-content/uploads/2022/02/Ski_OL_Logo_bunt-300x261.png" alt="Ski-OL" width="20" height="17" />&nbsp;';
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

                if ($instance['show_urls']) {
                    $output = $output . '<span class="event-urls nobr">';
                    if ($results_url = get_post_meta(get_the_ID(), 'om_link_results', true)) {
                        $output = $output . $this->add_link_button($instance, $results_url, __('E', 'mec-addon-plugin'), __('Ergebnisse', 'mec-addon-plugin'));
                    }
                    if ($si_results_url = get_post_meta(get_the_ID(), 'om_link_resultsplits', true)) {
                        $output = $output . $this->add_link_button($instance, $si_results_url, __('Si', 'mec-addon-plugin'), __('Splittzeiten', 'mec-addon-plugin'));
                    }
                    if ($ws_results_url = get_post_meta(get_the_ID(), 'om_link_winsplits', true)) {
                        $output = $output . $this->add_link_button($instance, $ws_results_url, __('W', 'mec-addon-plugin'), __('WinSplits', 'mec-addon-plugin'));
                    }
                    if ($rg_results_url = get_post_meta(get_the_ID(), 'om_link_routegadget', true)) {
                        $output = $output . $this->add_link_button($instance, $rg_results_url, __('R', 'mec-addon-plugin'), __('RouteGadget', 'mec-addon-plugin'));
                    }
                    
                    $output = $output . $this->add_extra_link_button($instance, 'om_link_extra_1', 'om_title_extra_1', 'om_symbol_extra_1', 'om_mode_extra_1');
                    $output = $output . $this->add_extra_link_button($instance, 'om_link_extra_2', 'om_title_extra_2', 'om_symbol_extra_2', 'om_mode_extra_2');
                    $output = $output . $this->add_extra_link_button($instance, 'om_link_extra_3', 'om_title_extra_3', 'om_symbol_extra_3', 'om_mode_extra_3');

                    $output = $output . '</span>';
                }

                echo '<li class="listing-item">' . apply_filters( 'mec_addon_events_manager_past_widget_output', $output, $post ) . '</li>';

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
            'title'     => __( 'Past Events', 'mec-addon-plugin'),
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

function mec_addon_register_past_events_widget() {
    register_widget( 'MEC_Addon_Past_Events' );
}

add_action( 'widgets_init', 'mec_addon_register_past_events_widget' );