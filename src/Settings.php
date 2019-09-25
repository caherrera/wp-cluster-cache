<?php

namespace WpClusterCache;

class Settings {
	const CONFIG_HOSTS = 'hosts';
	const CONFIG_PORT = 'port';
	const CONFIG_PROTOCOL = 'protocol';
	const CONFIG_USER_ID = 'user_id';
	const CONFIG_PASSWORD = 'password';


	public static function getHosts() {
		return get_option( static::getConfigNameOfHosts() );
	}

	public static function getConfigNameOfHosts() {
		return WP_CLUSTER_CACHE . '_' . Settings::CONFIG_HOSTS;
	}

	public static function getPort() {
		return get_option( static::getConfigNameOfPort() );
	}

	public static function getConfigNameOfPort() {
		return WP_CLUSTER_CACHE . '_' . Settings::CONFIG_PORT;
	}

	public static function getProtocol() {
		return get_option( static::getConfigNameOfProtocol() );
	}

	public static function getConfigNameOfProtocol() {
		return WP_CLUSTER_CACHE . '_' . Settings::CONFIG_PROTOCOL;
	}

	public static function getUserid() {
		return get_option( static::getConfigNameOfUserid() );
	}

	public static function getConfigNameOfUserid() {
		return WP_CLUSTER_CACHE . '_' . Settings::CONFIG_USER_ID;
	}


	public static function getPassword() {
		return get_option( static::getConfigNameOfPassword() );
	}

	public static function getConfigNameOfPassword() {
		return WP_CLUSTER_CACHE . '_' . Settings::CONFIG_PASSWORD;
	}

	public function setPassword( $item ) {
		update_option( self::getConfigNameOfPassword(), $item, false );

		return $this;
	}

	public function setUserid( $item ) {
		update_option( self::getConfigNameOfUserid(), $item, false );

		return $this;
	}


}
