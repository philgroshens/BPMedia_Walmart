<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', 'api.log');




$method = $_SERVER['REQUEST_METHOD'];
$apikey = 'TigddW91225KHB93XWrg5ty2nv8lsUHd';

require_once('call.php');


	switch($method) {


		case 'PUT':
			
			header("HTTP/1.1 200 OK");
			$_PUT = array();
			$request = file_get_contents('php://input');
			$exploded = explode('&', $request); 
			foreach($exploded as $pair) { 
                $item = explode('=', $pair); 
                if(count($item) == 2) { 
                   $_PUT[urldecode($item[0])] = urldecode($item[1]); 
                } 
            } 


			error_log("Cleaned PUT Data: ".print_r($_PUT));

			$auth = $_PUT['key'];
			$sku = $_PUT['sku'];
			$qty = $_PUT['qty'];

			$_auth = md5(md5($sku.md5($apikey)));
			

				if($auth != $_auth) {
					break;
				} else {
				
					
					
			
			
			

			error_log("Sku: ".$sku."  ->  Qty: ".$qty);
			$api = new WalmartSync();
			$result = $api->update($sku, $qty);

			
			return $result;
			}
			
			break;

		case 'GET':
			header("HTTP/1.1 405 Method Not Allowed");
			
			break;	
		case 'POST':
		header("HTTP/1.1 405 Method Not Allowed");

		break;
		default:
		header("HTTP/1.1 405 Method Not Allowed");
		break;
}



