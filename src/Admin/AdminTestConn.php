<?php

namespace WpClusterCache\Admin;

use WpClusterCache\Admin\Helpers\HtmlForm;
use WpClusterCache\Client;
use WpClusterCache\Settings;
use WpClusterCache\Traits\TraitHasFactory;

class AdminTestConn {
	use TraitHasFactory;

	public function settingsPage() {

		$page    = new HtmlForm();
		$results = $this->testResults();
		$rows    = [];

		foreach ( $results as $v ) {
			$icon   = $v['ok'] == true ? '<span class="dashicons dashicons-yes" style="color:green"></span>' : '<span class="dashicons dashicons-dismiss" style="color: red"></span>';
			$rows[] = $page->row( [ $page->td( $icon, [ 'style' => 'width: 2.2em;' ] ), $page->td( $v['title'] ), $page->td( $v['result'] ) ] );
		}
		$page->add( $page->table( [
			$page->thead( $page->row( [
				$page->td( '<span class="dashicons dashicons-yes" style="color:green"></span>', [ 'style' => 'width: 2.2em;' ] ),
				$page->th( 'Check' ),
				$page->th( 'Result' )
			] ) ),
			$page->tbody( $rows )
		], [ 'class' => 'wp-list-table widefat fixed striped' ] ) );
		echo $page;

	}

	public function testResults() {
		$results = [];

		$results[] = [ 'title' => 'Has Hosts      ', 'result' => ( $ok = ! empty( Settings::getHosts() ) ) ? 'OK' : 'Missing', 'ok' => $ok ];
		$results[] = [ 'title' => 'Has Port       ', 'result' => ( $ok = ! empty( Settings::getPort() ) ) ? 'OK' : 'Missing', 'ok' => $ok ];
		$results[] = [ 'title' => 'Has Protocol   ', 'result' => ( $ok = ! empty( Settings::getProtocol() ) ) ? 'OK' : 'Missing', 'ok' => $ok ];
		$results[] = [ 'title' => 'Has WP User id ', 'result' => ( $ok = ! empty( Settings::getUserid() ) ) ? 'OK' : 'Missing', 'ok' => $ok ];
		$results[] = [ 'title' => 'Has Password   ', 'result' => ( $ok = ! empty( Settings::getPassword() ) ) ? 'OK' : 'Missing', 'ok' => $ok ];

		foreach ( Settings::hosts() as $h => $host ) {
			$assert = '';
			try {
				$assert = "Connection to Host ($h) : $host";
				if ( $host ) {
					$client    = Client::client_by_host( $host );
					$response  = $client->testConnection();
					$results[] = [ 'title' => $assert, 'result' => $response, 'ok' => $response === true ];
				}
			} catch ( Exception $e ) {
				$results[] = [ 'title' => $assert, 'result' => $e->getMessage(), 'ok' => false ];
			}

		}

		return $results;

	}
}