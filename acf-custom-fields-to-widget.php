<?php
/**
 * Plugin Name: ACF Display Custom Field Widget
 * Description: A widget that allows you to display custom field values in a widget
 * Version: 0.1
 * Author: Arend Hosman
 * Author URI: http://arendhosman.nl
 */

class ACF_CF_Widget extends WP_Widget {

		function __construct() {
			parent::__contstruct(
				// base ID of the wiget
				'webbb_acf_cf_widget',

				//name of the widget
				__('ACF Display Custom Field Widget'),

				// widget options
				array (
					'description' => 'A widget that allows you to display custom field values in a widget'
				)
			);
		}

		function form( $instance ) {

		}

		function update( $new_instance, $old_instance ) {

		}

		function widget( $args, $instance ) {

		}
}

add_action( 'widgets_init', function() {
    return register_widget(new ACF_CF_Widget);
});