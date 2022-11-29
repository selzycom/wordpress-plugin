<?php

/**
 * Normalizes newline characters.
 *
 * @param string $text Input text.
 * @param string $to Optional. The newline character that is used in the output.
 * @return string Normalized text.
 */
function wpselzy_normalize_newline( $text, $to = "\n" ) {
	if ( ! is_string( $text ) ) {
		return $text;
	}

	$nls = array( "\r\n", "\r", "\n" );

	if ( ! in_array( $to, $nls ) ) {
		return $text;
	}

	return str_replace( $nls, $to, $text );
}


/**
 * Navigates through an array, object, or scalar, and
 * normalizes newline characters in the each value.
 *
 * @param mixed $arr The array or string to be processed.
 * @param string $to Optional. The newline character that is used in the output.
 * @return mixed Processed value.
 */
function wpselzy_normalize_newline_deep( $arr, $to = "\n" ) {
	if ( is_array( $arr ) ) {
		$result = array();

		foreach ( $arr as $key => $text ) {
			$result[$key] = wpselzy_normalize_newline_deep( $text, $to );
		}

		return $result;
	}

	return wpselzy_normalize_newline_deep( $arr, $to );
}

/**
 * Returns an array of allowed HTML tags and attributes for a given context.
 *
 * @param string $context Context used to decide allowed tags and attributes.
 * @return array Array of allowed HTML tags and their allowed attributes.
 */
function wpselzy_kses_allowed_html( $context = 'form' ) {
	static $allowed_tags = array();

	if ( isset( $allowed_tags[$context] ) ) {
		return apply_filters(
			'wpselzy_kses_allowed_html',
			$allowed_tags[$context],
			$context
		);
	}

	$allowed_tags[$context] = wp_kses_allowed_html( 'post' );

	if ( 'form' === $context ) {
		$additional_tags_for_form = array(
			'button' => array(
				'disabled' => true,
				'name' => true,
				'type' => true,
				'value' => true,
			),
			'datalist' => array(),
			'fieldset' => array(
				'disabled' => true,
				'name' => true,
			),
			'input' => array(
				'accept' => true,
				'alt' => true,
				'capture' => true,
				'checked' => true,
				'disabled' => true,
				'list' => true,
				'max' => true,
				'maxlength' => true,
				'min' => true,
				'minlength' => true,
				'multiple' => true,
				'name' => true,
				'placeholder' => true,
				'readonly' => true,
				'size' => true,
				'step' => true,
				'type' => true,
				'value' => true,
			),
			'label' => array(
				'for' => true,
			),
			'legend' => array(),
			'meter' => array(
				'value' => true,
				'min' => true,
				'max' => true,
				'low' => true,
				'high' => true,
				'optimum' => true,
			),
			'optgroup' => array(
				'disabled' => true,
				'label' => true,
			),
			'option' => array(
				'disabled' => true,
				'label' => true,
				'selected' => true,
				'value' => true,
			),
			'output' => array(
				'for' => true,
				'name' => true,
			),
			'progress' => array(
				'max' => true,
				'value' => true,
			),
			'select' => array(
				'disabled' => true,
				'multiple' => true,
				'name' => true,
				'size' => true,
			),
			'textarea' => array(
				'cols' => true,
				'disabled' => true,
				'maxlength' => true,
				'minlength' => true,
				'name' => true,
				'placeholder' => true,
				'readonly' => true,
				'rows' => true,
				'spellcheck' => true,
				'wrap' => true,
			),
		);

		$additional_tags_for_form = array_map(
			function ( $elm ) {
				$global_attributes = array(
					'aria-atomic' => true,
					'aria-checked' => true,
					'aria-describedby' => true,
					'aria-details' => true,
					'aria-disabled' => true,
					'aria-hidden' => true,
					'aria-invalid' => true,
					'aria-label' => true,
					'aria-labelledby' => true,
					'aria-live' => true,
					'aria-relevant' => true,
					'aria-required' => true,
					'aria-selected' => true,
					'class' => true,
					'data-*' => true,
					'id' => true,
					'inputmode' => true,
					'role' => true,
					'style' => true,
					'tabindex' => true,
					'title' => true,
				);

				return array_merge( $global_attributes, (array) $elm );
			},
			$additional_tags_for_form
		);

		$allowed_tags[$context] = array_merge(
			$allowed_tags[$context],
			$additional_tags_for_form
		);
	}

	return apply_filters(
		'wpselzy_kses_allowed_html',
		$allowed_tags[$context],
		$context
	);
}


/**
 * Sanitizes content for allowed HTML tags for the specified context.
 *
 * @param string $input Content to filter.
 * @param string $context Context used to decide allowed tags and attributes.
 * @return string Filtered text with allowed HTML tags and attributes intact.
 */
function wpselzy_kses( $input, $context = 'form' ) {
	$output = wp_kses(
		$input,
		wpselzy_kses_allowed_html( $context )
	);

	return $output;
}
