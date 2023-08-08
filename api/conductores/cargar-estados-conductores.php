<?php
	
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL);
	set_time_limit(0);

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	include_once '../../config/core.php';
	include_once '../../config/Database.php';
	include_once '../../class/Conductores.php';
	
	$database = new Database();
	$db = $database->obtenerConexion();
	$conductor_estados= new Conductores($db);
	$stmt = $conductor_estados->getEstados();
	$conductor_estados_count = $stmt->rowCount();
	
	$conductor_estados_arr = array();
	$conductor_estados_arr["ConductorEstados"] = array();
	$conductor_estados_arr["ConductorEstadosCount"] = $conductor_estados_count;

	if($conductor_estados_count > 0){
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			extract($row);
			$c = array(
				"id" => $id,
				"descripcion" => $descripcion,
			);
			array_push($conductor_estados_arr["ConductorEstados"], $c);
		}
	}
	
	http_response_code(200);
	echo json_encode($conductor_estados_arr);

?>