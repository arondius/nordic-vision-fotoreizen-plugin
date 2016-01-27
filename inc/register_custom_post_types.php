<?php

add_action('init', 'fotoreis_register');
add_action('init', 'fotoworkshop_register');

if(!function_exists('fotoreis_register')) {
	function fotoreis_register() {
		global $avia_config;

		$labels = array(
			'name' => _x('Fotoreizen', 'post type general name','avia_framework'),
			'singular_name' => _x('Fotoreis', 'post type singular name','avia_framework'),
			'add_new' => _x('Add New', 'fotoreis','avia_framework'),
			'add_new_item' => __('Add New Fotoreis','avia_framework'),
			'edit_item' => __('Edit Fotoreis','avia_framework'),
			'new_item' => __('New Fotoreis','avia_framework'),
			'view_item' => __('View Fotoreis','avia_framework'),
			'search_items' => __('Search Fotoreizen','avia_framework'),
			'not_found' =>  __('No Fotoreizen found','avia_framework'),
			'not_found_in_trash' => __('No Fotoreizen found in Trash','avia_framework'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'page',
			'hierarchical' => true,
			'rewrite' => array('slug'=> 'fotoreizen', 'with_front'=>true), //TODO make this multilangual
			'query_var' => true,
			'show_in_nav_menus'=> true,
			'taxonomies' => array('post_tag'),
			'supports' => array('title','thumbnail','excerpt','editor', 'page-attributes')
		);

		$args = apply_filters('avf_fotoreis_cpt_args', $args);
		$avia_config['custom_post']['fotoreizen']['args'] = $args;

		register_post_type( 'fotoreizen' , $args );


		$tax_args = array(
			"hierarchical" => true,
			"label" => "Bestemmingen",
			"singular_label" => "Bestemming",
			"rewrite" => array('slug'=> 'bestemming', 'with_front'=>true), //TODO make this multilangual
			"query_var" => true
		);

	 	$avia_config['custom_taxonomy']['fotoreizen']['bestemmingen']['args'] = $tax_args;

		register_taxonomy("bestemmingen", array("fotoreizen"), $tax_args);

		//deactivate the avia_flush_rewrites() function - not required because we rely on the default wordpress permalink settings
		remove_action('wp_loaded', 'avia_flush_rewrites');
	}
}

if(!function_exists('fotoworkshop_register')) {
	function fotoworkshop_register() {
		global $avia_config;

		$labels = array(
			'name' => _x('Fotoworkshops', 'post type general name','avia_framework'),
			'singular_name' => _x('Fotoworkshop', 'post type singular name','avia_framework'),
			'add_new' => _x('Add New', 'Fotoworkshop','avia_framework'),
			'add_new_item' => __('Add New Fotoworkshop','avia_framework'),
			'edit_item' => __('Edit Fotoworkshop','avia_framework'),
			'new_item' => __('New Fotoworkshop','avia_framework'),
			'view_item' => __('View Fotoworkshop','avia_framework'),
			'search_items' => __('Search Fotoworkshops','avia_framework'),
			'not_found' =>  __('No Fotoworkshops found','avia_framework'),
			'not_found_in_trash' => __('No Fotoworkshops found in Trash','avia_framework'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'page',
			'hierarchical' => false,
			'rewrite' => array('slug'=> 'fotoworkshops', 'with_front'=>true), //TODO make this multilangual
			'query_var' => true,
			'show_in_nav_menus'=> true,
			'taxonomies' => array('post_tag'),
			'supports' => array('title','thumbnail','excerpt','editor')
		);

		$args = apply_filters('avf_fotoworkshop_cpt_args', $args);
		$avia_config['custom_post']['fotoworkshops']['args'] = $args;

		register_post_type( 'fotoworkshops' , $args );


		$tax_args = array(
			"hierarchical" => true,
			"label" => "Landen",
			"singular_label" => "Land",
			"rewrite" => array('slug'=> 'land', 'with_front'=>true), //TODO make this multilangual
			"query_var" => true
		);

	 	$avia_config['custom_taxonomy']['fotoworkshops']['landen']['args'] = $tax_args;
	 	//var_dump($avia_config['custom_taxonomy']); exit;
		register_taxonomy("landen", array("fotoworkshops"), $tax_args);

		//deactivate the avia_flush_rewrites() function - not required because we rely on the default wordpress permalink settings
		remove_action('wp_loaded', 'avia_flush_rewrites');
	}
}