<?php error_reporting(0);
require_once('../classes/TuzobusApp.php');

$V =  new TuzobusApp();

if(isset($_GET)) extract($_GET);
if(isset($_POST)) extract($_POST);

switch ($action) {
	case 'activation_dates':
		$response = array(
			'begin_date'	=> $V->get_option('begin_date'),
			'end_date'		=> $V->get_option('end_date')
			);
		break;

	case 'activate_App':
		$response = $V->activate_App($code, $device, $conection);
		break;

	case 'get_ads':
		$response = $V->get_ads();
		break;
	
	default:
		$response = array(
			'result' => 'TuzobusApp',
			'data' => array(
				'v' => '1.0.0',
				'url' => $_SERVER['HTTP_HOST']
				)
			);
		break;
}

echo json_encode($response);