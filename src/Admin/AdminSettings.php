<?php

namespace WpClusterCache\Admin;

use WpClusterCache\Admin\Views\AdminPage;
use WpClusterCache\Traits\TraitHasFactory;

class AdminSettings {
	use TraitHasFactory;

	public function settingsPage() {
		if ( $_POST ) {
			$this->saveSettings();
		}
		echo new AdminPage();

	}

	public function saveSettings() {
		foreach ( $_POST as $key => $item ) {
			if ( preg_match( "/" . WP_CLUSTER_CACHE . "/", $key ) ) {
				update_option( $key, $item, false );
			}
		}
	}
}