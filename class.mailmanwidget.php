<?php
class Tu_Mailman_Widget extends WP_Widget {
    /**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct('tu_mailman_widget',
                __('Mailman Widget', 'mailman-shortcode-and-widget'),
                array('description' => __('Displays a(n) (un)subscribe form for a Mailman-powered mailing list', 'mailman-shortcode-and-widget'))
        );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

// register mailman widget
function register_tu_mailman_widget() {
    register_widget( 'Tu_Mailman_Widget' );
}
add_action( 'widgets_init', 'register_tu_mailman_widget' );