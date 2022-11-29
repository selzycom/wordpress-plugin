<?php

add_filter( 'map_meta_cap', 'wpselzy_map_meta_cap', 10, 4 );

function wpselzy_map_meta_cap( $caps, $cap, $user_id, $args ) {
	$meta_caps = [
		'wpselzy_edit_form'      => WPSELZY_ADMIN_READ_WRITE_CAPABILITY,
		'wpselzy_edit_forms'     => WPSELZY_ADMIN_READ_WRITE_CAPABILITY,
		'wpselzy_read_form'      => WPSELZY_ADMIN_READ_CAPABILITY,
		'wpselzy_read_forms'     => WPSELZY_ADMIN_READ_CAPABILITY,
		'wpselzy_delete_form'    => WPSELZY_ADMIN_READ_WRITE_CAPABILITY,
		'wpselzy_delete_forms'   => WPSELZY_ADMIN_READ_WRITE_CAPABILITY,
		'wpselzy_manage_options' => 'manage_options',
		'wpselzy_submit'         => 'read',
	];

	$meta_caps = apply_filters( 'wpselzy_map_meta_cap', $meta_caps );

	$caps = array_diff( $caps, array_keys( $meta_caps ) );

	if ( isset( $meta_caps[ $cap ] ) ) {
		$caps[] = $meta_caps[ $cap ];
	}

	return $caps;
}
