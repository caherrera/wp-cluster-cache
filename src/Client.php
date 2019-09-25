<?php

namespace WpClusterCache;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class Client extends HttpClient {

	public function __construct( array $config = [] ) {

		$config = array_merge( [
			'verify'        => false,
			'Authorization' => 'Basic ' . base64_encode( sprintf( "%s:%s", User::get_user()->user_login, Settings::getPassword() ) )
		], $config );
		parent::__construct( $config );

	}

	public static function client_by_host( $host ) {
		$base_uri = sprintf( "%s://%s:%s", Settings::getProtocol(), $host, Settings::getPort() );
		$client   = new self( [ 'base_uri' => $base_uri ] );

		return $client;

	}

	public function testConnection() {
		try {
			$response = $this->requestStatus();

			return $response->getStatusCode() == 200;
		} catch ( ClientException $e ) {
			return $e->getResponse()->getReasonPhrase();
		} catch ( ConnectException $e ) {
			return $e->getMessage();
		}

	}

	public function requestStatus() {
		$end_point = $this->endPointStatus();

		return $this->request( 'GET', $end_point );
	}

	public function endPointStatus() {
		return $this->endPoint( [ 'action' => strtolower( WP_CLUSTER_CACHE ) . '_status' ] );
	}

	public function endPoint( $extra ) {
		$query = build_query( $extra );

		return '/wp-admin/admin-ajax.php?' . $query;
	}

	public function requestDeleteCache( array $params = [] ) {
		$end_point = $this->endPointDelete( $params );

		return $this->request( 'GET', $end_point );
	}

	public function endPointDelete( array $params = [] ) {
		$params['action'] = strtolower( WP_CLUSTER_CACHE ) . '_delete';

		return $this->endPoint( $params );
	}
}
