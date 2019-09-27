<?php

namespace WpClusterCache;

class Init {
	private static $instance;

	private function __construct() {
		self::init();


	}

	public function init() {


		add_action( 'wp_loaded', [ $this, 'checkUserExists' ] );
		add_action( 'clean_post_cache', [ $this, 'notify_clean_post_cache' ] );

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

	public function notify_clean_post_cache( $post_id ) {
		return call_user_func_array( [ Actions::factory(), 'broadcast' ], [ [ 'id' => $post_id ] ] );
	}

	public function notify_clean_cache( $post_id ) {
		return call_user_func_array( [ Actions::factory(), 'broadcast' ], [ [ 'all' => 1 ] ] );
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
