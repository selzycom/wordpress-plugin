<?php

/**
 * Returns the URL to a plugin file.
 *
 * @param string $path File path relative to the plugin root directory.
 *
 * @return string URL.
 */
function wpselzy_plugin_url( $path = '' ) {
	$url = plugins_url( $path, WPSELZY_PLUGIN );

	if ( is_ssl()
	     and 'http:' == substr( $url, 0, 5 ) ) {
		$url = 'https:' . substr( $url, 5 );
	}

	return $url;
}


/**
 * Verifies that a correct security nonce was used with time limit.
 *
 * @param string $nonce Nonce value that was used for verification.
 * @param string $action Optional. Context to what is taking place.
 *                       Default 'wp_rest'.
 *
 * @return int|bool 1 if the nonce is generated between 0-12 hours ago,
 *                  2 if the nonce is generated between 12-24 hours ago.
 *                  False if the nonce is invalid.
 */
function wpselzy_verify_nonce( $nonce, $action = 'wp_rest' ) {
	return wp_verify_nonce( $nonce, $action );
}

/**
 * Creates a cryptographic token tied to a specific action, user, user session,
 * and window of time.
 *
 * @param string $action Optional. Context to what is taking place.
 *                       Default 'wp_rest'.
 *
 * @return string The token.
 */
function wpselzy_create_nonce( $action = 'wp_rest' ) {
	return wp_create_nonce( $action );
}


/**
 * Converts multi-dimensional array to a flat array.
 *
 * @param mixed $input Array or item of array.
 *
 * @return array Flatten array.
 */
function wpselzy_array_flatten( $input ) {
	if ( ! is_array( $input ) ) {
		return array( $input );
	}

	$output = array();

	foreach ( $input as $value ) {
		$output = array_merge( $output, wpselzy_array_flatten( $value ) );
	}

	return $output;
}

/**
 * Returns a formatted string of HTML attributes.
 *
 * @param array $atts Associative array of attribute name and value pairs.
 *
 * @return string Formatted HTML attributes.
 */
function wpselzy_format_atts( $atts ) {
	$html = '';

	$prioritized_atts = array( 'type', 'name', 'value' );

	foreach ( $prioritized_atts as $att ) {
		if ( isset( $atts[ $att ] ) ) {
			$value = trim( $atts[ $att ] );
			$html  .= sprintf( ' %s="%s"', $att, esc_attr( $value ) );
			unset( $atts[ $att ] );
		}
	}

	foreach ( $atts as $key => $value ) {
		$key = strtolower( trim( $key ) );

		if ( ! preg_match( '/^[a-z_:][a-z_:.0-9-]*$/', $key ) ) {
			continue;
		}

		$value = trim( $value );

		if ( '' !== $value ) {
			$html .= sprintf( ' %s="%s"', $key, esc_attr( $value ) );
		}
	}

	$html = trim( $html );

	return $html;
}


/**
 * Builds an HTML anchor element.
 *
 * @param string $url Link URL.
 * @param string $anchor_text Anchor label text.
 * @param string|array $args Optional. Link options.
 *
 * @return string Formatted anchor element.
 */
function wpselzy_link( $url, $anchor_text, $args = '' ) {
	$defaults = array(
		'id'    => '',
		'class' => '',
	);

	$args = wp_parse_args( $args, $defaults );
	$args = array_intersect_key( $args, $defaults );
	$atts = wpselzy_format_atts( $args );

	$link = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
		esc_url( $url ),
		esc_html( $anchor_text ),
		$atts ? ( ' ' . $atts ) : ''
	);

	return $link;
}


/**
 * Returns the current request URL.
 */
function wpselzy_get_request_uri() {
	static $request_uri = '';

	if ( empty( $request_uri ) ) {
		$request_uri = add_query_arg( array() );
	}

	return esc_url_raw( $request_uri );
}


/**
 * Registers post types used for this plugin.
 */
function wpselzy_register_post_types() {
	if ( class_exists( 'WPSELZY_Form' ) ) {
		WPSELZY_Form::register_post_type();

		return true;
	} else {
		return false;
	}
}

/**
 * Builds a URL-encoded query string.
 *
 * @see https://developer.wordpress.org/reference/functions/_http_build_query/
 *
 * @param array $args URL query parameters.
 * @param string $key Optional. If specified, used to prefix key name.
 *
 * @return string Query string.
 */
function wpselzy_build_query( $args, $key = '' ) {
	$sep = '&';
	$ret = array();

	foreach ( (array) $args as $k => $v ) {
		$k = urlencode( $k );

		if ( ! empty( $key ) ) {
			$k = $key . '%5B' . $k . '%5D';
		}

		if ( null === $v ) {
			continue;
		} elseif ( false === $v ) {
			$v = '0';
		}

		if ( is_array( $v ) or is_object( $v ) ) {
			array_push( $ret, wpselzy_build_query( $v, $k ) );
		} else {
			array_push( $ret, $k . '=' . urlencode( $v ) );
		}
	}

	return implode( $sep, $ret );
}


/**
 * Returns the number of code units in a string.
 *
 * @see http://www.w3.org/TR/html5/infrastructure.html#code-unit-length
 *
 * @param string $string Input string.
 *
 * @return int|bool The number of code units, or false if
 *                  mb_convert_encoding is not available.
 */
function wpselzy_count_code_units( $string ) {
	static $use_mb = null;

	if ( is_null( $use_mb ) ) {
		$use_mb = function_exists( 'mb_convert_encoding' );
	}

	if ( ! $use_mb ) {
		return false;
	}

	$string = (string) $string;
	$string = str_replace( "\r\n", "\n", $string );

	$encoding = mb_detect_encoding( $string, mb_detect_order(), true );

	if ( $encoding ) {
		$string = mb_convert_encoding( $string, 'UTF-16', $encoding );
	} else {
		$string = mb_convert_encoding( $string, 'UTF-16', 'UTF-8' );
	}

	$byte_count = mb_strlen( $string, '8bit' );

	return floor( $byte_count / 2 );
}


/**
 * Returns true if WordPress is running on the localhost.
 */
function wpselzy_is_localhost() {
	$server_name = strtolower( $_SERVER['SERVER_NAME'] );

	return in_array( $server_name, array( 'localhost', '127.0.0.1' ) );
}

/**
 * Triggers an error about a remote HTTP request and response.
 *
 * @param string $url The resource URL.
 * @param array $request Request arguments.
 * @param array|WP_Error $response The response or WP_Error on failure.
 */
function wpselzy_log_remote_request( $url, $request, $response ) {
	$log = sprintf(
	/* translators: 1: response code, 2: message, 3: body, 4: URL */
		__( 'HTTP Response: %1$s %2$s %3$s from %4$s', 'unisender' ),
		(int) wp_remote_retrieve_response_code( $response ),
		wp_remote_retrieve_response_message( $response ),
		wp_remote_retrieve_body( $response ),
		$url
	);

	$log = apply_filters( 'wpselzy_log_remote_request',
		$log, $url, $request, $response
	);

	if ( $log ) {
		trigger_error( $log );
	}
}


/**
 * Anonymizes an IP address by masking local part.
 *
 * @param string $ip_addr The original IP address.
 *
 * @return string|bool Anonymized IP address, or false on failure.
 */
function wpselzy_anonymize_ip_addr( $ip_addr ) {
	if ( ! function_exists( 'inet_ntop' )
	     or ! function_exists( 'inet_pton' ) ) {
		return $ip_addr;
	}

	$packed = inet_pton( $ip_addr );

	if ( false === $packed ) {
		return $ip_addr;
	}

	if ( 4 == strlen( $packed ) ) { // IPv4
		$mask = '255.255.255.0';
	} elseif ( 16 == strlen( $packed ) ) { // IPv6
		$mask = 'ffff:ffff:ffff:0000:0000:0000:0000:0000';
	} else {
		return $ip_addr;
	}

	return inet_ntop( $packed & inet_pton( $mask ) );
}
