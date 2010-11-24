<?php

/**
 * Database class
 * @autho Kalashnikov Igor <igor.kalashnikov@gmail.com>
 */
class Database {

	/**
	 * Database instance
	 * @var Database
	 */
	private static $instance = null;

	/**
	 * Database
	 * @var Mongo
	 */
	private $db;

	/**
	 * @constructor
	 */
	public function __construct() {
		$mongo = new Mongo();

		// DB is defined in bootstrap.php
		$dbname = DB;

		// selecting the database
		$this->db = $mongo->$dbname;
	}

	/**
	 * Get the database collection
	 * @param $collection string Collection name.
	 * @return MongoCollection
	 */
	public function getCollection($collection) {
		return $this->db->$collection;
	}

	/**
	 * Getting the database class instance
	 * @return Database
	 */
	private static function instance() {
		// check the instance exists
		if (null === self::$instance) {
			self::$instance = new Database();
		}

		return self::$instance;
	}

	/**
	 * Get the sites collection
	 * @return MongoCollection
	 */
	public static function sites() {
		return self::instance()->getCollection('sites');
	}

	/**
	 * Get the jobs collection
	 * @return MongoCollection
	 */
	public static function jobs() {
		return self::instance()->getCollection('jobs');
	}

	/**
 	 * Get the queue collection
	 * @return MongoCollection
   */
	public static function queue() {
		return self::instance()->getCollection('queue');
	}

	/**
 	 * Get the log collection
	 * @return MongoCollection
   */
	public static function log() {
		return self::instance()->getCollection('log');
	}

	/**
 	 * Get the slog collection
	 * FIXME ???
	 * @return MongoCollection
   */
	public static function slog() {
		return self::instance()->getCollection('slog');
	}

}
