<?php

require_once 'include/Config.php';
require_once 'include/function.php';

$url = ROOT_PATH.'v1/login';


if (isset($_POST['email']))
{
	$response = array();
	$response['error'] = true;
	

	$url = ROOT_PATH.'v1/login';
	$tzOffset = $_POST["tzOffset"];
	$data = array(
        'email' => $_POST["email"],
        'password' => $_POST["password"]
	);
	$data=json_encode($data);
	$response = curl_post_call($url,$data);
	$response = json_decode($response);
	$message = $response->message;
	//echo $response;
	if($message=='You are successfully login')
	{
		@session_start();
		$_SESSION['UserRole'] = $response->user_role;
		//$_SESSION['UserName'] = $response->first_name.' '.$response->last_name;
		$_SESSION['UserId'] = $response->user_id;
		$_SESSION['ApiKey'] = $response->api_key;
		$_SESSION['OrgName'] = $response->organisation_name;
		$_SESSION['Postcode'] = $response->postcode;
		$_SESSION['tzOffset'] = $tzOffset;
		
		echo $response->user_role;
		
		/*if($response->user_role==0){
			header('Location: admin/index.php');
		} 
		elseif($response->user_role==2){
			header('Location: serviceprovider/index.php');
		}
		elseif($response->user_role==3){
			header('Location: residence/index.php');
		}*/
	}
	else
	{
		echo $message;
		//$response['message'] = $message;
		//echo json_encode($response);
	}
}

?>