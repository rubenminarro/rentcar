<?php
	
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
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
			$usuarios = new Usuarios($db);
			$stmt = $usuarios->getUsuarios();
			$usuariosCount = $stmt->rowCount();

			if($usuariosCount > 0){
					
				$usuarioArr = array();
				$usuarioArr["Usuarios"] = array();
				$usuarioArr["usuariosCount"] = $usuariosCount;
					
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					$e = array(
						"id" => $id,
						"nombre" => $nombre,
						"apellido" => $apellido,
						"email" => $email,
						"fecha_creacion" => $fecha_creacion,
						"fecha_modificacion" => $fecha_modificacion
					);
					array_push($usuarioArr["Usuarios"], $e);
				}
				http_response_code(200);
				echo json_encode($usuarioArr);
			}else{
				http_response_code(404);
				echo json_encode(
					array("mensaje" => "No se han encontrado datos.")
				);
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