<?php
	
	class Usuarios{
        
		private $conn;
		private $db_table = "Usuarios";
		
		public $id;
		public $nombre;
		public $apellido;
		public $email;
		public $password;

		public function __construct($db){
			$this->conn = $db;
		}
		
		public function getUsuarios(){
			$sqlQuery = "SELECT id, nombre, apellido, email, fecha_creacion, fecha_modificacion FROM " .$this->db_table. "";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
		}
		
		public function createUsuario(){
			
			$sqlQuery = "INSERT INTO ".$this->db_table. " SET nombre = :nombre, apellido = :apellido, email = :email, password = :password, fecha_creacion = :fecha_creacion";

			$stmt = $this->conn->prepare($sqlQuery);

			$this->nombre=htmlspecialchars(strip_tags($this->nombre));
			$this->apellido=htmlspecialchars(strip_tags($this->apellido));
			$this->email=htmlspecialchars(strip_tags($this->email));
			$this->password=htmlspecialchars(strip_tags($this->password));
			$this->fecha_creacion=htmlspecialchars(strip_tags($this->fecha_creacion));
			
			$stmt->bindParam(':nombre', $this->nombre);
			$stmt->bindParam(':apellido', $this->apellido);
			$stmt->bindParam(':email', $this->email);
			$stmt->bindParam(":fecha_creacion", $this->fecha_creacion);

			$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password_hash);

			if($stmt->execute()){
				return true;
			}
			
			return false;

		}

		public function emailExists(){
			
			$sqlQuery = "SELECT id, nombre, apellido, password FROM " .$this->db_table. " WHERE email = ? LIMIT 0,1";
			$stmt = $this->conn->prepare($sqlQuery);

			$this->email=htmlspecialchars(strip_tags($this->email));

			$stmt->bindParam(1, $this->email);
			$stmt->execute();

			$num = $stmt->rowCount();
			if($num>0){
				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);

				$this->id = $row['id'];
				$this->nombre = $row['nombre'];
				$this->apellido = $row['apellido'];
				$this->password = $row['password'];

				return true;
			}

			return false;
		}
    
		public function updateUsuario(){

			$password_set=!empty($this->password) ? ", password = :password" : "";
 
			$sqlQuery = "UPDATE ".$this->db_table. " SET nombre = :nombre, apellido = :apellido, email = :email, fecha_modificacion = :fecha_modificacion {$password_set} WHERE id = :id";
	 
			$stmt = $this->conn->prepare($sqlQuery);
	 
			$this->nombre=htmlspecialchars(strip_tags($this->nombre));
			$this->apellido=htmlspecialchars(strip_tags($this->apellido));
			$this->email=htmlspecialchars(strip_tags($this->email));
			$this->fecha_modificacion=htmlspecialchars(strip_tags($this->fecha_modificacion));
	 
			$stmt->bindParam(':nombre', $this->nombre);
			$stmt->bindParam(':apellido', $this->apellido);
			$stmt->bindParam(':email', $this->email);
			$stmt->bindParam(':fecha_modificacion', $this->fecha_modificacion);
	 
			if(!empty($this->password)){
				$this->password=htmlspecialchars(strip_tags($this->password));
				$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
				$stmt->bindParam(':password', $password_hash);
			}
	 
			$stmt->bindParam(':id', $this->id);
	 
			if($stmt->execute()){
				return true;
			}
	 	
		}
    
		function deleteUsuario(){
			$sqlQuery = "DELETE FROM ".$this->db_table." WHERE id = ?";
			$stmt = $this->conn->prepare($sqlQuery);
	
			$this->id=htmlspecialchars(strip_tags($this->id));
	
			$stmt->bindParam(1, $this->id);
	
			if($stmt->execute()){
				return true;
			}
			return false;
		}
  }
?>