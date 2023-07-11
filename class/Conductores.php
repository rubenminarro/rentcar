<?php
  
	class Conductores{
        
		private $conn;
		private $db_table = "conductores.Conductores";
		private $db_table_historial_conductores = "conductores.HistorialConductores";
		private $db_table_motivos = "conductores.Motivos";
		
		public $id;
		public $nombre;
		public $apellido;
		public $ci;
		public $id_estado;
		public $fecha_creacion;
		public $creado_por;
		public $fecha_modificacion;
		public $modificado_por;
		public $id_conductor;
		public $id_motivo;
		public $observacion;
		public $descripcion;

		public function __construct($db){
			$this->conn = $db;
		}
		
		public function getConductores(){
			
			$sqlQuery = "SELECT id, nombre, apellido, ci, id_estado, fecha_creacion, creado_por, fecha_modificacion, modificado_por FROM " .$this->db_table. "";
			$stmt = $this->conn->prepare($sqlQuery);
			
			$stmt->execute();
			
			return $stmt;
		}

		public function getConductoresHistorial(){
			
			$sqlQuery = "SELECT c.id,CONCAT(c.nombre,' ',c.apellido) as nombre_completo ,m.descripcion as motivo, hc.observacion, hc.creado_por, hc.fecha_creacion, hc.modificado_por, hc.fecha_modificacion  FROM ".$this->db_table." as c inner join ".$this->db_table_historial_conductores." as hc on hc.id_conductor = c.id
			inner join conductores.Motivos as m on m.id = hc.id_motivo WHERE hc.id_estado = 1 and hc.id_conductor = :id";
			$stmt = $this->conn->prepare($sqlQuery);

			$this->id=htmlspecialchars(strip_tags($this->id));
			$stmt->bindParam(":id", $this->id);
			
			$stmt->execute();
			
			return $stmt;
		}

		public function agregarHistorial(){
			
			$sqlQuery = "INSERT INTO ".$this->db_table_historial_conductores." SET id_conductor = :id_conductor, id_motivo = :id_motivo, id_estado = :id_estado, creado_por = :creado_por, observacion = :observacion, fecha_creacion = :fecha_creacion";
		
			$stmt = $this->conn->prepare($sqlQuery);

			$this->id_conductor=htmlspecialchars(strip_tags($this->id_conductor));
			$this->id_motivo=htmlspecialchars(strip_tags($this->id_motivo));
			$this->id_estado=htmlspecialchars(strip_tags($this->id_estado));
			$this->creado_por=htmlspecialchars(strip_tags($this->creado_por));
			$this->observacion=htmlspecialchars(strip_tags($this->observacion));
			$this->fecha_creacion=htmlspecialchars(strip_tags($this->fecha_creacion));
		
			$stmt->bindParam(":id_conductor", $this->id_conductor);
			$stmt->bindParam(":id_motivo", $this->id_motivo);
			$stmt->bindParam(":id_estado", $this->id_estado);
			$stmt->bindParam(":creado_por", $this->creado_por);
			$stmt->bindParam(":observacion", $this->observacion);
			$stmt->bindParam(":fecha_creacion", $this->fecha_creacion);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}

		}

		public function getMotivos(){
			$sqlQuery = "SELECT id, descripcion FROM ".$this->db_table_motivos." ORDER BY descripcion ASC";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
		}

		public function cambiarEstado(){
			$sqlQuery = "UPDATE ".$this->db_table." SET id_estado = :id_estado, fecha_modificacion = :fecha_modificacion, modificado_por = :modificado_por WHERE id = :id_conductor";
			$stmt = $this->conn->prepare($sqlQuery);
	
			$this->id_conductor=htmlspecialchars(strip_tags($this->id_conductor));
			$this->id_estado=htmlspecialchars(strip_tags($this->id_estado));
			$this->fecha_modificacion=htmlspecialchars(strip_tags($this->fecha_modificacion));
			$this->modificado_por=htmlspecialchars(strip_tags($this->modificado_por));
			
			$stmt->bindParam(":id_conductor", $this->id_conductor);
			$stmt->bindParam(":id_estado", $this->id_estado);
			$stmt->bindParam(":fecha_modificacion", $this->fecha_modificacion);
			$stmt->bindParam(":modificado_por", $this->modificado_por);
			
			if($stmt->execute()){
				return true;
			}
			return false;
    	}
    
		/*
    
		public function updateEmpleado(){

			UPDATE conductores.Conductores
SET nombre='', apellido='', ci='', id_estado=0, fecha_creacion='', creado_por='', fecha_modificacion='', modificado_por=''
WHERE id=0;


			$sqlQuery = "UPDATE ".$this->db_table." SET nombre = :nombre, email = :email, designacion = :designacion, fecha_creacion = :fecha_creacion WHERE id = :id";
			$stmt = $this->conn->prepare($sqlQuery);
	
			$this->id=htmlspecialchars(strip_tags($this->id));
			$this->nombre=htmlspecialchars(strip_tags($this->nombre));
			$this->email=htmlspecialchars(strip_tags($this->email));
			$this->designacion=htmlspecialchars(strip_tags($this->designacion));
			$this->fecha_creacion=htmlspecialchars(strip_tags($this->fecha_creacion));
			
			$stmt->bindParam(":id", $this->id);
			$stmt->bindParam(":nombre", $this->nombre);
			$stmt->bindParam(":email", $this->email);
			$stmt->bindParam(":designacion", $this->designacion);
			$stmt->bindParam(":fecha_creacion", $this->fecha_creacion);
			
			if($stmt->execute()){
				return true;
			}
			return false;
    	}*/
  }
?>