<?php

require_once WPSELZY_PLUGIN_DIR . '/includes/SelzyApi.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/View.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/SelzyFormFieldTypes.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/SelzyFormFieldStyle.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/l10n.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/capabilities.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/functions.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/formatting.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/form-functions.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/form-template.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/form.php';
require_once WPSELZY_PLUGIN_DIR . '/includes/controller.php';

if ( is_admin() ) {
	require_once WPSELZY_PLUGIN_DIR . '/admin/admin.php';
}

class WPSELZY {


	/**
	 * Retrieves a named entry from the option array of Selzy.
	 *
	 * @param string $name Array item key.
	 * @param mixed $default Optional. Default value to return if the entry
	 *                       does not exist. Default false.
	 *
	 * @return mixed Array value tied to the $name key. If nothing found,
	 *               the $default value will be returned.
	 */
	public static function get_option( $name, $default = false ) {
		$option = get_option( 'wpselzy' );

		if ( false === $option ) {
			return $default;
		}

		if ( isset( $option[ $name ] ) ) {
			return $option[ $name ];
		} else {
			return $default;
		}
	}


	/**
	 * Update an entry value on the option array of Selzy.
	 *
	 * @param string $name Array item key.
	 * @param mixed $value Option value.
	 */
	public static function update_option( $name, $value ) {
		$option = get_option( 'wpselzy' );
		$option = ( false === $option ) ? array() : (array) $option;
		$option = array_merge( $option, array( $name => $value ) );
		update_option( 'wpselzy', $option );
	}
}


add_action( 'plugins_loaded', 'wpselzy', 10, 0 );

/**
 * Registers WordPress shortcodes.
 */
function wpselzy() {
	add_shortcode( 'selzy-form', 'wpselzy_form_tag_func' );
}


add_action( 'init', 'wpselzy_init', 10, 0 );

/**
 * Registers post types for forms.
 */
function wpselzy_init() {
	wpselzy_get_request_uri();
	wpselzy_register_post_types();

	do_action( 'wpselzy_init' );
}


add_action( 'admin_init', 'wpselzy_upgrade', 10, 0 );

/**
 * Upgrades option data when necessary.
 */
function wpselzy_upgrade() {
	$old_ver = WPSELZY::get_option( 'version', '0' );
	$new_ver = WPSELZY_VERSION;

	if ( $old_ver == $new_ver ) {
		return;
	}

	do_action( 'wpselzy_upgrade', $new_ver, $old_ver );

	WPSELZY::update_option( 'version', $new_ver );
}


add_action( 'activate_' . WPSELZY_PLUGIN_BASENAME, 'wpselzy_install', 10, 0 );

/**
 * Callback tied to plugin activation action hook. Attempts to create
 * initial user dataset.
 */
function wpselzy_install() {
	if ( $opt = get_option( 'wpselzy' ) ) {
		return;
	}

	wpselzy_register_post_types();
	wpselzy_upgrade();

	if ( get_posts( [ 'post_type' => 'wpselzy_form' ] ) ) {
		return;
	}

	$form = WPSELZY_Form::get_template(
		[
			'title' =>
			/* translators: title of your first form. %d: number fixed to '1' */
				sprintf( __( 'Форма %d', 'selzy' ), 1 ),
		]
	);

	$form->save();
}
