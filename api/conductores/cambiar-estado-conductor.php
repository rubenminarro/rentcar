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
	$conductor = new Conductores($db);

	if(!empty($_POST['id_conductor']) && !empty($_POST['id_estado']) && !empty($_POST['modificado_por'])){ 
	
		$conductor->id_conductor = $_POST['id_conductor'];
		$conductor->id_estado = $_POST['id_estado'];
		$conductor->modificado_por = $_POST['modificado_por'];
		$conductor->fecha_modificacion = date('Y-m-d H:i:s');

		if($conductor->cambiarEstado()){        
			http_response_code(201);         
			echo json_encode(array("status"=>"ok", "mensaje"=>"Se ha actualizado el estado del conductor."));
		}else{         
			http_response_code(503);        
			echo json_encode(array("status"=>"error", "mensaje"=>"No se ha podido actualizar el estado del conductor."));
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