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
	$conductor_historial = new Conductores($db);
	$conductor_historial->id = $_POST['id'];
	$stmt = $conductor_historial->getConductoresHistorial();
	$conductor_historial_count = $stmt->rowCount();

	$conductor_historial_arr = array();
	$conductor_historial_arr["ConductorHistorial"] = array();
	$conductor_historial_arr["ConductorHistorialCount"] = $conductor_historial_count;

	if($conductor_historial_count > 0){
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			extract($row);

			$c = array(
				"id" => $id,
				"nombre_completo" => $nombre_completo,
				"motivo" => $motivo,
				"observacion" => $observacion,
				"fecha_creacion" => date("d/m/Y", strtotime($fecha_creacion)),
				"creado_por" => $creado_por
			);
			array_push($conductor_historial_arr["ConductorHistorial"], $c);
		}
	}
	
	http_response_code(200);
	echo json_encode($conductor_historial_arr);
	
?>