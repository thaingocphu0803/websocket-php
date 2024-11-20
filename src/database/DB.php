<?php

require_once __DIR__ . '/../../../config.php';


class DB
{
	private static $instance = null;
	private $conn = null;

	public function __construct()
	{
		$this->connect_db();
	}
	// using singleton pattern
	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new DB();
		}
		return self::$instance;
	}

	public function connect_db()
	{
		if ($this->conn === null) { // Only connect if there's no existing connection
			try {
				$dbhost = DB_HOST;
				$dbname = DB_NAME;
				$username = USER_NAME;
				$password = PASSWORD;

				$this->conn = new PDO("mysql:host={$dbhost};dbname={$dbname}", $username, $password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die("Connection failed: " . $e->getMessage());
			}
		}
		// return $this->conn;
	}

	//execute sql queries
	public function query($sql, $params = [])
	{
		$stmt = $this->conn->prepare($sql);

		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$stmt->bindValue($key, $value);
			}
		}

		if ($stmt->execute()) {
			return $stmt;
		} else {
			return false;
		}
	}
	//return array result
	public function fetch_all($stmt)
	{
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	//return one row result
	public function fetch($stmt)
	{
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	// transaction conbeginTransaction
	public function transaction_start()
	{
		return $this->conn->beginTransaction();
	}
	//transaction commit
	public function transaction_commit()
	{
		return $this->conn->commit();
	}
	//transaction rollback
	public function transaction_rollback()
	{
		return $this->conn->rollBack();
	}
}
