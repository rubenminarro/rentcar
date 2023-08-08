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

	if(isset($_POST['id']) && isset($_POST['id_estado']) && isset($_POST['modificado_por'])){ 
	
		$usuario->id = $_POST['id'];
		$usuario->id_estado = $_POST['id_estado'];
		$usuario->modificado_por = $_POST['modificado_por'];
		$usuario->fecha_modificacion = date('Y-m-d H:i:s');

		if($usuario->cambiarEstado()){        
			http_response_code(200);         
			echo json_encode(array('status'=>1, 'mensaje'=>'Se ha actualizado el estado del usuario.'));
		}else{         
			http_response_code(200);        
			echo json_encode(array('status'=>0, 'mensaje'=>'No se ha podido actualizar el estado del usuario, favor intentar de nuevo.'));
		}
		
	}else{
		http_response_code(200);    
		echo json_encode(array('status'=>0,'mensaje' => 'Faltan campos obligatorios, favor intentar de nuevo.'));
	}

?>