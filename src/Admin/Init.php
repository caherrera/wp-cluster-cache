<?php


namespace WpClusterCache\Admin;

use WpClusterCache\Settings;

class Init {
	const PREFIX = 'WPCLUSTERCACHE';
	private static $instance;

	private function __construct() {
		self::init();


	}


	public function init() {
		if ( is_admin() ) { // admin actions
			add_action( 'admin_menu', [ $this, 'menu' ] );
			add_action( 'admin_init', [ $this, 'registerSettings' ] );
			add_action( 'admin_post_adldap2_export_wp_users', [ ExportCsv::factory(), 'export' ] );
		}


	}

	static public function factory() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		return self::$instance;
	}

	public function registerSettings() {
		register_setting( self::PREFIX, self::PREFIX . '_' . Settings::CONFIG_HOSTS );

	}

	public function menu() {

		add_menu_page( self::PREFIX, 'WP-CLUSTER-CACHE', 'edit_users', self::PREFIX, [ AdminSettings::factory(), 'settingsPage' ] );
		add_submenu_page( self::PREFIX, 'Test', 'Test', 'edit_users', self::PREFIX . '_test', [ AdminTestConn::factory(), 'settingsPage' ] );
	}


}