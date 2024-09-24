<?php
/**
 * Plugin Name: Pixel Gallery
 * Plugin URI: https://pixelgallery.pro/
 * Description: The all-new <a href="https://pixelgallery.pro/">Pixel Gallery</a> brings incredibly advanced, and super-flexible widgets, and A to Z essential addons to the Elementor page builder for WordPress. Explore expertly-coded widgets with first-class support by experts.
 * Version: 1.5.3
 * Author: BdThemes
 * Author URI: https://bdthemes.com/
 * Text Domain: pixel-gallery
 * Domain Path: /languages
 * License: GPL3
 * Elementor requires at least: 3.22
 * Elementor tested up to: 3.24.0
 */

// Some pre defined value for easy use
define( 'BDTPG_VER', '1.5.3' );
define( 'BDTPG_TPL_DB_VER', '1.0.0' );
define( 'BDTPG__FILE__', __FILE__ );
if ( ! defined( 'BDTPG_TITLE' ) ) {
	define( 'BDTPG_TITLE', 'Pixel Gallery' );
}

if ( ! function_exists( '_is_pg_pro_installed' ) ) {

	function _is_pg_pro_installed() {

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$file_path         = 'pixel-gallery-pro/pixel-gallery-pro.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

if ( ! function_exists( '_is_pg_pro_activated' ) ) {

	function _is_pg_pro_activated() {

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$file_path         = 'pixel-gallery-pro/pixel-gallery-pro.php';
		$installed_plugins = get_plugins();

		if ( is_plugin_active( $file_path ) ) {
			return true;
		}

		return false;
	}
}

// Helper function here
require_once ( dirname( __FILE__ ) . '/includes/helper.php' );

if ( ! _is_pg_pro_activated() ) {
	require_once BDTPG_INC_PATH . 'class-pro-widget-map.php';
}

if ( function_exists( 'pg_license_validation' ) && true !== pg_license_validation() ) {
	require_once BDTPG_INC_PATH . 'class-pro-widget-map.php';
}

require_once ( dirname( __FILE__ ) . '/includes/utils.php' );

/**
 * Plugin load here correctly
 * Also loaded the language file from here
 */
function pixel_gallery_load_plugin() {
	load_plugin_textdomain( 'pixel-gallery', false, BDTPG_PNAME . '/languages' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'pixel_gallery_fail_load' );

		return;
	}

	// Widgets filters here
	require_once ( BDTPG_INC_PATH . 'pixel-gallery-filters.php' );

	// Element pack widget and assets loader
	require_once ( BDTPG_PATH . 'loader.php' );

	// Notice class
	require_once ( BDTPG_ADMIN_PATH . 'admin-notice.php' );
}

add_action( 'plugins_loaded', 'pixel_gallery_load_plugin', 9 );


/**
 * Check Elementor installed and activated correctly
 */
function pixel_gallery_fail_load() {

	$screen = get_current_screen();

	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
		$admin_message  = '<p>' . esc_html__( 'Ops! Pixel Gallery not working because you need to activate the Elementor plugin first.', 'pixel-gallery' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'pixel-gallery' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		$install_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		$admin_message = '<p>' . esc_html__( 'Ops! Pixel Gallery not working because you need to install the Elementor plugin', 'pixel-gallery' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'pixel-gallery' ) ) . '</p>';
	}

	printf( '<div class="error">%1$s</div>', wp_kses_post( $admin_message ) );
}

/**
 * Check the elementor installed or not
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {
	function _is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

/**
 * Added notice after install or upgrade to v6
 *
 * @param string $plugin
 * @return void
 */
function pg_activation_redirect( $plugin ) {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	if ( $plugin == plugin_basename( BDTPG__FILE__ ) ) {
		exit( wp_redirect( admin_url( 'admin.php?page=pixel_gallery_options&notice=v6' ) ) );
	}
}

add_action( 'activated_plugin', 'pg_activation_redirect', 20 );


/**
 * SDK Integration
 */

if ( ! function_exists( 'dci_plugin_pixel_gallery' ) ) {
	function dci_plugin_pixel_gallery() {

		// Include DCI SDK.
		require_once dirname( __FILE__ ) . '/dci/start.php';

		wp_enqueue_style( 'dci-sdk-pg', plugins_url( 'dci/assets/css/dci.css', __FILE__ ), array(), '1.2.0', 'all' );

		dci_dynamic_init( array(
			'sdk_version'         => '1.2.1',
			'product_id'          => 7,
			'plugin_name'         => 'Pixel Gallery', // make simple, must not empty
			'plugin_title'        => 'Love using Pixel Gallery? Congrats 🎉  ( Never miss an Important Update )',
			'plugin_icon'         => BDTPG_ASSETS_URL . 'images/logo.svg',
			'api_endpoint'        => 'https://analytics.bdthemes.com/wp-json/dci/v1/data-insights',
			'slug'                => 'pixel-gallery',
			'menu'                => array(
				'slug' => 'pixel_gallery_options',
			),
			'public_key'          => 'pk_BnUlEdhDltMcn1IlZHH8V1YLDoGjvl40',
			'is_premium'          => true,
			'popup_notice'        => false,
			'deactivate_feedback' => true,
			'delay_time'          => [ 
				'time' => 3 * DAY_IN_SECONDS,
			],
			'plugin_msg'          => '<p>Be Top-contributor by sharing non-sensitive plugin data and create an impact to the global WordPress community today! You can receive valuable emails periodically.</p>',
		) );

	}
	add_action( 'admin_init', 'dci_plugin_pixel_gallery' );
}
