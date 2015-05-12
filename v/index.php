<?php error_reporting(0);
require_once('../classes/TuzobusApp.php');

$V =  new TuzobusApp();

if(isset($_GET)) extract($_GET);
if(isset($_POST)) extract($_POST);

switch ($action) {
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