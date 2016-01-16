<?php
require_once('base.class.php');

class webbb_fotoreizen_form {

	public function __construct() {
		// Hook into gravity Forms
		add_filter( 'gform_pre_render', array($this, 'fotoreizen_populate_form') );
		add_filter( 'gform_pre_validation', array($this, 'fotoreizen_populate_form') );
		add_filter( 'gform_pre_submission_filter', array($this, 'fotoreizen_populate_form') );
		add_filter( 'gform_admin_pre_render', array($this, 'fotoreizen_populate_form') );
	}

	public function fotoreizen_populate_form( $form ) {

		foreach ( $form['fields'] as &$field ) {

			if ( $field->type != 'select' || strpos( $field->cssClass, 'dynamic_travelcode' ) === false ) {
					continue;
			}

		$posts = $this->populate_posts();
		$choices = array();

			foreach ( $posts as $key => $post ) {

				if($post['reiscode'] && is_array($post['reiscode'])) {
					foreach ($post['reiscode'] as $reiscode => $reisdatum) {
						$choices[$reiscode] = array(
							'text' => $post['post_title'] . ' - ' . $reisdatum . ' - ' . $reiscode ,
							'value' => $reiscode
						);
					}
				}
			}

			// update 'Select a Post' to whatever you'd like the instructive option to be
			$field->placeholder = 'Select een fotoreis';
			$field->choices = $choices;
		}

		return $form;
}
	public function populate_posts() {

		$base = new webbb_fotoreizen_base();
		$posts_array = $base->get_fotoreizen();

		foreach ($posts_array as $key => $single_post) {

			$reiscode_reisdatum = array();

			if(class_exists('acf'))
				if(have_rows('reiscode_datum', $single_post->ID)) {
					while(have_rows('reiscode_datum', $single_post->ID)) {
						the_row();
						if (get_sub_field('reiscode') && get_sub_field('reisdatum') && get_sub_field('reisdatum_eind') && $base->is_bookable()) {
							$reiscode = get_sub_field('reiscode');
							$reisdatum_start = get_sub_field('reisdatum');
							$reisdatum_eind = get_sub_field('reisdatum_eind');

							$reiscode_reisdatum[$reiscode] = $reisdatum_start . ' - ' . $reisdatum_eind;
						}
						else {
							$reiscode_reisdatum[] = '';
						}
					}
				}
				else {
					$reiscode_reisdatum = '';
				}

			$posts[$single_post->ID]['reiscode'] = $reiscode_reisdatum;
			$posts[$single_post->ID]['post_title'] = $single_post->post_title;
		}
		return $posts;
	}
}

new webbb_fotoreizen_form();