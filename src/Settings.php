<?php

namespace WpClusterCache;

class Settings {
	const CONFIG_HOSTS = 'hosts';

	public static function getHosts() {
		return get_option( static::getConfigNameOfHosts() );
	}

	public static function getConfigNameOfHosts() {
		return WPCLUSTERCACHE . '_' . Settings::CONFIG_HOSTS;
	}


}
