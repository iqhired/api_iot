<?php
	class DevLogin{
		
		// Connection
		private $conn;
		
		// Table
		private $db_table = "iot_users";
		
		// Columns
		
		// Db connection
		public function __construct($db)
		{
			$this->conn = $db;
		}
		
	}