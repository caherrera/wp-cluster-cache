<?php
if ( ! is_dir( __DIR__ . '/vendor' ) ) {
	wp_die( 'must run composer install on ' . __DIR__ . ' folder' );

}
require_once __DIR__ . '/vendor/autoload.php';
define( 'WPCLUSTERCACHE', 'WPCLUSTERCACHE' );
define( 'WPCLUSTERCACHE_DIR', __DIR__ );

if ( is_admin() ) {
	\WpClusterCache\Admin\Init::factory();
}

\WpClusterCache\Actions::factory();
