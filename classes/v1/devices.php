<?php
	class Devices{
		
		// Connection
		private $conn;
		
		// Table
		private $db_table = "iot_devices";
		
		// Columns
		
		// Db connection
		public function __construct($db)
		{
			$this->conn = $db;
		}
		
	}