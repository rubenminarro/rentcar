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

	if(isset($_FILES['documento']['name']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['ci']) && isset($_POST['fec_nac']) && isset($_POST['id_estado'])){

		if(!$conductor->checkRegistroConductor()){        
			
			$extensiones_validas = array('jpeg','jpg','png');
			$img = $_FILES['documento']['name'];
			$tmp = $_FILES['documento']['tmp_name'];
			$size = $_FILES['documento']['size'];
			$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
			$documento = rand(100,1000000).'.'.$ext;
			$errorimg = $_FILES['documento']['error'];
			$path = $_SERVER['DOCUMENT_ROOT'].'/lista/assets/img/documentos/';
			$path = $path.strtolower($documento);

			if(in_array($ext, $extensiones_validas)){

				if($size < 3500000){

					if(move_uploaded_file($tmp,$path)){

						$conductor->nombre = $_POST['nombre'];
						$conductor->apellido = $_POST['apellido'];
						$conductor->ci = $_POST['ci'];
						$conductor->fec_nac = $_POST['fec_nac'];
						$conductor->id_estado = $_POST['id_estado'];
						$conductor->creado_por = 'rminarro';
						$conductor->fecha_creacion = date('Y-m-d H:i:s');
						$conductor->documento = $documento;
						$conductor->modificado_por = NULL;
						$conductor->fecha_modificacion = NULL;

						if($conductor->agregarConductor()){        
							http_response_code(200);         
							echo json_encode(array('status'=>1,'mensaje' => 'Se ha agregado el conductor correctamente.'));
						}else{
							unlink($path);
							http_response_code(200);    
							echo json_encode(array('status'=>0,'mensaje' => 'Hubo un error al grabar los datos del conductor, favor intentar de nuevo.'));
						}
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
		}else{
			http_response_code(200);    
			echo json_encode(array('status'=>0,'mensaje' => 'Ya existe un conductor registrado con ese Nro. de documento, favor intentar de nuevo.'));
		}
	}else{
		http_response_code(400);    
		echo json_encode(array('status'=>0,'mensaje' => 'Faltan campos obligatorios, favor intentar de nuevo.'));
	}
	
?>