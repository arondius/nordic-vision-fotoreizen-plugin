<?php

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class webbb_fotoreizen_base {

	protected $_is_bookable = true;

	public function get_travel_fields($post_id = null) {

		if(!class_exists('acf')) { // We depend on the Advanced Custom Fields plugin, so check that it is active
			return false;
		}
		if($post_id === null) {
			global $post;
			$post_id = $post->ID;
		}
		$reisgegevens = null;
		if(have_rows('reiscode_datum', $post_id)) { // Repeater Fields for reisdata
			while(have_rows('reiscode_datum', $post_id)) {
				the_row();

				$this->set_bookable($post_id);
				$bookable = $this->get_bookable();
				$reiscode = (get_sub_field('reiscode') ? get_sub_field('reiscode') : '');
				if(!$reiscode) {
					return false;
				}
				// I would love to get all the subfields dynamically, i.e. get all existing subfields and assign their Title and value to an array, but get_sub_field only seems to accept a name as parameter. http://www.advancedcustomfields.com/resources/get_sub_field/
				$reisgegevens[$reiscode]['bookable'] = $bookable;
				$reisgegevens[$reiscode]['data']['reisdatum_start'] = array(__('Vertrek'), (get_sub_field('reisdatum')) ? str_replace('/', '-', get_sub_field('reisdatum')) : '');
				$reisgegevens[$reiscode]['data']['reisdatum_eind'] = array(__('Terugkomst'), (get_sub_field('reisdatum_eind')) ? str_replace('/', '-', get_sub_field('reisdatum_eind')) : '');
				$reisgegevens[$reiscode]['data']['beschikbare_plaatsen'] = array(__('Beschikbare plaatsen'), ($this->get_bookable()) ? ((int)get_sub_field('beschikbare_plaatsen')) : get_sub_field('beschikbare_plaatsen'));
				$reisgegevens[$reiscode]['data']['vertrekgarantie'] = array(__('Vertrekgarantie'), (get_sub_field('vertrekgarantie')) ? get_sub_field('vertrekgarantie') : '');
				$reisgegevens[$reiscode]['data']['prijs'] = array(__('Prijs'), (get_sub_field('prijs')) ? '&#8364; ' . get_sub_field('prijs') : '');
			}
		}
		return $reisgegevens;
	}

	public function get_fotoreizen() {
		$posts = array();
		$args = array('post_type' => 'fotoreizen', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'publish');
		return get_posts($args);
	}

	public function populate_photo_destinations_array() {
		$fotoreizen = $this->get_fotoreizen();
		$fotoreizen_data = array();
		foreach ($fotoreizen as $fotoreis) {
			$fotoreizen_data[$fotoreis->ID]['title'] = $fotoreis->post_title;
			$fotoreizen_data[$fotoreis->ID]['reis'] = $this->get_travel_fields($fotoreis->ID);
		}
		return $fotoreizen_data;
	}

	public function generate_photo_tours_array() {
		$fotoreizen = $this->populate_photo_destinations_array();
		$reisdatums = array();
		foreach($fotoreizen as $fotoreis_id => $bestemming) {
			if($bestemming['reis']) {
				foreach ($bestemming['reis'] as $reiscode => $date) {
					$reisdatums[$reiscode]['permalink'] = get_permalink($fotoreis_id);
					$reisdatums[$reiscode]['title'] = $bestemming['title'];
					$reisdatums[$reiscode]['bookable'] = $date['bookable'];
					if(!empty($date['data']['reisdatum_start'][1])) {
						foreach($date['data'] as $key => $date_entry) {
							$reisdatums[$reiscode][$key] = $date_entry[1];
						}
					}
				}
			}
		}
		uasort($reisdatums, array($this, 'cmp'));
		return $reisdatums;
	}

	public function cmp($a, $b) {
		$formatted_time_a = strtotime(str_replace('/', '-', $a['reisdatum_start']));
		$formatted_time_b = strtotime(str_replace('/', '-', $b['reisdatum_start']));

		if ($formatted_time_a < $formatted_time_b) {
			return -1;
		}
		else if ($formatted_time_a === $formatted_time_b) {
			return 0;
		}
		else {
			return 1;
		}
	}

	private function check_availability($post_id) {
			$bookable = (get_sub_field('beschikbare_plaatsen') && (int)get_sub_field('beschikbare_plaatsen') > 0) ? true : false;
			return $bookable;
	}

	private function set_bookable($post_id) {
		$this->_is_bookable = $this->check_availability($post_id);
	}

	public function get_bookable() {
		return $this->_is_bookable;
	}

}