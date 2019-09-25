<?php

namespace WpClusterCache;

class User extends \WP_User {

	public function __construct( $id = 0, $name = '', $site_id = '' ) {

		parent::__construct( $id, WP_CLUSTER_CACHE, $site_id );
	}

	public static function get_user() {
		$user = self::get_user_by_id();

		return $user->exists() ? $user : self::get_user_by_name();
	}

	public static function get_user_by_id() {
		return new self( Settings::getUserid() );
	}

	public static function get_user_by_name() {
		return new self( 0, WP_CLUSTER_CACHE );
	}


}