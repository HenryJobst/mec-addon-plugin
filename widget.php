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
        $count = 0 < $count && $count < 10 ? $count : 2;
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
                    'compare' => '>',
                ),
            ),
        ) );
        if ( $loop->have_posts() ):

            echo $before_widget;

            if ( $instance['title'] ) {
                echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;
            }

            echo '<ul class="display-post-listing">';

            while ( $loop->have_posts() ): $loop->the_post();
                global $post;
                $output = '<a class="title" href="' . get_permalink() . '">' . get_the_title() . '</a> <span class="date">' . date( 'j. F Y', date_timestamp_get(date_create_immutable_from_format('Y-m-d', get_post_meta(get_the_ID(),'mec_start_date',true)))) . '</span> ';
                echo '<li class="listing-item">' . apply_filters( 'mec_addon_events_manager_upcoming_widget_output', $output, $post ) . '</li>';
            endwhile;

            if ( $instance['more_text'] ) {
                echo '<li class="listing-item"><a href="' . get_post_type_archive_link('mec-events') . '">' . esc_attr( $instance['more_text'] ) . '</a></li>';
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
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']     = wp_kses_post( $new_instance['title'] );
        $instance['count']     = (int) esc_attr( $new_instance['count'] );
        $instance['more_text'] = esc_attr( $new_instance['more_text'] );

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
            'count'     => 2,
            'more_text' => __( 'View All Event Information', 'mec-addon-plugin'),
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

        echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( 'Title:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . esc_attr( $instance['title'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'count' ) . '">' . esc_html__( 'How Many:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'count' ) . '" name="' . $this->get_field_name( 'count' ) . '" value="' . esc_attr( $instance['count'] ) . '" /></label></p>';
        echo '<p><label for="' . $this->get_field_id( 'more_text' ) . '">' . esc_html__( 'More Text:', 'mec-addon-plugin' ) . ' <input class="widefat" id="' . $this->get_field_id( 'more_text' ) . '" name="' . $this->get_field_name( 'more_text' ) . '" value="' . esc_attr( $instance['more_text'] ) . '" /></label></p>';

    }
}

function mec_addon_register_upcoming_events_widget() {
    register_widget( 'MEC_Addon_Upcoming_Events' );
}

add_action( 'widgets_init', 'mec_addon_register_upcoming_events_widget' );