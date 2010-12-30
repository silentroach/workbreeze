<?php

/**
 * Cache
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */ 
class Cache {

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
