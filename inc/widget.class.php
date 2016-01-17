<?php
require_once('base.class.php');

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class Fotoreizen_ACF_CF_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// base ID of the wiget
			'fotoreizen_acf_cf_widget',

			//name of the widget
			__('Fotoreizen ACF Custom Fields Widget'),

			// widget options
			array (
				'description' => 'A widget that allows you to display ACF custom field values in a widget'
			)
		);
	}

	function form( $instance ) {

	}

	function update( $new_instance, $old_instance ) {

	}

	function widget( $args, $instance ) {

		/*

			To do: It would be better to get all the values and loop through them automatically

		 */


		$output = $args['before_widget'];
		$base = new webbb_fotoreizen_base();
		$reisgegevens = $base->get_travel_fields();

		if(!empty($reisgegevens_single)) { // If any values: output table start tag
			$output .= '<table class="reisdata-tabel">';
			foreach($reisgegevens_single['data'] as $key => $value) {  // loop through the array
				if($value[1] !== '') { // If the custom field has a value
					$key_formatted = str_replace('_', '-', $key); // Replace underscores with dashes, so the classnames look nice
					$output .= '<tr class="' . $key_formatted . '">';
						$output .= '<td class="reisdata-title" >' . $value[0] . '</td>';
						$output .= '<td class="reisdata-value">' . $value[1] . '</td>';
					$output .= '</tr>';
				}
			}
			$output .= '</table>';
		}
		if($reisgegevens_single['bookable']) {
			$output .= '<div class="main-cta"><a href="' . site_url() . '/boek-een-fotoreis/" class="main-cta__link active"><span data-av_icon="" data-av_iconfont="entypo-fontello"></span><span class="avia_iconbox_title">Boek deze reis</span></a></div>';
		} else {
			$output .= '<div class="main-cta"><span class="main-cta__link inactive"><span data-av_icon="" data-av_iconfont="entypo-fontello"></span><span class="avia_iconbox_title">Volgeboekt</span></a></div>';
		}
		$output .= $args['after_widget'];
		echo $output;
	}
}

function webbb_register_acf_cf_widget() {

		register_widget( 'Fotoreizen_ACF_CF_Widget' );

}
add_action( 'widgets_init', 'webbb_register_acf_cf_widget' );