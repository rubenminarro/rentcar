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
	$usuarios = new Usuarios($db);
	$stmt = $usuarios->getUsuarios();
	$usuariosCount = $stmt->rowCount();

	if($usuariosCount > 0){

		$usuariosArr = array();
		$usuariosArr["Usuarios"] = array();
		$usuariosArr["UsuariosCount"] = $usuariosCount;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$e = array(
				"id" => $id,
				"nombre" => $nombre,
				"apellido" => $apellido,
				"ci" => $ci,
				"usuario" => $usuario,
				"id_estado" => $id_estado,
				"fecha_creacion" => date("d/m/Y", strtotime($fecha_creacion)),
				"creado_por" => $creado_por,
				"modificado_por" => $modificado_por,
				"fecha_modificacion" => date("d/m/Y", strtotime($fecha_modificacion))
			);
			array_push($usuariosArr["Usuarios"], $e);
		}
		http_response_code(200);
		echo json_encode($usuariosArr);
	}
?>