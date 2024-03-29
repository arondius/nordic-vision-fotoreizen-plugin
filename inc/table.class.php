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
		$reisdatums = $base->generate_photo_tours_array();
		$output = '<p class="display-tablet swipe-info">' . __('Swipe de tabel om alles te zien', 'enfold-child') . '</p>';
		$output .= '<div class="responsive-table-wrapper">';
		$output .= '<table class="fotoreizen-calender">';
		$output .= '<tr>';
		$output .= '<th class="column-reisdatum">Reisdatum</th><th class="column-titel">Reis</th><th class="column-reiscode">Reiscode</th><th class="column-prijs">Prijs</th><th class="column-availability">Beschikbare Plaatsen</th><th class="column-vertrekgarantie">Vertrekgarantie</th>';
		$output .= '</tr>';
		foreach($reisdatums as $reiscode => $reisdatum) {
			$formatted_date_start = date_i18n('d M Y', strtotime($reisdatum['reisdatum_start']));
			$formatted_date_end = date_i18n('d M Y', strtotime($reisdatum['reisdatum_eind']));
			$bln_bookable = $reisdatum['beschikbare_plaatsen'] > 0;
			$bookings_link = site_url('boek-een-fotoreis') . '/?reiscode=' . $reiscode;
			$booking_availability_class = 'plaatsen_high';
			if($reisdatum['beschikbare_plaatsen'] < 6 && $reisdatum['beschikbare_plaatsen'] > 3) {
				$booking_availability_class = 'plaatsen_medium';
			} else if ($reisdatum['beschikbare_plaatsen'] <= 3) {
				$booking_availability_class = 'plaatsen_low';
			}

			$bookings_open_tag = $bln_bookable ? '<a class="btn btn-small btn-cta ' . $booking_availability_class . '" href="' . $bookings_link . '">' : '<span class="btn btn-small btn-inactive">';
			$boekings_num_plaatsen = '<span class="num-plaatsen">' . ($bln_bookable ? $reisdatum['beschikbare_plaatsen'] : '0')	 . ' </span>';
			$boekings_cta_text = '<span class="numplaatsen-text">' . ($bln_bookable ? 'Boek deze reis' : 'Volgeboekt') . '</span>';
			$bookings_close_tag = $bln_bookable ? '</a>' : '</span>';
			$booking_html = $bookings_open_tag . $boekings_num_plaatsen . $boekings_cta_text . $bookings_close_tag;

			$output .= '<tr>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '" class="column-reisdatum">' . $formatted_date_start  . ' t/m ' . $formatted_date_end  . '</td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '" class="column-titel"><a href="'. $reisdatum['permalink']. '">' . $reisdatum['title'] . '</a></td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '" class="column-reiscode">' . $reiscode . '</td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '" class="column-prijs">' . $reisdatum['prijs'] . '</td>';
			$output .= '<td data-href="' . $bookings_link . '" class="column-availability">' . $booking_html . '</td>';
			$output .= '<td data-href="' . $reisdatum['permalink'] . '" class="column-vertrekgarantie">' . $reisdatum['vertrekgarantie'] . '</td>';
			$output .= '</tr>';
		}
		$output .= '</table>';
		$output .= '</div>';
		return $output;
	}	
}

new webbb_fotoreizen_table();
