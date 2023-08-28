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
	$estados= new Conductores($db);
	$stmt = $estados->getEstados();
	$estados_count = $stmt->rowCount();
	
	$estados_arr = array();
	$estados_arr["Estados"] = array();
	$estados_arr["EstadosCount"] = $estados_count;

	if($estados_count > 0){
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			extract($row);
			$c = array(
				"id" => $id,
				"descripcion" => $descripcion,
			);
			array_push($estados_arr["Estados"], $c);
		}
	}
	
	http_response_code(200);
	echo json_encode($estados_arr);

?>