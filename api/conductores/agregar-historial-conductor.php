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

	if(!empty($_POST['id_conductor']) && !empty($_POST['id_motivo']) && !empty($_POST['id_estado']) && !empty($_POST['creado_por'])){ 
	
		$conductor_historial->id_conductor = $_POST['id_conductor'];
		$conductor_historial->id_motivo = $_POST['id_motivo'];
		$conductor_historial->id_estado = $_POST['id_estado'];
		$conductor_historial->creado_por = $_POST['creado_por'];
		$conductor_historial->observacion = $_POST['observacion'];
		$conductor_historial->fecha_creacion = date('Y-m-d H:i:s');

		if($conductor_historial->agregarHistorial()){        
			http_response_code(201);         
			echo json_encode(array("mensaje" => "Se ha agregado el historial correctamente."));
		}else{         
			http_response_code(503);        
			echo json_encode(array("mensaje" => "No se ha agregado el historial correctamente."));
		}


	}else{
		http_response_code(400);    
		echo json_encode(array("mensaje" => "No se ha agregado el historial. Datos incompletos."));
	}
	
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