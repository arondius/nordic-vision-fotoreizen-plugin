<?php
/**
 * Plugin Name: Display ACF Custom Fields in Widget
 * Description: A widget that allows you to display ACF custom field values in a widget
 * Version: 0.1
 * Author: Arend Hosman
 * Author URI: http://arendhosman.nl
 */

class ACF_CF_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// base ID of the wiget
			'webbb_acf_cf_widget',

			//name of the widget
			__('Display ACF Custom Fields in Widget'),

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

		if(class_exists('acf')) { // We depend on the Advanced Custom Fields plugin, so check taht it is active

			if(have_rows('reiscode_datum', $post->ID)) { // Repeater Fields for reisdata
				while(have_rows('reiscode_datum', $post->ID)) {
					the_row();

					// Put the fields in an array
					$reisgegevens['reiscode'] = array(__('Reiscode'), (get_sub_field('reiscode')) ? get_sub_field('reiscode') : '');
					$reisgegevens['reisdatum_start'] = array(__('Vertrek'), (get_sub_field('reisdatum')) ? get_sub_field('reisdatum') : '');
					$reisgegevens['reisdatum_eind'] = array(__('Terugkomst'), (get_sub_field('reisdatum_eind')) ? get_sub_field('reisdatum_eind') : '');
					$reisgegevens['beschikbare_plaatsen'] = array(__('Beschikbare plaatsen'), (get_sub_field('beschikbare_plaatsen')) ? get_sub_field('beschikbare_plaatsen') : '');
					$reisgegevens['vertrekgarantie'] = array(__('Vertrekgarantie'), (get_sub_field('vertrekgarantie')) ? get_sub_field('vertrekgarantie') : '');
					$reisgegevens['prijs'] = array(__('Prijs'), (get_sub_field('prijs')) ? '&#8364; ' . get_sub_field('prijs') : '');

					if(!empty($reisgegevens)) { // If any values: output table start tag
						$output = '<table class="reisdata-tabel">';
						foreach($reisgegevens as $key => $value) {  // loop through the array
							if($value[1] !== '') { // If the custom field has a value
								$key_formatted = str_replace('_', '-', $key); // Replace underscores with dashes, so the classnames look nice
								$output .= '<tr class="' . $key_formatted . '">';
									$output .= '<td class="reisdata-title" >' . $value[0] . '</td>';
									$output .= '<td class="reisdata-value">' . $value[1] . '</td>';
								$output .= '</tr>';
							}
						}
						$output .= '</table>';
						echo $output;
					}
				}
			}
		}
	}
}

function webbb_register_acf_cf_widget() {

		register_widget( 'ACF_CF_Widget' );

}
add_action( 'widgets_init', 'webbb_register_acf_cf_widget' );
