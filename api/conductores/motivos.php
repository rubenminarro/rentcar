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
	$conductor_motivos= new Conductores($db);
	$stmt = $conductor_motivos->getMotivos();
	$conductor_motivos_count = $stmt->rowCount();
	
	$conductor_motivos_arr = array();
	$conductor_motivos_arr["ConductorMotivos"] = array();
	$conductor_motivos_arr["ConductorMotivosCount"] = $conductor_motivos_count;

	if($conductor_motivos_count > 0){
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			extract($row);
			$c = array(
				"id" => $id,
				"descripcion" => $descripcion,
			);
			array_push($conductor_motivos_arr["ConductorMotivos"], $c);
		}
	}
	
	http_response_code(200);
	echo json_encode($conductor_motivos_arr);
	
	/*if (isset($_COOKIE['jwt'])) {

		$handle = curl_init();
		$data_token = json_encode(array(
			'jwt' => $_COOKIE['jwt']
		));
		curl_setopt_array($handle,
			array(
				CURLOPT_URL => $url_val_token,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $data_token,
				CURLOPT_RETURNTRANSFER => true,
			)
		);
		$data_token = curl_exec($handle);
		curl_close($handle);
		
		$data_token = json_decode($data_token);

		if(isset($data_token->data->id)){
	
		}else{
			http_response_code(400);
			echo json_encode(array("mensaje" => "Token inválido."));
		}
	}else{
		http_response_code(400);
		echo json_encode(array("mensaje" => "No está logueado."));
	}*/
	
	
?>