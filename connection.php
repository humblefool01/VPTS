<?php
	$host = "localhost";
	$user = "root";
	$databaseName = "vpts";

	$connect = mysqli_connect($host, $user, '', $databaseName);

	class Connection {
		private $databaseName;
		private $host;
		private $password;
		private $user;

		public function __construct() {
			$this->databaseName = "vpts";
			$this->host = "localhost";
			$this->password = '';
			$this->user = "root";
		}

		public function getConnection() {
			$db_connection = new mysqli($this->host, $this->user, $this->password, $this->databaseName)
				or die("Error connection to the database");
			return $db_connection;
		}
	}
?>