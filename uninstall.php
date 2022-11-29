<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

function wpselzy_delete_plugin() {
	global $wpdb;

	delete_option( 'wpselzy' );

	$posts = get_posts(
		array(
			'numberposts' => -1,
			'post_type' => 'wpselzy_form',
			'post_status' => 'any',
		)
	);

	foreach ( $posts as $post ) {
		wp_delete_post( $post->ID, true );
	}

	$wpdb->query( sprintf(
		"DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'selzy'
	) );
}

if ( ! defined( 'WPSELZY_VERSION' ) ) {
	wpselzy_delete_plugin();
}
