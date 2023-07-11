<?php
	class Database{
		
		private $host = "127.0.0.1";
		private $database_name = "conductores";
		private $username = "root";
		private $password = "Ruben_1984@@";
		public $conn;
		
		public function obtenerConexion(){		
			$this->conn = null;
			try{
					$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
					$this->conn->exec("set names utf8");
			}catch(PDOException $exception){
					echo "No se pudo conectar a la base de datos: " . $exception->getMessage();
			}
			return $this->conn;
		}
	}
?>