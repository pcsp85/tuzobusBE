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

	case 'save_dates':
		$err = '';
		if($TB->update_option('begin_date',$begin_date) == false) $err .= 'Error al guardar';
		if($TB->update_option('end_date',$end_date) == false) $err .= 'Error al guardar';
		if($err==''){
			$response = array(
				'result' => 'success',
				'message' => 'La información se guardo con éxito'
				);
		}else{
			$response = array(
				'result' => 'error',
				'message' => 'Error al guardar, intentalo de nuevo'
				);
		}
		break;

	case 'save_store':
		$err = '';
		if($TB->update_option($so.'_store',$store) == false) $err .= 'Error al guardar';
		if($TB->update_option($so.'_rank',$rank) == false) $err .= 'Error al guardar';
		if($err==''){
			$response = array(
				'result' => 'success',
				'message' => 'La información se guardo con éxito'
				);
		}else{
			$response = array(
				'result' => 'error',
				'message' => 'Error al guardar, intentalo de nuevo'
				);
		}
		break;

	case 'get_dates':
		$response = array(
			'begin_date'	=> $TB->get_option('begin_date'),
			'end_date'		=> $TB->get_option('end_date')
			);
		break;

	case 'invitations':
		$params = array(
			'search'	=> isset($search) && $search!=''? $search : false,
			'npag'		=> isset($npag) && $npag!='' ? $npag : false,
			);
		$response = $TB->renderPartial('parts/table', false, $TB->invitations($params));
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
	echo($response);
}
?>