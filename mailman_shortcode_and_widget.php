<?php
/*
Plugin Name: Mailman Shortcode & Widget
Description: Creates a shortcode and a widget to display a signup form for a Mailman-powered mailing list
Version:     1.0
Author:      Thomas Ulrich
Author URI:  https://github.com/JustThomas
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: mailman-shortcode-and-widget
*/


function tu_mailman_subscribe_form( $ml_url, $button_text='', $field_label='' ) {
    if( empty($button_text) ) {
        $button_text = __('Subscribe', 'mailman-shortcode-and-widget');
    }

    if( empty($field_label) ) {
        $field_label = __('email:', 'mailman-shortcode-and-widget');
    }

    $ml_url = str_replace('/listinfo/', '/subscribe/', $ml_url);

    $ml_url = esc_url( $ml_url );
    if(empty($ml_url)) {
        return;
    } 

    $code = sprintf('<form method="post" action="%s">
        <label for="mailmanemail">%s</label>
        <input name="email" id="mailmanemail" value="" type="email">
        <input name="email-button" value="%s" type="submit">
        </form>', $ml_url, $field_label, $button_text);

    return $code;
}

function tu_mailman_unsubscribe_form( $ml_url, $button_text='', $field_label='' ) {
    if( empty($button_text) ) {
        $button_text = __('Unsubscribe', 'mailman-shortcode-and-widget');
    }

    if( empty($field_label) ) {
        $field_label = __('email:', 'mailman-shortcode-and-widget');
    }

    $ml_url = str_replace('/listinfo/', '/options/', $ml_url);

    $ml_url = esc_url( $ml_url );
    if(empty($ml_url)) {
        return;
    }

    $code = sprintf('<form method="post" action="%s">
        <label for="mailmanemail">%s</label>
        <input name="email" id="mailmanemail" value="" type="email">
        <input name="unsubconfirm" type="hidden" value="1">
        <input name="unsub" value="%s" type="submit">
        </form>', $ml_url, $field_label, $button_text);

    return $code;
}

// Add Shortcode
function mailman_subscribe_form_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'url' => '',
			'button_text' => '',
			'field_label' => '',
		), $atts )
	);

	return tu_mailman_subscribe_form( $ml_url, $button_text, $field_label );
}
add_shortcode( 'mailman_subscribe_form', 'mailman_subscribe_form_shortcode' );

// Add Shortcode
function mailman_unsubscribe_form_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'url' => '',
			'button_text' => '',
			'field_label' => '',
		), $atts )
	);

	return tu_mailman_unsubscribe_form( $ml_url, $button_text, $field_label );
}
add_shortcode( 'mailman_unsubscribe_form', 'mailman_unsubscribe_form_shortcode' );

require_once 'class.mailmanwidget.php';