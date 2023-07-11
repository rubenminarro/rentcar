<?php
	date_default_timezone_set('America/Santiago');
	$url_val_token = $_SERVER['SERVER_NAME']."/idesa/api/validar_token.php";
	$key = "A185234CADAFC6313A85B95C91709603D9A58426F2D92B7E90AE8EACDD1D8FBE";
	$issued_at = time();
	$expiration_time = $issued_at + (60 * 60);
	
?>