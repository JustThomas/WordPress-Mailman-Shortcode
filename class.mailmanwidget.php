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
        $ml_url = $instance['ml_url'];

	    echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
        if( $instance['show_subscribe'] ) {
            echo $instance['subscribe_text'];
            echo tu_mailman_subscribe_form($ml_url);
        }

        if( $instance['show_unsubscribe'] ) {
            echo $instance['unsubscribe_text'];
            echo tu_mailman_unsubscribe_form($ml_url);
        }

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
        $title = empty($instance['title']) ? __('Mailing list', 'mailman-shortcode-and-widget') : $instance['title'];
        $ml_url = empty($instance['ml_url']) ? '' : $instance['ml_url'];
        $show_subscribe = isset($instance['show_subscribe']) ? (bool) $instance['show_subscribe'] : FALSE;
        $show_unsubscribe = isset($instance['show_unsubscribe']) ? (bool) $instance['show_unsubscribe'] : FALSE;
        $subscribe_text = isset($instance['subscribe_text']) ? $instance['subscribe_text'] : '';
        $unsubscribe_text = isset($instance['unsubscribe_text']) ? $instance['unsubscribe_text'] : '';
		?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'mailman-shortcode-and-widget'); ?></label>
<input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>

<p><label for="<?php echo $this->get_field_id('ml_url'); ?>"><?php _e('Mailing list URL', 'mailman-shortcode-and-widget'); ?></label>
<input type="url" class="widefat" name="<?php echo $this->get_field_name('ml_url'); ?>" id="<?php echo $this->get_field_id('ml_url'); ?>" value="<?php echo esc_url($ml_url); ?>"></p>

<p><input type="checkbox" name="<?php echo $this->get_field_name('show_subscribe'); ?>" id="<?php echo $this->get_field_id('show_subscribe'); ?>" <?php echo $show_subscribe ? ' checked ' : ''; ?> >
<label for="<?php echo $this->get_field_id('show_subscribe'); ?>"><?php _e('Show subscribe form', 'mailman-shortcode-and-widget'); ?></label><br>
<input type="checkbox" name="<?php echo $this->get_field_name('show_unsubscribe'); ?>" id="<?php echo $this->get_field_id('show_unsubscribe'); ?>" <?php echo $show_unsubscribe ? ' checked ' : ''; ?> >
<label for="<?php echo $this->get_field_id('show_unsubscribe'); ?>"><?php _e('Show unsubscribe form', 'mailman-shortcode-and-widget'); ?></label></p>

<p><label for="<?php echo $this->get_field_id('subscribe_text'); ?>"><?php _e('Text before subscribe form', 'mailman-shortcode-and-widget'); ?></label>
<textarea class="widefat" name="<?php echo $this->get_field_name('subscribe_text'); ?>" id="<?php echo $this->get_field_id('subscribe_text'); ?>"><?php echo esc_textarea($subscribe_text); ?></textarea></p>

<p><label for="<?php echo $this->get_field_id('unsubscribe_text'); ?>"><?php _e('Text before unsubscribe form', 'mailman-shortcode-and-widget'); ?></label>
<textarea class="widefat" name="<?php echo $this->get_field_name('unsubscribe_text'); ?>" id="<?php echo $this->get_field_id('unsubscribe_text'); ?>"><?php echo esc_textarea($unsubscribe_text); ?></textarea></p>
<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = empty( $new_instance['title'] ) ? '' : strip_tags( $new_instance['title'] );
        $instance['ml_url'] = empty( $new_instance['ml_url'] ) ? '' : esc_url_raw( $new_instance['ml_url'] );
        $instance['show_subscribe'] = ! empty( $new_instance['show_subscribe'] );
        $instance['show_unsubscribe'] = ! empty( $new_instance['show_unsubscribe'] );
        $instance['subscribe_text'] = empty( $new_instance['subscribe_text'] ) ? '' : strip_tags( $new_instance['subscribe_text'] );
        $instance['unsubscribe_text'] = empty( $new_instance['unsubscribe_text'] ) ? '' : strip_tags( $new_instance['unsubscribe_text'] );

        return $instance;
	}
}

// register mailman widget
function register_tu_mailman_widget() {
    register_widget( 'Tu_Mailman_Widget' );
}
add_action( 'widgets_init', 'register_tu_mailman_widget' );