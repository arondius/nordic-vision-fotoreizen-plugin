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

			if ( ($field->type != 'select' && $field->type != 'checkbox' && $field->type != 'radio') || strpos( $field->cssClass, 'dynamic_travelcode' ) === false ) {
					continue;
			}

			$base = new webbb_fotoreizen_base();
			$travel_tours_array = $base->generate_photo_tours_array();
			$choices = array();

			foreach ( $posts as $key => $post ) {

				if($post['reiscode'] && is_array($post['reiscode'])) {
					foreach ($post['reiscode'] as $reiscode => $reisdatum) {
						$choices[$reiscode] = array(
							'text' => '<span class="col-4">' . $post['post_title'] . '</span><span class="col-4">' . $reisdatum . '</span><span class="col-4">' . $reiscode . '</span>',
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
}

new webbb_fotoreizen_form();