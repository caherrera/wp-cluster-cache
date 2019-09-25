<?php
/*
Plugin Name: WP Cluster Cache
Plugin URI: https://github.com/caherrera/wp-cluster-cache
Description: Wordpress Plugin that cleans cache files to other servers from a cluster.
Version: 1.0.0
Author: caherrera
Tags: performance, caching, wp-cache, wp-super-cache, cache
Tested up to: 4.9.5
Stable tag: 1.0.0
Requires at least: 3.0
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


if ( ! is_dir( __DIR__ . '/vendor' ) ) {
	wp_die( 'must run composer install on ' . __DIR__ . ' folder' );

}
require_once __DIR__ . '/vendor/autoload.php';
define( 'WP_CLUSTER_CACHE', 'WP_CLUSTER_CACHE' );
define( 'WP_CLUSTER_CACHE_DIR', __DIR__ );
define( 'WP_CLUSTER_PLUGIN', __FILE__ );

if ( is_admin() ) {
	\WpClusterCache\Admin\Init::factory();
}

\WpClusterCache\Init::factory();
\WpClusterCache\Actions::factory();

# todo: Develop Admin Screen
# todo: Develop Simple Auth System
# todo: Develop Master/Slave Register
# todo: Develop Clean Cache from url call (with auth)
# todo: Develop Broadcast clean cache (triggered from Cache plugins)
# todo: Develop Broadcast clean cache (triggered from admin page)
# todo: Develop Broadcast clean cache (triggered from page save event)
# todo: Revoke Permissions
# todo: Transfer wp-cache-config.php file