<?php
require_once('classes/TuzobusApp.php');

$TB = new TuzobusApp();
if(!$TB->login->isUserLoggedin()) die('Acceso Negado');

if(isset($_GET)) extract($_GET);
if(isset($_POST)) extract($_POST);

switch ($action) {
	case 'change_password':
		$response = $TB->change_password($user_password, $user_password_new, $user_password_repeat);
		break;
	
	default:
		$response = array(
			'result'	=> 'error',
			'message'	=> 'Función Inválida'
			);
		break;
}

if(!isset($format) || $format == 'json'){
	echo json_encode($response);
}else{
	print_r($response);
}
?>