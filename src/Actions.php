<?php

namespace WpClusterCache;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

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

	public function broadcast() {
		if ( empty( $params = array_filter( func_get_args() ) ) ) {
			$params = $_GET;
		}
		$hosts   = (array) Settings::hosts();
		$results = [];
		foreach ( $hosts as $host ) {
			$client = Client::client_by_host( $host );
			try {
				$response         = $client->requestDeleteCache( $params );
				$results[ $host ] = [ 'status' => $response->getStatusCode(), 'body' => $response->getBody()->getContents() ];

			} catch ( ClientException $e ) {
				$results[ $host ] = [ 'status' => $e->getResponse()->getStatusCode(), 'body' => $e->getMessage() ];
			} catch ( ConnectException $e ) {
				$results[ $host ] = [ 'status' => 500, 'body' => $e->getMessage() ];
			}
		}
		wp_send_json_success( $results );
	}

	public function clean() {
		$params = $_GET;

		if ( isset( $params['id'] ) && is_numeric( $params['id'] ) ) {
			wpsc_delete_post_cache( $params['id'] );

		} elseif ( ! empty( $params['expired'] ) ) {
			global $file_prefix;
			wp_cache_clean_expired( $file_prefix );

		} elseif ( isset( $params['url'] ) ) {
			global $cache_path;

			$directory = $cache_path . 'supercache/' . $params['url'];
			wpsc_delete_files( $directory );
			prune_super_cache( $directory . '/page', true );

		} else {
			global $file_prefix;
			wp_cache_clean_cache( $file_prefix, ! empty( $params['all'] ) );
		}

		return wp_send_json_success( array( 'Cache Cleared' => true ) );
	}


}
