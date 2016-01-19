<?php

require_once('base.class.php');

class webbb_fotoreizen_table {

	public function __construct() {
		$this->register_shortcode();
	}

	public function register_shortcode() {
		add_shortcode('fotoreizen_tabel', array($this, 'generate_table') );
	}

	private function generate_array() {
		$base = new webbb_fotoreizen_base();
		$fotoreizen = $base->populate_fotoreizen_array();
		$reisdatums = array();
		foreach($fotoreizen as $fotoreis_id => $bestemming) {
			foreach ($bestemming['reis'] as $date) {
				foreach($date as $key => $date_entry) {
					$reisdatum[$reiscode] = $date_entry[$key];
				}
			}
		}
		return $reisdatums;
	}

	public function generate_table() {
		

		$output .= '<table>';
		$output .= '<tr>';
		$output .= '<th>Reisdatum</th><th>Reis</th><th>Reiscode</th><th>Prijs</th><th>Beschibare Plaatsen</th><th>Vertrekgarantie</th>';
		$output .= '</tr>';
		foreach($reisdatums as $reisdatum) {
			$output .= '<tr>';
			$output .= '<td>' . $reisdatum['reisdatum_start'][1] . ' t/m ' . $reisdatum['reisdatum_eind'][1] . '</td>';
			$output .= '<td><a href="' . post_permalink($fotoreis_id) . '">' . $bestemming['title'] . '</a></td>';
			$output .= '<td>' . $reisdatum['reiscode'][1] . '</td>';
			$output .= '<td>' . $reisdatum['prijs'][1] . '</td>';
			$output .= '<td>' . $reisdatum['beschikbare_plaatsen'][1] . '</td>';
			$output .= '<td>' . $reisdatum['vertrekgarantie'][1] . '</td>';
			$output .= '</tr>';
		}
		$output .= '</table>';
		return $output;
	}
}

new webbb_fotoreizen_table();
