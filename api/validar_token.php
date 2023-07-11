<?php 
	
	//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	include_once '../config/core.php';
	include_once '../libs/php-jwt/src/BeforeValidException.php';
	include_once '../libs/php-jwt/src/ExpiredException.php';
	include_once '../libs/php-jwt/src/SignatureInvalidException.php';
	include_once '../libs/php-jwt/src/JWT.php';
	include_once '../libs/php-jwt/src/Key.php';
	use \Firebase\JWT\JWT;
	use Firebase\JWT\Key;

	$data = json_decode(file_get_contents("php://input"));
 
	$jwt=isset($data->jwt) ? $data->jwt : "";

	if($jwt){
 
    try {
        
			$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
			http_response_code(200);
			echo json_encode(array(
					"message" => "Acceso ortorgado.",
					"data" => $decoded->data
			));
 
    }catch (Exception $e){
 			
			http_response_code(401);
	 		echo json_encode(array(
				"message" => "Acceso denegado.",
				"error" => $e->getMessage()
			));
	}
	
}else{
 	http_response_code(401);
	echo json_encode(array("message" => "Acceso denegado."));
}


?>