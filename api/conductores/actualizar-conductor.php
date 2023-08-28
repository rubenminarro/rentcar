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

	if(!empty($_FILES['documento-nuevo']['name'])){

		$extensiones_validas = array('jpeg','jpg','png');
		$img = $_FILES['documento-nuevo']['name'];
		$tmp = $_FILES['documento-nuevo']['tmp_name'];
		$size = $_FILES['documento-nuevo']['size'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$documento = rand(100,1000000).'.'.$ext;
		$errorimg = $_FILES['documento-nuevo']['error'];
		$path = $_SERVER['DOCUMENT_ROOT'].'/lista/assets/img/documentos/';
		$path = $path.strtolower($documento);

		if(in_array($ext, $extensiones_validas)){
			if($size < 3500000){
				if(move_uploaded_file($tmp,$path)){
					$conductor->documento = $documento;
				}else{
					http_response_code(200);    
					echo json_encode(array('status'=>0,'mensaje' => 'Hubo un error al grabar el documento, favor intentar de nuevo.'));
				}
			}else{
				http_response_code(200);    
				echo json_encode(array('status'=>0,'mensaje' => 'El tamaño del documento es mayor al soportado, favor intentar de nuevo.'));
			}
		}else{
			http_response_code(200);    
			echo json_encode(array('status'=>0,'mensaje' => 'La extensión del documentos es inválida, favor intentar de nuevo.'));
		}
	}

	if(isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['ci']) && isset($_POST['fec_nac']) && isset($_POST['id_estado'])){

		$conductor->id = $_POST['id'];
		$conductor->nombre = $_POST['nombre'];
		$conductor->apellido = $_POST['apellido'];
		$conductor->ci = $_POST['ci'];
		$conductor->fec_nac = $_POST['fec_nac'];
		$conductor->id_estado = $_POST['id_estado'];
		$conductor->modificado_por = 'rminarro';
		$conductor->fecha_modificacion = date("Y-m-d H:i:s");

		if(empty($_FILES['documento-nuevo']['name'])){
			$conductor->documento = $_POST['documento-anterior'];
		}

		if($conductor->actualizarConductor()){        
			http_response_code(200);         
			echo json_encode(array('status'=>1,'mensaje' => 'Se ha actualizado el conductor correctamente.','id'=>$conductor->id));
		}else{
			http_response_code(200);  
			echo json_encode(array('status'=>0,'mensaje' => 'Hubo un error al actualizar los datos del conductor, favor intentar de nuevo.'));
		}
	}else{
		http_response_code(404);    
		echo json_encode(array('status'=>0,'mensaje' => 'Faltan campos obligatorios, favor intentar de nuevo.'));
	}
?>