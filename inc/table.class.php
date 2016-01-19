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
			foreach ($bestemming['reis'] as $reiscode => $date) {
				//echo $date['data']['reisdatum_start'][1] . '</br>';
				if(!empty($date['data']['reisdatum_start'][1])) { // If one of the values isn't filled in continue
					foreach($date['data'] as $key => $date_entry) {
						$reisdatums[$reiscode]['permalink'] = post_permalink($fotoreis_id);
						$reisdatums[$reiscode]['title'] = $bestemming['title'];
						$reisdatums[$reiscode][$key] = $date_entry[1];
					}
					//echo $date[$key]['data'] . ' wel ingevuld </br>';
				}	else {
					//echo $date[$key]['data'] . ' niet ingevuld </br>';
				}
			}
		}

		uasort($reisdatums, array($this, 'cmp'));
		return $reisdatums;
	}

	public function generate_table() {
		$reisdatums = $this->generate_array();
		$output .= '<table class="fotoreizen-calender">';
		$output .= '<tr>';
		$output .= '<th>Reisdatum</th><th>Reis</th><th>Reiscode</th><th>Prijs</th><th>Beschibare Plaatsen</th><th>Vertrekgarantie</th>';
		$output .= '</tr>';
		foreach($reisdatums as $reiscode => $reisdatum) {
			$formatted_date_start = date_i18n('d M Y', strtotime($reisdatum['reisdatum_start']));
			$formatted_date_end = date_i18n('d M Y', strtotime($reisdatum['reisdatum_eind']));
			$bln_bookable = $reisdatum['beschikbare_plaatsen'] > 0;
			$bookings_link = site_url('boek-een-fotoreis') . '?=' . $reiscode;
			$bookings_open_tag = $bln_bookable ? '<a class="btn btn-small btn-cta" href="' . $bookings_link . '">' : '<span class="btn btn-small btn-inactive">';
			$boekings_num_plaatsen = $bln_bookable ? '<span class="num-plaatsen">' . $reisdatum['beschikbare_plaatsen'] .  ' </span>' : '';
			$boekings_cta_text = '<span class="numplaatsen-text">' . ($bln_bookable ? ' - Boek deze reis' : 'Volgeboekt') . '</span>';
			$bookings_close_tag = $bln_bookable ? '</a>' : '</span>';
			$booking_html = $bookings_open_tag . $boekings_num_plaatsen . $boekings_cta_text . $bookings_close_tag;

			$output .= '<tr>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '">' . $formatted_date_start  . ' t/m ' . $formatted_date_end  . '</td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '"><a href="'. $reisdatum['permalink']. '">' . $reisdatum['title'] . '</a></td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '">' . $reiscode . '</td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '">' . $reisdatum['prijs'] . '</td>';
			$output .= '<td data-href="' . $bookings_link . '">' . $booking_html . '</td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '">' . $reisdatum['vertrekgarantie'] . '</td>';
			$output .= '</tr>';
		}
		$output .= '</table>';
		return $output;
	}

	public function cmp($a, $b) {
		$formatted_time_a = strtotime(str_replace('/', '-', $a['reisdatum_start']));
		$formatted_time_b = strtotime(str_replace('/', '-', $b['reisdatum_start']));

		if ($formatted_time_a < $formatted_time_b) {
//				echo $a['reisdatum_start'] . '</br>';
//				echo 'UNIX time is ' . $formatted_time_a . ' </br>';
//				echo '-1 fotoreis ' . $a['title'] . ' van ' . $a['reisdatum_start'] . ' - ' . $formatted_time_a . ' is eerder dan ' . 'fotoreis ' . $b['title'] . ' van ' . $b['reisdatum_start'] . ' - ' . $formatted_time_b . '</br>' . PHP_EOL;
			return -1;
		}
		else if ($formatted_time_a === $formatted_time_b) {
//				echo $a['reisdatum_start'] . '</br>';
//				echo 'UNIX time is ' . $formatted_time_a . ' </br>';
//				echo '-1 fotoreis ' . $a['title'] . ' van ' . $a['reisdatum_start'] . ' - ' . $formatted_time_a . ' is gelijk aan ' . 'fotoreis ' . $b['title'] . ' van ' . $b['reisdatum_start'] . ' - ' . $formatted_time_b . '</br>' . PHP_EOL;
			return 0;
		}
		else {
//				echo $a['reisdatum_start'] . '</br>';
//				echo 'UNIX time is ' . $formatted_time_a . ' </br>';
//				echo '-1 fotoreis ' . $a['title'] . ' van ' . $a['reisdatum_start'] . ' - ' . $formatted_time_a . ' is later dan ' . 'fotoreis ' . $b['title'] . ' van ' . $b['reisdatum_start'] . ' - ' . $formatted_time_b . '</br>' . PHP_EOL;
			return 1;
		}
	}
}

new webbb_fotoreizen_table();
