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

		if(have_rows('reiscode_datum', $post_id)) { // Repeater Fields for reisdata
			$reisgegevens = array();
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
				$reisgegevens[$reiscode]['data']['reisdatum_start'] = array(__('Vertrek'), (get_sub_field('reisdatum')) ? get_sub_field('reisdatum') : '');
				$reisgegevens[$reiscode]['data']['reisdatum_eind'] = array(__('Terugkomst'), (get_sub_field('reisdatum_eind')) ? get_sub_field('reisdatum_eind') : '');
				$reisgegevens[$reiscode]['data']['beschikbare_plaatsen'] = array(__('Beschikbare plaatsen'), ($this->get_bookable()) ? ((int)get_sub_field('beschikbare_plaatsen')) : __('Volgeboekt'));
				$reisgegevens[$reiscode]['data']['vertrekgarantie'] = array(__('Vertrekgarantie'), (get_sub_field('vertrekgarantie')) ? get_sub_field('vertrekgarantie') : '');
				$reisgegevens[$reiscode]['data']['prijs'] = array(__('Prijs'), (get_sub_field('prijs')) ? '&#8364; ' . get_sub_field('prijs') : '');
			}
		}
		return $reisgegevens;
	}

	public function get_fotoreizen() {
		$posts = array();
		$args = array('post_type' => 'fotoreizen', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC');
		return get_posts($args);
	}

	public function populate_fotoreizen_array() {
		$fotoreizen = $this->get_fotoreizen();
		$fotoreizen_data = array();
		foreach ($fotoreizen as $fotoreis) {
			$fotoreizen_data[$fotoreis->ID]['title'] = $fotoreis->post_title;
			$fotoreizen_data[$fotoreis->ID]['reis'] = $this->get_travel_fields($fotoreis->ID);
		}
		return $fotoreizen_data;
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