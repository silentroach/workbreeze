<?php

class Cache {

	// TODO maybe there is a reason to make it work via private static array, not via apc

	public static function set($key, $value, $ttl = 60) {
		apc_store($key, $value, $ttl);
	}

	public static function get($key) {
		$success = false;

		$val = apc_fetch($key, $success);

		if (!$success) {
			return false;
		} else {
			return $val;
		}
	}

}
