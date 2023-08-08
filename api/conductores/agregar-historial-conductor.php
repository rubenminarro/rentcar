<?php
	
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL);
	set_time_limit(0);

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../../config/core.php';
	include_once '../../config/Database.php';
	include_once '../../class/Conductores.php';
	
	$database = new Database();
	$db = $database->obtenerConexion();
	$conductor_historial = new Conductores($db);

	if(isset($_POST['id_conductor']) && isset($_POST['id_motivo']) && isset($_POST['id_estado']) && isset($_POST['creado_por'])){ 
	
		$conductor_historial->id_conductor = $_POST['id_conductor'];
		$conductor_historial->id_motivo = $_POST['id_motivo'];
		$conductor_historial->id_estado = $_POST['id_estado'];
		$conductor_historial->creado_por = $_POST['creado_por'];
		$conductor_historial->observacion = $_POST['observacion'];
		$conductor_historial->fecha_creacion = date('Y-m-d H:i:s');

		if($conductor_historial->agregarHistorial()){
		  http_response_code(200);         
			echo json_encode(array('status'=>1,'mensaje' => 'Se ha agregado el historial correctamente.'));  
		}else{         
			http_response_code(200);        
			echo json_encode(array('status'=>0,'mensaje' => 'Hubo un error al grabar el historial del conductor, favor intentar de nuevo.'));
		}
	}else{
		http_response_code(200);    
		echo json_encode(array('status'=>0,'mensaje' => 'Faltan campos obligatorios, favor intentar de nuevo.'));
	}
	
?>