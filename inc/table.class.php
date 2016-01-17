<?php

require_once('base.class.php');

class webbb_fotoreizen_table {

	public function __construct() {
		$this->register_shortcode();
	}

	public function register_shortcode() {
		add_shortcode('fotoreizen_tabel', array($this, 'generate_table') );
	}

	public function generate_table() {
		$base = new webbb_fotoreizen_base();
		$fotoreizen = $base->populate_fotoreizen_array();

		$output .= '<table>';
		$output .= '<tr>';
		$output .= '<td>Reisdatum</td><td>Reis</td><td>Reiscode</td><td>Prijs</td><td>Beschibare Plaatsen</td><td>Vertrekgarantie</td>';
		$output .= '</tr>';
		foreach($fotoreizen as $date) {
				$output .= '<tr>';
				$output .= '<td>' . $date['reisdatum_start'][1] . ' t/m ' . $date['reisdatum_eind'][1] . '</td>';
				$output .= '<td><a href="' . post_permalink($fotoreis->ID) . '">' . $fotoreis->post_title . '</a></td>';
				$output .= '<td>' . $date['reiscode'][1] . '</td>';
				$output .= '<td>' . $date['prijs'][1] . '</td>';
				$output .= '<td>' . $date['beschikbare_plaatsen'][1] . '</td>';
				$output .= '<td>' . $date['vertrekgarantie'][1] . '</td>';
				$output .= '</tr>';
			}
		$output .= '</table>';
		return $output;
	}
}

new webbb_fotoreizen_table();
