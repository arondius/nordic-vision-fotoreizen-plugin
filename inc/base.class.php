<?php

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class webbb_fotoreizen_base {

	public function get_travel_fields() {

		if(class_exists('acf')) { // We depend on the Advanced Custom Fields plugin, so check that it is active

			global $post;

			if(have_rows('reiscode_datum')) { // Repeater Fields for reisdata
				while(have_rows('reiscode_datum')) {
					the_row();

					$reisgegevens['widget_output']['reiscode'] = array(__('Reiscode'), (get_sub_field('reiscode')) ? get_sub_field('reiscode') : '');
					$reisgegevens['widget_output']['reisdatum_start'] = array(__('Vertrek'), (get_sub_field('reisdatum')) ? get_sub_field('reisdatum') : '');
					$reisgegevens['widget_output']['reisdatum_eind'] = array(__('Terugkomst'), (get_sub_field('reisdatum_eind')) ? get_sub_field('reisdatum_eind') : '');
					$reisgegevens['widget_output']['beschikbare_plaatsen'] = array(__('Beschikbare plaatsen'), ($this->is_bookable()) ? ((int)get_sub_field('beschikbare_plaatsen')) : __('Volgeboekt'));
					$reisgegevens['widget_output']['vertrekgarantie'] = array(__('Vertrekgarantie'), (get_sub_field('vertrekgarantie')) ? get_sub_field('vertrekgarantie') : '');
					$reisgegevens['widget_output']['prijs'] = array(__('Prijs'), (get_sub_field('prijs')) ? '&#8364; ' . get_sub_field('prijs') : '');

					$reisgegevens['table_output']['reisnaam'] = array(__('Reisnaam'), $post->post_title);
					$reisgegevens['table_output']['reiscode'] = array(__('Reiscode'), (get_sub_field('reiscode')) ? get_sub_field('reiscode') : '');
					$reisgegevens['table_output']['reisdatum_start'] = array(__('Vertrek'), (get_sub_field('reisdatum')) ? get_sub_field('reisdatum') : '');
					$reisgegevens['table_output']['reisdatum_eind'] = array(__('Terugkomst'), (get_sub_field('reisdatum_eind')) ? get_sub_field('reisdatum_eind') : '');
					$reisgegevens['table_output']['beschikbare_plaatsen'] = array(__('Beschikbare plaatsen'), ($this->is_bookable()) ? ((int)get_sub_field('beschikbare_plaatsen')) : __('Volgeboekt'));
					$reisgegevens['table_output']['vertrekgarantie'] = array(__('Vertrekgarantie'), (get_sub_field('vertrekgarantie')) ? get_sub_field('vertrekgarantie') : '');
					$reisgegevens['table_output']['prijs'] = array(__('Prijs'), (get_sub_field('prijs')) ? '&#8364; ' . get_sub_field('prijs') : '');
				}
			}
			return $reisgegevens;
		}
	}

	public function get_fotoreizen() {
		$posts = array();
		$args = array('post_type' => 'fotoreizen', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC');
		return get_posts($args);
	}

	public function is_bookable() {
		return (get_sub_field('beschikbare_plaatsen') && (int)get_sub_field('beschikbare_plaatsen') > 0) ? true : false;
	}
}