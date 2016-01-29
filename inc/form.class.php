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

			foreach ( $travel_tours_array as $reiscode => $data ) {

				if($data['bookable']) {
					$formatted_date_start = date_i18n('d M Y', strtotime($data['reisdatum_start']));
					$formatted_date_end = date_i18n('d M Y', strtotime($data['reisdatum_eind']));
					$reisdatum = $formatted_date_start . ' - ' . $formatted_date_end;
					$title = $data['title'];
					$prijs = $data['prijs'];
					$text = ($field->type == 'checkbox' || $field->type == 'radio') ? '<span class="dynamic_travelcode--radio-title"><strong>' . $title  . '</strong></span><span class="dynamic_travelcode--radio-date">' . $reisdatum . '</span><span class="dynamic_travelcode--radio-price"><span class="webbb-label">' . $prijs . '</span></span><span class="dynamic_travelcode--radio-travel-code"><strong>' . $reiscode . '</strong></span>' : $title  . ' - ' . $reisdatum . ' - ' . $reiscode;

					$choices[$reiscode] = array(
						'text' => $text,
						'value' => $reiscode
					);

				}
			}

			// update 'Select a Post' to whatever you'd like the instructive option to be
			$field->placeholder = 'Selecteer een fotoreis';
			$field->choices = $choices;
		}

		return $form;
	}
}

new webbb_fotoreizen_form();