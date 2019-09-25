<?php


namespace WpClusterCache\Admin;

use WpClusterCache\Settings;

class Init {
	const PREFIX = 'WP_CLUSTER_CACHE';
	private static $instance;

	private function __construct() {
		self::init();


	}


	public function init() {
		if ( is_admin() ) { // admin actions
			add_action( 'admin_menu', [ $this, 'menu' ] );
			add_action( 'admin_init', [ $this, 'registerSettings' ] );
			if ( ! wp_doing_ajax() && ! wp_doing_cron() ) {
				add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts_and_css' ] );
			}

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

	public function enqueue_scripts_and_css() {
		wp_enqueue_style( 'jquery-ui-core' );
		$wp_scripts = wp_scripts();
		wp_enqueue_style( 'plugin_name-admin-ui-css',
			'//ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-core']->ver . '/themes/smoothness/jquery-ui.css',
			false,
			false,
			'all' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( WP_CLUSTER_CACHE, plugins_url( 'js/bootstrap.js', WP_CLUSTER_PLUGIN ) );

	}

	public function registerSettings() {
		register_setting( self::PREFIX, self::PREFIX . '_' . Settings::CONFIG_HOSTS );

	}

	public function menu() {

		add_menu_page( 'Cluster Cache', 'Cluster Cache', 'edit_users', self::PREFIX, [ AdminSettings::factory(), 'settingsPage' ] );
		add_submenu_page( self::PREFIX, 'Test', 'Test', 'edit_users', self::PREFIX . '_test', [ AdminTestConn::factory(), 'settingsPage' ] );
	}


}