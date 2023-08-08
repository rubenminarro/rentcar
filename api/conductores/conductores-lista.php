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
	$conductores = new Conductores($db);
	$stmt = $conductores->getConductores();
	$conductoresCount = $stmt->rowCount();

	if($conductoresCount > 0){
					
		$conductoresArr = array();
		$conductoresArr["Conductores"] = array();
		$conductoresArr["ConductoresCount"] = $conductoresCount;
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$e = array(
				"id" => $id,
				"nombre" => $nombre,
				"apellido" => $apellido,
				"ci" => $ci,
				"id_estado" => $id_estado,
				"fecha_creacion" => $fecha_creacion,
				"creado_por" => $creado_por,
				"fecha_modificacion" => $fecha_modificacion,
				"modificado_por" => $modificado_por
			);
			array_push($conductoresArr["Conductores"], $e);
		}
		http_response_code(200);
		echo json_encode($conductoresArr);
	}
?>