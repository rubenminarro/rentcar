<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	include_once '../../config/core.php';
	include_once '../../config/Database.php';
	include_once '../../class/Usuarios.php';

	if (isset($_COOKIE['jwt'])) {

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
			
			$database = new Database();
			$db = $database->obtenerConexion();
			$usuario = new Usuarios($db);

			$data = json_decode(file_get_contents("php://input"));

			if(!empty($data->id)){
	
				$usuario->id = $data->id;
				
				if($usuario->deleteUsuario()){
					http_response_code(201);         
					echo json_encode(array("mensaje" => "El usuario se ha borrado correctamente."));
				}else{         
					http_response_code(503);        
					echo json_encode(array("mensaje" => "No se pudo borrar el usuario."));
				}
		
			}else{
				http_response_code(400);
				echo json_encode(array("mensaje" => "No se pudo borrar el usuario. Datos incompletos."));
			}

		}else{
			http_response_code(400);
			echo json_encode(array("mensaje" => "Token inválido."));
		}
	}else{
		http_response_code(400);
		echo json_encode(array("mensaje" => "No está logueado."));
	}

?>