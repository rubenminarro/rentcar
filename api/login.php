<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/Database.php';
	include_once '../class/Usuarios.php';

	include_once '../config/core.php';
	include_once '../libs/php-jwt/src/BeforeValidException.php';
	include_once '../libs/php-jwt/src/ExpiredException.php';
	include_once '../libs/php-jwt/src/SignatureInvalidException.php';
	include_once '../libs/php-jwt/src/JWT.php';
	use \Firebase\JWT\JWT;

	$database = new Database();
	$db = $database->obtenerConexion();
	$usuario = new Usuarios($db);

	$data = json_decode(file_get_contents("php://input"));

	$usuario->email = $data->email;
	$email_exists = $usuario->emailExists();

	if($email_exists && password_verify($data->password, $usuario->password)){

		$token = array(
      "iat" => $issued_at,
      "exp" => $expiration_time,
      "data" => array(
        "id" => $usuario->id,
        "nombre" => $usuario->nombre,
        "apellido" => $usuario->apellido,
        "email" => $usuario->email
      )
    );
 
    $jwt = JWT::encode($token, $key, 'HS256');

		http_response_code(200);
		setcookie('jwt', $jwt);
		echo json_encode(
      array(
        "message" => "Logueado correctamente.",
        "jwt" => $jwt
      )
    );
 
	}else{
 		http_response_code(401);
 		echo json_encode(array("message" => "No se ha podido loguear."));
}
?>