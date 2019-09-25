<?php

namespace WpClusterCache;

class Actions {
	private static $instance;

	private function __construct() {
		self::init();


	}

	public function init() {

		$this->addAjaxAction( 'status' );
		$this->addAjaxAction( 'clean' );
		$this->addAjaxAction( 'broadcast' );
	}

	public function addAjaxAction( $action, $method = null ) {
		switch ( true ) {
			case is_null( $method ):
				$callable = [ $this, $action ];
				break;
			case is_string( $method ):
				$callable = [ $this, $method ];
				break;
			case is_callable( $method ):
				$callable = $method;
				break;
			default:
				return;
		}

		add_action( 'wp_ajax_' . strtolower( WP_CLUSTER_CACHE ) . '_' . $action, $callable );
		add_action( 'wp_ajax_nopriv_' . strtolower( WP_CLUSTER_CACHE ) . '_' . $action, $callable );
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

	public function status() {
		wp_send_json_success();
	}

	public function clean_cluster_cache() {
		$hosts = (array) Settings::getHosts();
		foreach ( $hosts as $host ) {

		}

	}

	public function clean_remote_cache() {
		if ( $id = get_query_var( 'p' ) && $type = get_query_var( 'post_type' ) ) {
			if ( $post = get_post( $id ) ) {
				clean_post_cache( $id );
			} else {
				wp_die( "ID does not exists" );
			}
		} else {
			wp_die( "ID is not present" );
		}
	}


}
