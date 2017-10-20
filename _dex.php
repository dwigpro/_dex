<?php
/*
 * Plugin Name: DWIG Extension
 * Plugin URI:  https://example.com/
 * Description: DWIG Extension Description
 * Author:      Unknown Author
 * Author URI:  http://example.com/
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: _dex
 * Domain Path: /languages
 *
 * Version:     1.0.0
 *
 */

define( '_DEX_VERSION', '1.0.0' );
define( '_DEX_PLUGIN_FILE', __FILE__ );

/*
-------------------------------------------------------------------------------
No direct access allowed!
-------------------------------------------------------------------------------
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
-------------------------------------------------------------------------------
Activate DWIG plugin if request comes from an extension warning page.
-------------------------------------------------------------------------------
*/
add_action( 'plugins_loaded', function() {
	if (
		! empty( $_GET['activate_dwig_plugin'] )
		&& wp_verify_nonce( sanitize_key( $_GET['activation_nonce'] ), 'activate_dwig_plugin' )
	) {
		if ( ! function_exists( 'activate_plugin' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		activate_plugin( 'dwig/dwig.php' );
	}
}, 1 );

/*
-------------------------------------------------------------------------------
Display a warning page if DWIG plugin is not active
-------------------------------------------------------------------------------
*/
add_action( 'init', function() {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	if ( ! is_plugin_active( 'dwig/dwig.php' ) ) {
		include plugin_dir_path( __FILE__ ) . 'warning.php';
	}
}, 1 );

/*
-------------------------------------------------------------------------------
Hook this extension when DWIG plugin is ready.
-------------------------------------------------------------------------------
*/
add_action( 'dwig:extension', function() {
	define( '_DEX_NAMESPACE',       '_Dex' );
	define( '_DEX_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

	define( '_DEX_PATH',            plugin_dir_path( __FILE__ ) );
	define( '_DEX_URL',             plugin_dir_url( __FILE__ ) );
	define( '_DEX_URI',             _DEX_URL ); // Alias

	new Dwig_Autoload( _DEX_PATH, _DEX_NAMESPACE );
} );
