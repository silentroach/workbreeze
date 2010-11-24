<?php

/**
 * Class to work with sphinx
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 */
class Sphinx {

	private static $instance = null;
	private $connection;

	private static function instance() {
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	// ------------------------
	
	public function __construct() {
		$this->connection = mysql_connect(SPHINX);

		if (!$this->connection) {
			echo "Can't connect to Sphinx\n";
			exit(1);
		}
	}

	private function escape($value) {
		return preg_replace('@\'@u', '\\\'', $value);
	}

	public function _add($index, $id, $values = array()) {
		foreach ($values as &$value) {
			if (is_string($value)) {
				$value = '\'' . $this->escape($value) . '\'';
			}
		}

		$q = 
			'INSERT INTO ' . $index . ' VALUES (' . $id . ', ' .
			implode(',', $values) . ');';

		echo $q;

		mysql_query($q, $this->connection);
	}

	// ------------------------

	public static function add($index, $id, $values = array()) {
		self::instance()->_add($index, $id, $values);
	}

}
