<?php

namespace WpClusterCache\Admin;

use WpClusterCache\Admin\Views\AdminPage;
use WpClusterCache\Cache;
use WpClusterCache\Traits\TraitHasFactory;

class AdminSettings {
	use TraitHasFactory;

	public function settingsPage() {
		if ( $_POST ) {
			$this->saveSettings();
			Cache::flush();
		}
		echo new AdminPage();

	}

	public function saveSettings() {
		foreach ( $_POST as $key => $item ) {
			if ( preg_match( "/" . WpClusterCache . "/", $key ) ) {
				update_option( $key, $item );
			}
		}
	}
}