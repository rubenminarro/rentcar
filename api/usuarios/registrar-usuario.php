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
	include_once '../../class/Usuarios.php';
	
	$database = new Database();
	$db = $database->obtenerConexion();
	$usuario = new Usuarios($db);

	if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['ci']) && isset($_POST['usuario']) && isset($_POST['id_estado']) && isset($_POST['password']) && isset($_POST['confirmar_password'])){

		$usuario->ci = $_POST['ci'];

		if($usuario->checkRegistroUsuario() == 0){        
			
			$usuario->nombre = $_POST['nombre'];
			$usuario->apellido = $_POST['apellido'];
			$usuario->usuario = $_POST['usuario'];
			$usuario->id_estado = $_POST['id_estado'];
			$usuario->creado_por = 'rminarro';
			$usuario->fecha_creacion = date('Y-m-d H:i:s');
			$usuario->password = $_POST['password'];
			
			if($usuario->agregarUsuario()){        
				http_response_code(200);         
				echo json_encode(array('status'=>1,'mensaje' => 'Se ha agregado el usuario correctamente.'));
			}else{
				http_response_code(200);    
				echo json_encode(array('status'=>0,'mensaje' => 'Hubo un error al grabar los datos del usuario, favor intentar de nuevo.'));
			}
		}else{
			http_response_code(200);    
			echo json_encode(array('status'=>0,'mensaje' => 'Ya existe un usuario registrado con ese Nro. de documento, favor intentar de nuevo.'));
		}
	}else{
		http_response_code(400);    
		echo json_encode(array('status'=>0,'mensaje' => 'Faltan campos obligatorios, favor intentar de nuevo.'));
	}
	
?>