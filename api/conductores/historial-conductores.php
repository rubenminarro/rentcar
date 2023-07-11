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
				"creado_por" => $creado_por,
				"fecha_modificacion" => (($fecha_modificacion) ? date("d/m/Y", strtotime($fecha_modificacion)) : ''),
				"modificado_por" => (($modificado_por) ? $modificado_por : '')
			);
			array_push($conductor_historial_arr["ConductorHistorial"], $c);
		}
	}
	
	http_response_code(200);
	echo json_encode($conductor_historial_arr);
	
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