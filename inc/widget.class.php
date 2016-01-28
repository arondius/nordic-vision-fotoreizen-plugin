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

		$output = $args['before_widget'];
		$base = new webbb_fotoreizen_base();
		$reisgegevens = $base->get_travel_fields();
		// If any values: output table start tag
		if(!empty($reisgegevens)) {
			
			foreach($reisgegevens as $reiscode => $value) {
				$output .= '<table class="reisdata-tabel">';
				$output .= '<tr><th>Reiscode:</th><th>' . $reiscode . '</th></tr>';

				// If the custom field has a value
				if($value['data'] !== '') {
					foreach ($value['data'] as $key => $data) {
						if($data[1]) {
							// Replace underscores with dashes, so the HTML classnames look nice
							$key_formatted = str_replace('_', '-', $key);
							$output .= '<tr class="' . $key_formatted . '">';
								$output .= '<td class="reisdata-title" >' . $data[0] . '</td>';
								$output .= '<td class="reisdata-value">' . $data[1] . '</td>';
							$output .= '</tr>';
						}
					}
				}
				$output .= '</table>';
				$output .= '<div class="main-cta">';
				if($reisgegevens[$reiscode]['bookable']) {
					$output .= '<a href="' . site_url() . '/boek-een-fotoreis/?reiscode='. $reiscode.'" class="main-cta__link active"><span data-av_icon="" data-av_iconfont="entypo-fontello"></span><span class="avia_iconbox_title">Boek deze reis</span></a>';
				} else {
					$output .= '<span class="main-cta__link inactive">
													<span data-av_icon="" data-av_iconfont="entypo-fontello"></span>
													<span class="avia_iconbox_title">Volgeboekt</span>
												</span>
											';
				}
				$output .= '</div>';
			}
		}
		$output .= $args['after_widget'];
		echo $output;
	}
}

function webbb_register_acf_cf_widget() {

		register_widget( 'Fotoreizen_ACF_CF_Widget' );

}
add_action( 'widgets_init', 'webbb_register_acf_cf_widget' );