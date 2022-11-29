<?php
/*
Plugin Name: Selzy
Plugin URI: https://selzy.com/ua/support/category/integration/
Description: The plugin allows you to create a subscription form on your website and send user data to Selzy.
Author: Selzy Inc
Author URI: https://selzy.com/
Text Domain: unisender
Domain Path: /languages/
Version: 1.0.0
*/

define( 'WPSELZY_VERSION', '1.0.0' );

define( 'WPSELZY_REQUIRED_WP_VERSION', '5.7' );

define( 'WPSELZY_TEXT_DOMAIN', 'selzy' );

define( 'WPSELZY_PLUGIN', __FILE__ );

define( 'WPSELZY_PLUGIN_BASENAME', plugin_basename( WPSELZY_PLUGIN ) );

define( 'WPSELZY_PLUGIN_NAME', trim( dirname( WPSELZY_PLUGIN_BASENAME ), '/' ) );

define( 'WPSELZY_PLUGIN_DIR', untrailingslashit( dirname( WPSELZY_PLUGIN ) ) );


if ( ! defined( 'WPSELZY_LOAD_JS' ) ) {
	define( 'WPSELZY_LOAD_JS', true );
}

if ( ! defined( 'WPSELZY_LOAD_CSS' ) ) {
	define( 'WPSELZY_LOAD_CSS', true );
}

if ( ! defined( 'WPSELZY_AUTOP' ) ) {
	define( 'WPSELZY_AUTOP', true );
}

if ( ! defined( 'WPSELZY_USE_PIPE' ) ) {
	define( 'WPSELZY_USE_PIPE', true );
}

if ( ! defined( 'WPSELZY_ADMIN_READ_CAPABILITY' ) ) {
	define( 'WPSELZY_ADMIN_READ_CAPABILITY', 'edit_posts' );
}

if ( ! defined( 'WPSELZY_ADMIN_READ_WRITE_CAPABILITY' ) ) {
	define( 'WPSELZY_ADMIN_READ_WRITE_CAPABILITY', 'publish_pages' );
}

if ( ! defined( 'WPSELZY_VERIFY_NONCE' ) ) {
	define( 'WPSELZY_VERIFY_NONCE', false );
}

// Deprecated, not used in the plugin core. Use wpselzy_plugin_url() instead.
define( 'WPSELZY_PLUGIN_URL',
	untrailingslashit( plugins_url( '', WPSELZY_PLUGIN ) )
);

require_once WPSELZY_PLUGIN_DIR . '/load.php';