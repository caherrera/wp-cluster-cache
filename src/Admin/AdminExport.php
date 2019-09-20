<?php

namespace WpClusterCache\Admin;

use WpClusterCache\Admin\Helpers\HtmlForm;
use WpClusterCache\Traits\TraitHasFactory;

class AdminExport {
	use TraitHasFactory;

	public function settingsPage() {

		$page = new HtmlForm();
		$page->add( $page->wrap( [
			$page->title( 'Export WP Users' ),
			$page->hidden( [ 'name' => 'action', 'value' => 'adldap2_export_wp_users' ] ),
			$page->submit( 'Download Wordpress Users' )
		], 'form', [ 'method' => 'post', 'action' => admin_url( 'admin-post.php' ) ] ) );

		echo $page;

	}


}