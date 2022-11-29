<?php

function wpselzy_is_valid_locale( $locale ) {
	$pattern = '/^[a-z]{2,3}(?:_[a-zA-Z_]{2,})?$/';
	return (bool) preg_match( $pattern, $locale );
}

function wpselzy_is_rtl( $locale = '' ) {
	static $rtl_locales = array(
		'ar' => 'Arabic',
		'ary' => 'Moroccan Arabic',
		'azb' => 'South Azerbaijani',
		'fa_IR' => 'Persian',
		'haz' => 'Hazaragi',
		'he_IL' => 'Hebrew',
		'ps' => 'Pashto',
		'ug_CN' => 'Uighur',
	);

	if ( empty( $locale )
	and function_exists( 'is_rtl' ) ) {
		return is_rtl();
	}

	if ( empty( $locale ) ) {
		$locale = determine_locale();
	}

	return isset( $rtl_locales[$locale] );
}

function wpselzy_load_textdomain( $locale = '' ) {
	static $locales = array();

	if ( empty( $locales ) ) {
		$locales = array( determine_locale() );
	}

	$available_locales = array_merge(
		array( 'en_US' ),
		get_available_languages()
	);

	if ( ! in_array( $locale, $available_locales ) ) {
		$locale = $locales[0];
	}

	if ( $locale === end( $locales ) ) {
		return false;
	} else {
		$locales[] = $locale;
	}

	$domain = WPSELZY_TEXT_DOMAIN;

	if ( is_textdomain_loaded( $domain ) ) {
		unload_textdomain( $domain );
	}

	$mofile = sprintf( '%s-%s.mo', $domain, $locale );

	$domain_path = path_join( WPSELZY_PLUGIN_DIR, 'languages' );
	$loaded = load_textdomain( $domain, path_join( $domain_path, $mofile ) );

	if ( ! $loaded ) {
		$domain_path = path_join( WP_LANG_DIR, 'plugins' );
		load_textdomain( $domain, path_join( $domain_path, $mofile ) );
	}

	return true;
}
