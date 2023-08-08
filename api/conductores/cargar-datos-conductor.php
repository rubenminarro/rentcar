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
	$conductorDatos = new Conductores($db);
	$conductorDatos->id = $_POST['id'];
	$stmt = $conductorDatos->getDatosConductor();
	$conductorCount = $stmt->rowCount();

	if($conductorCount > 0){
					
		$conductorArr = array();
		$conductorArr["Conductor"] = array();
		$conductorArr["ConductorCount"] = $conductorCount;
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$e = array(
				"id" => $id,
				"nombre" => $nombre,
				"apellido" => $apellido,
				"ci" => $ci,
				"id_estado" => $id_estado,
				"fec_nac" => $fec_nac,
				"documento" => $documento
			);
			array_push($conductorArr["Conductor"], $e);
		}
		http_response_code(200);
		echo json_encode($conductorArr);
	}else{
		http_response_code(200);
		echo json_encode(array('status'=>0,'mensaje' => 'No se han encontrado datos del conductor, favor intentar de nuevo.'));
	}
	
?>