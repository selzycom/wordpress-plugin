<?php

function wpselzy_form( $id ) {
	return WPSELZY_Form::get_instance( $id );
}

function wpselzy_get_form_by_title( $title ) {
	$page = get_page_by_title( $title, OBJECT, WPSELZY_Form::post_type );

	if ( $page ) {
		return wpselzy_form( $page->ID );
	}

	return null;
}

function wpselzy_get_current_form() {
	if ( $current = WPSELZY_Form::get_current() ) {
		return $current;
	}

	return null;
}

function wpselzy_form_tag_func( $atts ) {
	if ( is_feed() ) {
		return '[selzy-form]';
	}

	$atts = shortcode_atts(
		array(
			'id'    => 0,
			'title' => '',
		),
		$atts, 'selzy'
	);

	$id    = (int) $atts['id'];
	$title = trim( $atts['title'] );

	if ( ! $form = wpselzy_form( $id ) ) {
		$form = wpselzy_get_form_by_title( $title );
	}

	if ( ! $form ) {
		return sprintf(
			'[selzy-form 404 "%s"]',
			esc_html( __( 'Не найдено', 'selzy' ) )
		);
	}

	return $form->form_html( $atts );
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'unisender_form_css', WPSELZY_PLUGIN_URL . '/assets/css/unisender.css', [], '1.0.0', 'all' );
	wp_enqueue_script( 'unisender_form_js', WPSELZY_PLUGIN_URL . '/assets/js/unisender.js', [], '1.0.0', 'all' );
	wp_localize_script( 'unisender_form_js', 'UNISENDER_AJAX',
		array(
			'url' => admin_url( 'admin-ajax.php' )
		)
	);
} );

function wpselzy_save_form( $args = '', $context = 'save' ) {
	$args = wp_parse_args( $args, array(
		'id'           => - 1,
		'title'        => null,
		'locale'       => null,
		'form'         => null,
		'contact_list' => null,
	) );

	$args = wp_unslash( $args );

	$args['id'] = (int) $args['id'];

	if ( - 1 == $args['id'] ) {
		$form = WPSELZY_Form::get_template();
	} else {
		$form = wpselzy_form( $args['id'] );
	}

	if ( empty( $form ) ) {
		return false;
	}

	if ( null !== $args['title'] ) {
		$form->set_title( $args['title'] );
	}

	if ( null !== $args['locale'] ) {
		$form->set_locale( $args['locale'] );
	}

	$properties = array();

	if ( null !== $args['form'] ) {
		$properties['form'] = wpselzy_sanitize_form( $args['form'] );
	}

	if ( null !== $args['contact_list'] ) {
		$properties['contact_list'] = sanitize_text_field( $args['contact_list'] );
	}

	$form->set_properties( $properties );

	do_action( 'wpselzy_save_form', $form, $args, $context );

	if ( 'save' == $context ) {
		$form->save();
	}

	return $form;
}

function wpselzy_sanitize_form( $input, $default = '' ) {
	if ( null === $input ) {
		return $default;
	}

	$output = trim( $input );

	if ( ! current_user_can( 'unfiltered_html' ) ) {
		$output = wpselzy_kses( $output, 'form' );
	}

	return $output;
}

