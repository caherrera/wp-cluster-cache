<?php

namespace WpClusterCache;

class Actions {

	private function __construct() {
		self::init();


	}

	public function init() {

		add_action( 'clean_post_cache', [ $this, 'clean_cluster_cache' ] );
		add_action( 'clean_remote_cache', [ $this, 'clean_remote_cache' ] );


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

	public function clean_cluster_cache() {
		$hosts = (array) Settings::getHosts();
		foreach ( $hosts as $host ) {
			
		}

	}

	public function clean_remote_cache( $post ) {
		clean_post_cache( $post );
	}


}
