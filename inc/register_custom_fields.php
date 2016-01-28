<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_56421ab1de0c7',
	'title' => 'Fotoreis en fotoworkshop reiscode',
	'fields' => array (
		array (
			'key' => 'field_563a467af39e6',
			'label' => 'Reisgegevens',
			'name' => 'reiscode_datum',
			'type' => 'repeater',
			'instructions' => 'De gegevens in dit veld worden in het boekingsformulier, de kalender en de zijbalk van de fotoreizen gebruikt.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Nieuwe Reis',
			'sub_fields' => array (
				array (
					'key' => 'field_56421baee87d8',
					'label' => 'Reisdatum Start',
					'name' => 'reisdatum',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 50,
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array (
					'key' => 'field_56489c3b7f516',
					'label' => 'Reisdatum Eind',
					'name' => 'reisdatum_eind',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 50,
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array (
					'key' => 'field_56421b89e87d7',
					'label' => 'Reiscode',
					'name' => 'reiscode',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 25,
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56925d3763eb7',
					'label' => 'Prijs',
					'name' => 'prijs',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 25,
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56925d7a63eb8',
					'label' => 'Beschikbare plaatsen',
					'name' => 'beschikbare_plaatsen',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 25,
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56925d9a63eb9',
					'label' => 'Vertrekgarantie',
					'name' => 'vertrekgarantie',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => 25,
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'Ja' => 'Ja',
						'Nee' => 'Nee',
					),
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'fotoreizen',
			),
			array (
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'child',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'fotoworkshops',
			),
			array (
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'child',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;