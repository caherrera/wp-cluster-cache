<?php

namespace WpClusterCache\Admin;

use Exception;
use WpClusterCache\Admin\Views\AdminPageExploreLdap;
use WpClusterCache\Migrators\LdapToWp;
use WpClusterCache\Settings;
use WpClusterCache\Traits\TraitHasFactory;

class AdminExploreLdap {
	use TraitHasFactory;

	public function settingsPage() {

		$p = new AdminPageExploreLdap();
		$p->setList( $this->getList() );

		echo $p;


	}

	public function getList() {
		try {
			$ldap     = new LdapToWp();
			$users    = $ldap->syncListUsers();


			return $users;

		} catch ( Exception $e ) {
			wp_die( $e->getMessage() );
		}
	}


}