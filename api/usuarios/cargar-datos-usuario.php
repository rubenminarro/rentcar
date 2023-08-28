<?php
	
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL);
	set_time_limit(0);

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	include_once '../../config/core.php';
	include_once '../../config/Database.php';
	include_once '../../class/Usuarios.php';

	$database = new Database();
	$db = $database->obtenerConexion();
	$usuarioDatos = new Usuarios($db);
	$usuarioDatos->id = $_POST['id'];
	$stmt = $usuarioDatos->getDatosUsuario();
	$usuarioCount = $stmt->rowCount();

	if($usuarioCount > 0){
					
		$usuarioArr = array();
		$usuarioArr["Usuario"] = array();
		$usuarioArr["UsuarioCount"] = $usuarioCount;
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$e = array(
				"id" => $id,
				"nombre" => $nombre,
				"apellido" => $apellido,
				"ci" => $ci,
				"id_estado" => $id_estado,
				"usuario" => $usuario
			);
			array_push($usuarioArr["Usuario"], $e);
		}
		http_response_code(200);
		echo json_encode($usuarioArr);
	}else{
		http_response_code(200);
		echo json_encode(array('status'=>0,'mensaje' => 'No se han encontrado datos del usuario, favor intentar de nuevo.'));
	}
	
?>