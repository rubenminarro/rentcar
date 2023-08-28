<?php
	
	class Usuarios{
        
		private $conn;
		private $db_table = "conductores.Usuarios";
		
		public $id;
		public $nombre;
		public $apellido;
		public $usuario;
		public $id_estado;
		public $ci;
		public $password;
		public $fecha_creacion;
		public $creado_por;
		public $fecha_modificacion;
		public $modificado_por;

		public function __construct($db){
			$this->conn = $db;
		}
		
		public function getUsuarios(){
			$sqlQuery = "SELECT id, nombre, apellido, ci, usuario, id_estado, creado_por, fecha_creacion, modificado_por, fecha_modificacion FROM " .$this->db_table. " ORDER BY id_estado ASC";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
		}

		public function cambiarEstado(){
			$sqlQuery = "UPDATE ".$this->db_table." SET id_estado = :id_estado, fecha_modificacion = :fecha_modificacion, modificado_por = :modificado_por WHERE id = :id";
			$stmt = $this->conn->prepare($sqlQuery);
	
			$this->id=htmlspecialchars(strip_tags($this->id));
			$this->id_estado=htmlspecialchars(strip_tags($this->id_estado));
			$this->fecha_modificacion=htmlspecialchars(strip_tags($this->fecha_modificacion));
			$this->modificado_por=htmlspecialchars(strip_tags($this->modificado_por));
			
			$stmt->bindParam(":id", $this->id);
			$stmt->bindParam(":id_estado", $this->id_estado);
			$stmt->bindParam(":fecha_modificacion", $this->fecha_modificacion);
			$stmt->bindParam(":modificado_por", $this->modificado_por);
			
			$stmt->execute();
			
			return $stmt;
			
    	}
		
		public function agregarUsuario(){
			
			$sqlQuery = "INSERT INTO ".$this->db_table. " SET nombre = :nombre, apellido = :apellido, ci = :ci, usuario = :usuario, id_estado = :id_estado, password = :password, creado_por = :creado_por, fecha_creacion = :fecha_creacion, modificado_por = :modificado_por, fecha_modificacion = :fecha_modificacion";

			$stmt = $this->conn->prepare($sqlQuery);

			$this->nombre=htmlspecialchars(strip_tags($this->nombre));
			$this->apellido=htmlspecialchars(strip_tags($this->apellido));
			$this->ci=htmlspecialchars(strip_tags($this->ci));
			$this->usuario=htmlspecialchars(strip_tags($this->usuario));
			$this->id_estado=htmlspecialchars(strip_tags($this->id_estado));
			$this->password=htmlspecialchars(strip_tags($this->password));
			$this->creado_por=htmlspecialchars(strip_tags($this->creado_por));
			$this->fecha_creacion=htmlspecialchars(strip_tags($this->fecha_creacion));
			$this->modificado_por=htmlspecialchars(strip_tags($this->modificado_por));
			$this->fecha_modificacion=NULL;
			
			$stmt->bindParam(':nombre', $this->nombre);
			$stmt->bindParam(':apellido', $this->apellido);
			$stmt->bindParam(':ci', $this->ci);
			$stmt->bindParam(':usuario', $this->usuario);
			$stmt->bindParam(":id_estado", $this->id_estado);
			$stmt->bindParam(':creado_por', $this->creado_por);
			$stmt->bindParam(':fecha_creacion', $this->fecha_creacion);
			$stmt->bindParam(':modificado_por', $this->modificado_por);
			$stmt->bindParam(":fecha_modificacion", $this->fecha_modificacion);

			$password = password_hash($this->password, PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password);

			if($stmt->execute()){
				return true;
			}else{
				return $stmt->errorInfo();
			}
		}
		
		public function actualizarUsuario(){

			$password_set=!empty($this->password) ? ", password = :password" : "";
 
			$sqlQuery = "UPDATE ".$this->db_table. " SET nombre = :nombre, apellido = :apellido, ci = :ci, usuario = :usuario, id_estado = :id_estado, modificado_por = :modificado_por, fecha_modificacion = :fecha_modificacion {$password_set} WHERE id = :id";
	 
			$stmt = $this->conn->prepare($sqlQuery);
	 
			$this->nombre=htmlspecialchars(strip_tags($this->nombre));
			$this->apellido=htmlspecialchars(strip_tags($this->apellido));
			$this->ci=htmlspecialchars(strip_tags($this->ci));
			$this->usuario=htmlspecialchars(strip_tags($this->usuario));
			$this->id_estado=htmlspecialchars(strip_tags($this->id_estado));
			$this->modificado_por=htmlspecialchars(strip_tags($this->modificado_por));
			$this->fecha_modificacion=htmlspecialchars(strip_tags($this->fecha_modificacion));
			
			$stmt->bindParam(':nombre', $this->nombre);
			$stmt->bindParam(':apellido', $this->apellido);
			$stmt->bindParam(':ci', $this->ci);
			$stmt->bindParam(':usuario', $this->usuario);
			$stmt->bindParam(":id_estado", $this->id_estado);
			$stmt->bindParam(':modificado_por', $this->modificado_por);
			$stmt->bindParam(":fecha_modificacion", $this->fecha_modificacion);
	 
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
		
		public function getDatosUsuario(){

			$sqlQuery = "SELECT id, nombre, apellido, ci, id_estado, usuario, password FROM " .$this->db_table. " WHERE id = :id";
			
			$stmt = $this->conn->prepare($sqlQuery);
			
			$this->id=htmlspecialchars(strip_tags($this->id));
			$stmt->bindParam(":id", $this->id);

			$stmt->execute();
			
			return $stmt;
		}

		public function checkRegistroUsuario(){

			$sqlQuery = "SELECT ci FROM " .$this->db_table. " WHERE ci = :ci";
			
			$stmt = $this->conn->prepare($sqlQuery);
			
			$this->ci=htmlspecialchars(strip_tags($this->ci));
			$stmt->bindParam(":ci", $this->ci);

			if($stmt->execute() == true){
				return $stmt->rowCount();
			}else{
				return false;
			}

		}
    }
?>