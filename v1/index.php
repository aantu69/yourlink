<?php
require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$user_id = NULL;

$app->contentType('application/json');

//Login
$app->post('/login', 'Login');
$app->post('/applogin', 'AppLogin');

//Registration
$app->post('/users', 'AddAdmin');
$app->post('/appregistration', 'AppRegistration');
$app->post('/registration', 'Registration');
$app->post('/changePassword', 'authenticate', 'ChangePassword');
$app->post('/changeEmail', 'authenticate', 'ChangeEmail');
$app->post('/forgotPassword', 'ForgotPassword');
$app->post('/activateForgotPassword', 'ActivateForgotPassword');

$app->post('/manageLike', 'authenticate', 'ManageLike');

//Insert data
$app->post('/salutations', 'authenticate', 'AddSalutation');
$app->post('/countries', 'authenticate', 'AddCountry');
$app->post('/states', 'authenticate', 'AddState');
$app->post('/postcodes', 'authenticate', 'AddPostcode');
$app->post('/suburbs', 'authenticate', 'AddSuburb');
$app->post('/categories', 'authenticate', 'AddCategory');
$app->post('/levelOneClass', 'authenticate', 'AddLevelOneClass');
$app->post('/addFeedbackCategory', 'authenticate', 'AddFeedbackCategory');
$app->post('/addFeedback', 'authenticate', 'AddFeedback');

//Update database
$app->post('/users/:id', 'authenticate', 'UpdateAdmin');
$app->post('/salutations/:id', 'authenticate', 'UpdateSalutation');
$app->post('/countries/:id', 'authenticate', 'UpdateCountry');
$app->post('/states/:id', 'authenticate', 'UpdateState');
$app->post('/postcodes/:id', 'authenticate', 'UpdatePostcode');
$app->post('/suburbs/:id', 'authenticate', 'UpdateSuburb');
$app->post('/categories/:id', 'authenticate', 'UpdateCategory');
$app->post('/levelOneClass/:id', 'authenticate', 'UpdateLevelOneClass');
$app->post('/updateProfile', 'authenticate', 'UpdateProfile');
$app->post('/updateAppProfile', 'authenticate', 'UpdateAppProfile');
$app->post('/updateProfilePicture', 'authenticate', 'UpdateProfilePicture');
$app->post('/updateFeedbackCategory/:id', 'authenticate', 'UpdateFeedbackCategory');

$app->post('/unfriendFnfs', 'authenticate', 'UnfriendFnfs');
$app->post('/fnfRequestAcceptOrDecline', 'authenticate', 'FnfRequestAcceptOrDecline');

//Retrieve data
$app->get('/users/:user_role', 'authenticate', 'GetUsers');
$app->get('/salutations', 'authenticate', 'GetSalutations');
$app->get('/salutationslist', 'GetSalutations');
$app->get('/countries', 'authenticate', 'GetCountries');
$app->get('/countrieslist', 'GetCountries');
$app->get('/states', 'authenticate', 'GetStates');
$app->get('/postcodes', 'authenticate', 'GetPostcodes');
$app->get('/suburbs', 'authenticate', 'GetSuburbs');
$app->get('/categories', 'authenticate', 'GetCategories');
$app->get('/category', 'GetCategories');
$app->get('/levelOneClass', 'GetLevelOneClasses');
$app->get('/levelOneClasses', 'authenticate', 'GetLevelOneClasses');
$app->get('/getFeedbackCategories', 'authenticate', 'GetFeedbackCategories');
$app->get('/getFeedbacks', 'authenticate', 'GetFeedbacks');

$app->get('/relationaldata', 'authenticate', 'GetRelationalData');
$app->get('/relationaldatalist', 'GetRelationalData');
$app->get('/spsAndResidences/:postcode/:user_role', 'GetSpsAndResidences');
$app->get('/getSps/:user_id/:postcode', 'GetSps');

$app->get('/getCurrentLinksFavoured/:user_id', 'GetCurrentLinksFavoured');

//$app->get('/getAllSps/:user_id', 'GetAllSps');
$app->get('/getSpsForRes/:user_id/:postcode', 'GetSpsForRes');
$app->get('/searchSpsForRes/:user_id/:query', 'SearchSpsForRes');

$app->get('/getLevelOneWithUnreadMsg/:app_user_id/:timestamp', 'authenticate', 'GetLevelOneWithUnreadMsg');
$app->get('/getFnfWithUnreadMsgForApp/:app_user_id/:timestamp', 'authenticate', 'GetFnfWithUnreadMsgForApp');
$app->get('/getSpsWithUnreadMsgForApp/:category_id/:app_user_id/:timestamp', 'authenticate', 'GetSpsWithUnreadMsgForApp');
$app->get('/getAssignedSpsBroadcastOrIndividualForRes/:msg_type/:res_user_id', 'authenticate', 'GetAssignedSpsBroadcastOrIndividualForRes');
$app->get('/getAssignedIndividualsMsgForRes/:res_user_id', 'authenticate', 'GetAssignedIndividualsMsgForRes');
$app->get('/getResidences/:user_id/:postcode', 'GetResidences');
$app->get('/getAssignedResidenceForSp/:sp_id', 'authenticate', 'GetAssignedResidenceForSp');
$app->get('/getAssignedSpsForRes/:res_id', 'authenticate', 'GetAssignedSpsForRes');
$app->get('/getAssignedIndividualsForRes/:res_id', 'authenticate', 'GetAssignedIndividualsForRes');

//Retrive conditional data
$app->get('/users/:id', 'authenticate', 'GetAdmin');
$app->get('/getUserInfo/:id', 'authenticate', 'GetUserInfo');
$app->get('/salutations/:id', 'authenticate', 'GetSalutation');
$app->get('/countries/:id', 'authenticate', 'GetCountry');
$app->get('/states/:id', 'authenticate', 'GetState');
$app->get('/postcodes/:id', 'authenticate', 'GetPostcode');
$app->get('/suburbs/:id', 'authenticate', 'GetSuburb');
$app->get('/categories/:id', 'authenticate', 'GetCategory');
$app->get('/levelOneClass/:id', 'authenticate', 'GetLevelOneClass');
$app->get('/getFeedbackCategory/:id', 'authenticate', 'GetFeedbackCategory');
$app->get('/getResidencePostcodeWise/:postcode', 'authenticate', 'GetResidencePostcodeWise');

$app->get('/statesofcountry/:id', 'authenticate', 'GetStatesOfCountry');
$app->get('/stateofcountry/:id', 'GetStatesOfCountry');
$app->get('/postcodesofstate/:id', 'authenticate', 'GetPostcodesOfState');
$app->get('/postcodeofstate/:id', 'GetPostcodesOfState');
$app->get('/suburbsofpostcode/:id', 'authenticate', 'GetSuburbsOfPostcode');
$app->get('/suburbofpostcode/:id', 'GetSuburbsOfPostcode');

$app->post('/postCodesOfState', 'authenticate', 'GetPostcodesOfStateByPost');

//Relation with app, sp and residence
$app->post('/addfnf', 'authenticate', 'FnfRequestForAppUser');
$app->post('/addSpsForAppUser', 'authenticate', 'AddServiceProviderForAppUser');
$app->post('/fnfForResidence', 'authenticate', 'FnfRequestForResidence');
$app->post('/disconnectFnfForResidence', 'authenticate', 'DisconnectFnfForResidence');
$app->post('/addSpsForResidence', 'authenticate', 'AddServiceProviderForResidence');
$app->post('/removeFnfForAppUser', 'authenticate', 'RemoveFnfForAppUser');
$app->post('/manageIndividualSpForAppUser', 'authenticate', 'ManageIndividualSpForAppUser');



//Send message
$app->post('/sendMessage', 'authenticate', 'SendMessage');
$app->post('/sendIndividualMessage', 'authenticate', 'SendIndividualMessage');
$app->post('/deleteIndividualMessage/:message_id/:user_id', 'authenticate', 'DeleteIndividualMessage');
$app->post('/shareMessage', 'authenticate', 'ShareMessage');

//Receive message
$app->get('/getIndividualMessage/:sender_id/:receiver_id/:page', 'authenticate', 'GetIndividualMessage');
$app->get('/getSentBroadcast/:sender_id', 'authenticate', 'GetSentBroadcast');
$app->get('/getSpsMessage/:sender_id/:user_id', 'authenticate', 'GetSpsMessage');
$app->get('/getBroadcastForAppUser/:app_user_id/:event/:timestamp','authenticate', 'GetBroadcastForAppUser') ;
$app->get('/getSentBroadcastForAppUser/:sender_id/:app_user_id/:event','authenticate', 'GetSentBroadcastForAppUser') ;
$app->get('/getYourlinkNotice/:receiver_role', 'authenticate', 'GetYourlinkNotice');

//Search Event Or Notice for App user
$app->get('/searchBroadcastForAppUser/:app_user_id/:event/:query','authenticate', 'SearchBroadcastForAppUser');
$app->get('/searchSps/:user_id/:query', 'SearchSps');



/*===================================================================*/

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 // */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();

        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoResponse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user_id = $db->getUserId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoResponse(400, $response);
        $app->stop();
    }
}

/*===================================================================================================================*/
/* ==========================================METHODS WITHOUT AUTHENTICATION =========================================*/
/*===================================================================================================================*/

/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */

function Login(){
	// check for required params
	//verifyRequiredParams(array('email', 'password'));
	$response = array();
	// reading post params
	$request = \Slim\Slim::getInstance()->request();
	//if request data type json
	$json_request = json_decode($request->getBody());
	$email = $json_request->email;
	$password = $json_request->password;
	
	// //if request data type not json
	// $email = $request->post('email');
	// $password = $request->post('password');
	
	$db = new DbHandler();
	// check for correct email and password
	if ($db->checkLogin($email, $password)) {
		// get the user by email
		$user = $db->getUserByEmail($email);

		if ($user != NULL) {
			$response["error"] = false;
			$response['message'] = 'You are successfully login';
			//$response['user_name'] = $user['first_name']." ".$user['last_name'];
			$response['user_id'] = $user['user_id'];
			$response['email'] = $user['email'];
			$response['user_role'] = $user['user_role'];
			$response['api_key'] = $user['api_key'];
			$response['postcode'] = $user['postcode'];
			$response['image_url'] = ROOT_PATH."images/profile/".$user['image_url'];
			$response['organisation_name'] = $user['organisation_name'];
			$response['updated_on'] = $user['updated_on'];
			
		} else {
			// unknown error occurred
			$response['error'] = true;
			$response['message'] = "An error occurred. Please try again";
		}
	} else {
		// user credentials are wrong
		$response['error'] = true;
		$response['message'] = 'Login failed. Incorrect credentials';
	}
	// echo json response
    echo json_encode($response);
	
	
	// // check for required params
	// //verifyRequiredParams(array('email', 'password'));
	// $response = array();
	// // reading post params
	// $request = \Slim\Slim::getInstance()->request();
	// // //if request data type json
	// // $json_request = json_decode($request->getBody());
	// // $email = $json_request->email;
	// // $password = $json_request->password;
	
	// //if request data type not json
	// $email = $request->post('email');
	// $password = $request->post('password');
	
	// $db = new DbHandler();
	// // check for correct email and password
	// if ($db->checkLogin($email, $password)) {
		// // get the user by email
		// $result = $db->getUserByEmail($email);
		// $num_rows = $result->num_rows;
		
		// $response["error"] = false;
		// $response["users"] = array();

		// // looping through result and preparing salutation array
		// if ($num_rows > 0) //if data exist
		// {
			// $response['message'] = 'You are successfully login';
			// while ($user = $result->fetch_assoc()) {
				// $tmp = array();
				// $tmp["user_id"] = $user["user_id"];
				// $response['user_name'] = $user['first_name']." ".$user['last_name'];
				// $response['email'] = $user['email'];
				// $response['api_key'] = $user['api_key'];
				// $response['updated_on'] = $user['updated_on'];
				// array_push($response["users"], $tmp);
			// }
		// }
		// else
		// {
			// $response["error"] = true;
			// $response['message'] = "An error occurred. Please try again";
		// }
	// } else {
		// // user credentials are wrong
		// $response['error'] = true;
		// $response['message'] = 'Login failed. Incorrect credentials';
	// }
	// // echo json response
    // echo json_encode($response);
	
} 

/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */

function AppLogin(){
	// check for required params
	//verifyRequiredParams(array('email', 'password'));
	$response = array();
	// reading post params
	$request = \Slim\Slim::getInstance()->request();
	// //if request data type json
	// $json_request = json_decode($request->getBody());
	// $email = $json_request->email;
	// $password = $json_request->password;
	
	//if request data type not json
	$email = $request->post('email');
	$password = $request->post('password');
	
	$db = new DbHandler();
	// check for correct email and password
	if ($db->checkLogin($email, $password)) {
		// get the user by email
		$user = $db->getUserByEmail($email);

		if ($user != NULL) {
			$response["error"] = false;
			$response['message'] = 'You are successfully login';
			$response['user_id'] = $user['user_id'];
			$response['user_name'] = $user['first_name']." ".$user['last_name'];
			$response['email'] = $user['email'];
			$response['postcode'] = $user['postcode'];
			$response['user_role'] = $user['user_role'];
			$response['image_url'] = ROOT_PATH."images/profile/".$user['image_url'];
			$response['api_key'] = $user['api_key'];
			$response['updated_on'] = $user['updated_on'];
			
		} else {
			// unknown error occurred
			$response['error'] = true;
			$response['message'] = "An error occurred. Please try again";
		}
	} else {
		// user credentials are wrong
		$response['error'] = true;
		$response['message'] = 'Login failed. Incorrect credentials';
	}
	// echo json response
    echo json_encode($response);
	
} 


/*===================================================================================================================*/
/*===========================================METHODS WITH AUTHENTICATION ============================================*/
/*===================================================================================================================*/


/*===============================================*/
/*=================salutations===================*/
/*===============================================*/
/**
 * Creating new salutation in db
 * method POST
 * params - salutation_name
 * url - /salutations/
 */
 function AddSalutation() 
 {
	verifyRequiredParams(array('salutation_name'));
	$request = \Slim\Slim::getInstance()->request();

	$response = array();
	$salutation_name = $request->post('salutation_name');

	global $user_id;
	$db = new DbHandler();

	// creating new salutation
	$res = $db->createSalutation($salutation_name,$user_id);

	if ($res == USER_CREATED_SUCCESSFULLY) {
		$response["error"] = false;
		$response["message"] = "New salutation has been added successfully.";
	} else if ($res == USER_CREATE_FAILED) {
		$response["error"] = true;
		$response["message"] = "Failed to create salutation. Please try again.";
	} else if ($res == USER_ALREADY_EXISTED) {
		$response["error"] = true;
		$response["message"] = "Sorry, this salutation already existed.";
	}
	echoResponse(200, $response);
 }
 
 /**
 * updating Salutation in db
 * method POST
 * params - salutation_id
 * params - salutation_name
 * url - /salutations/:id
 */
	function UpdateSalutation($salutation_id) 
	{
		// check for required params
		verifyRequiredParams(array('salutation_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$salutation_name = $request->post('salutation_name');

		global $user_id;
		$db = new DbHandler();

		// creating new category
		$res = $db->updateSalutation($salutation_id, $salutation_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Salutation has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update salutation. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this salutation already existed.";
		} 
		echoResponse(200, $response);           
	}

 
 
 /**
 * Listing all salutations
 * method GET
 * url /salutations          
 */
 function GetSalutations() 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all states
	$result = $db->getAllSalutations();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["salutations"] = array();

	// looping through result and preparing salutation array
	if ($num_rows > 0) //if data exist
	{
		while ($salutation = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["salutation_id"] = $salutation["salutation_id"];
			$tmp["salutation_name"] = $salutation["salutation_name"];
			$tmp["updated_on"] = $salutation["updated_on"];
			$tmp["updated_by"] = $salutation["updated_by"];
			array_push($response["salutations"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 /**
 * get particular salutation
 * method GET
 * url /salutations/:id         
 */
 function GetSalutation($salutation_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetch salutation
	$result = $db->getSalutation($salutation_id);
	$num_rows = $result->num_rows;
	
	$response["error"] = false;
	$response["salutations"] = array();

	if ($num_rows > 0) //if data exist
	{
		while ($salutation = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["salutation_id"] = $salutation["salutation_id"];
			$tmp["salutation_name"] = $salutation["salutation_name"];
			$tmp["updated_on"] = $salutation["updated_on"];
			$tmp["updated_by"] = $salutation["updated_by"];
			array_push($response["salutations"], $tmp);			
		}
	}
	else {
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
 }
 
 /*===============================================*/
/*==================countries===================*/
/*===============================================*/
 
 /**
 * Listing all countries
 * method GET
 * url /countries          
 */
 function GetCountries() 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all countries
	$result = $db->getAllCountries();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["countries"] = array();

	// looping through result and preparing country array
	if ($num_rows > 0) //if data exist
	{
		while ($country = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["country_id"] = $country["country_id"];
			$tmp["country_name"] = $country["country_name"];
			$tmp["updated_on"] = $country["updated_on"];
			$tmp["updated_by"] = $country["updated_by"];
			array_push($response["countries"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 /**
 * Listing particular country
 * method GET
 * url /countries/:id         
 */
 function GetCountry($country_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all countries
	$result = $db->getCountry($country_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["countries"] = array();

	// looping through result and preparing country array
	if ($num_rows > 0) //if data exist
	{
		while ($country = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["country_id"] = $country["country_id"];
			$tmp["country_name"] = $country["country_name"];
			$tmp["updated_on"] = $country["updated_on"];
			$tmp["updated_by"] = $country["updated_by"];
			array_push($response["countries"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
 }
 
 // /**
 // * Creating new country in db
 // * method POST
 // * params - country_name
 // * url - /countries/
 // */
	function AddCountry() 
	{
		// check for required params
		verifyRequiredParams(array('country_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$country_name = $request->post('country_name');

		global $user_id;
		$db = new DbHandler();

		// creating new country
		$res = $db->createCountry($country_name,$user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "New country has been added successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to create country. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this country already existed.";
		}
		echoResponse(200, $response);            
	}
	
/**
 * updating country in db
 * method PUT
 * params - country_name
 * url - /countries/
 */
	function UpdateCountry($country_id) 
	{
		// check for required params
		verifyRequiredParams(array('country_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$country_name = $request->post('country_name');

		global $user_id;
		$db = new DbHandler();

		// creating new country
		$res = $db->updateCountry($country_id, $country_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Country has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update country. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this country already existed.";
		}
		echoResponse(200, $response);            
	}
 
/*===============================================*/
/*======================states===================*/
/*===============================================*/
 
 /**
 * Creating new state in db
 * method POST
 * params - state_name
 * url - /states/
 */
 function AddState() 
 {
	// check for required params
	verifyRequiredParams(array('state_name'));
	$request = \Slim\Slim::getInstance()->request();
	
	$response = array();
	$country_id = $request->post('country_id');
	$state_name = $request->post('state_name');

	global $user_id;
	$db = new DbHandler();

	// creating new category
	$res = $db->createState($country_id,$state_name,$user_id);

	if ($res == USER_CREATED_SUCCESSFULLY) {
		$response["error"] = false;
		$response["message"] = "New state has been added successfully.";
	} else if ($res == USER_CREATE_FAILED) {
		$response["error"] = true;
		$response["message"] = "Failed to create state. Please try again.";
	} else if ($res == USER_ALREADY_EXISTED) {
		$response["error"] = true;
		$response["message"] = "Sorry, this state already existed.";
	} 
	echoResponse(200, $response);   
 }
 
 /**
 * updating state in db
 * method POST
 * params - state_id
 * params - state_name
 * url - /states/:id
 */
	function UpdateState($state_id) 
	{
		// check for required params
		verifyRequiredParams(array('state_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$country_id = $request->post('country_id');
		$state_name = $request->post('state_name');

		global $user_id;
		$db = new DbHandler();

		// updating state
		$res = $db->updateState($state_id, $country_id, $state_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "State has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update state. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this state already existed.";
		}  
		echoResponse(200, $response);          
	}
 
 
 /**
 * Listing all states
 * method GET
 * url /states          
 */
 function GetStates() 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all states
	$result = $db->getAllStates();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["states"] = array();

	// looping through result and preparing category array
	if ($num_rows > 0) //if data exist
	{
		while ($state = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["state_id"] = $state["state_id"];
			$tmp["country_id"] = $state["country_id"];
			$tmp["country_name"] = $state["country_name"];
			$tmp["state_name"] = $state["state_name"];
			$tmp["updated_on"] = $state["updated_on"];
			$tmp["updated_by"] = $state["updated_by"];
			array_push($response["states"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 /**
 * Get particular state
 * method GET
 * url /states/:id          
 */
 function GetState($state_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all states
	$result = $db->getState($state_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["states"] = array();

	// looping through result and preparing state array
	if ($num_rows > 0) //if data exist
	{
		while ($state = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["state_id"] = $state["state_id"];
			$tmp["country_id"] = $state["country_id"];
			$tmp["country_name"] = $state["country_name"];
			$tmp["state_name"] = $state["state_name"];
			$tmp["updated_on"] = $state["updated_on"];
			$tmp["updated_by"] = $state["updated_by"];
			array_push($response["states"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
	
 }
 
 /**
 * Listing all states of particular country
 * method GET
 * param int $country_id
 * url /statesofcountry/:id          
 */
 function GetStatesOfCountry($country_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all postcodes of particular state
	$result = $db->getAllStatesByCountry($country_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	

	// looping through result and preparing state array
	if ($num_rows > 0) //if data exist
	{
		$response["states"] = array();
		while ($state = $result->fetch_assoc()) {
			$tmp["state_id"] = $state["state_id"];
			$tmp["state_name"] = $state["state_name"];
			$tmp["country_id"] = $state["country_id"];
			$tmp["country_name"] = $state["country_name"];		
			$tmp["updated_on"] = $state["updated_on"];
			$tmp["updated_by"] = $state["updated_by"];
			array_push($response["states"], $tmp);
		}		
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}
	echoResponse(200, $response);
 }
 
/*===============================================*/
/*===================postcodes===================*/
/*===============================================*/
 
 /**
 * Creating new postcode in db
 * method POST
 * params - state_id
 * params - postcode_name
 * url - /postcodes/
 */
 function AddPostcode() 
 {
	// check for required params
	verifyRequiredParams(array('state_id','postcode_name'));
	$request = \Slim\Slim::getInstance()->request();

	$response = array();
	$state_id = $request->post('state_id');
	$postcode_name = $request->post('postcode_name');

	global $user_id;
	$db = new DbHandler();

	// creating new category
	$res = $db->createPostcode($state_id,$postcode_name,$user_id);

	if ($res == USER_CREATED_SUCCESSFULLY) {
		$response["error"] = false;
		$response["message"] = "New postcode has been added successfully.";
	} else if ($res == USER_CREATE_FAILED) {
		$response["error"] = true;
		$response["message"] = "Failed to create postcode. Please try again.";
	} else if ($res == USER_ALREADY_EXISTED) {
		$response["error"] = true;
		$response["message"] = "Sorry, this postcode already existed.";
	} 
	echoResponse(200, $response);
 }
 
 /**
 * updating postcode in db
 * method POST
 * params - postcode_id
 * params - state_id
 * params - postcode_name
 * url - /postcodes/:id
 */
	function UpdatePostcode($postcode_id) 
	{
		// check for required params
		verifyRequiredParams(array('postcode_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$state_id = $request->post('state_id');
		$postcode_name = $request->post('postcode_name');

		global $user_id;
		$db = new DbHandler();

		// updating Postcode
		$res = $db->updatePostcode($postcode_id, $state_id, $postcode_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Postcode has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update postcode. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this postcode already existed.";
		} 
		echoResponse(200, $response);           
	}
 
 /**
 * Listing all postcodes
 * method GET
 * url /postcodes          
 */
 function GetPostcodes() 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all postcode
	$result = $db->getAllPostcodes();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["postcodes"] = array();

	// looping through result and preparing postcode array
	if ($num_rows > 0) //if data exist
	{
		while ($postcode = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["postcode_id"] = $postcode["postcode_id"];
			$tmp["country_id"] = $postcode["country_id"];
			$tmp["country_name"] = $postcode["country_name"];			
			$tmp["state_id"] = $postcode["state_id"];
			$tmp["state_name"] = $postcode["state_name"];
			$tmp["postcode_name"] = $postcode["postcode_name"];
			$tmp["updated_on"] = $postcode["updated_on"];
			$tmp["updated_by"] = $postcode["updated_by"];
			array_push($response["postcodes"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 /**
 * Listing particular postcode
 * method GET
 * param int $postcode_id
 * url /postcodes/:id          
 */
 function GetPostcode($postcode_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching particular postcode
	$result = $db->getPostcode($postcode_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["postcodes"] = array();

	// looping through result and preparing postcode array
	if ($num_rows > 0) //if data exist
	{
		while ($postcode = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["postcode_id"] = $postcode["postcode_id"];
			$tmp["country_id"] = $postcode["country_id"];
			$tmp["country_name"] = $postcode["country_name"];
			$tmp["state_id"] = $postcode["state_id"];
			$tmp["postcode_name"] = $postcode["postcode_name"];
			$tmp["updated_on"] = $postcode["updated_on"];
			$tmp["updated_by"] = $postcode["updated_by"];
			array_push($response["postcodes"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}

	echoResponse(200, $response);
 }
 
 /**
 * Listing all postcodes of particular state
 * method GET
 * param int $state_id
 * url /statespostcodes/:id          
 */
 function GetPostcodesOfState($state_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all postcodes of particular state
	$result = $db->getAllPostcodesByState($state_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["postcodes"] = array();

	// looping through result and preparing postcode array
	if ($num_rows > 0) //if data exist
	{
		while ($postcode = $result->fetch_assoc()) {
			$tmp["postcode_id"] = $postcode["postcode_id"];	
			$tmp["postcode_name"] = $postcode["postcode_name"];
			$tmp["state_id"] = $postcode["state_id"];
			$tmp["state_name"] = $postcode["state_name"];
			$tmp["country_id"] = $postcode["country_id"];
			$tmp["country_name"] = $postcode["country_name"];		
			$tmp["updated_on"] = $postcode["updated_on"];
			$tmp["updated_by"] = $postcode["updated_by"];
			array_push($response["postcodes"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}
	echoResponse(200, $response);
 }
 
 function GetPostcodesOfStateByPost() 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();
	
	$request = \Slim\Slim::getInstance()->request();
	$state_id = $request->post('state_id');

	// fetching all postcodes of particular state
	$result = $db->getAllPostcodesByState($state_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["postcodes"] = array();

	// looping through result and preparing postcode array
	if ($num_rows > 0) //if data exist
	{
		while ($postcode = $result->fetch_assoc()) {
			$tmp["postcode_id"] = $postcode["postcode_id"];	
			$tmp["postcode_name"] = $postcode["postcode_name"];
			$tmp["state_id"] = $postcode["state_id"];
			$tmp["state_name"] = $postcode["state_name"];
			$tmp["country_id"] = $postcode["country_id"];
			$tmp["country_name"] = $postcode["country_name"];		
			$tmp["updated_on"] = $postcode["updated_on"];
			$tmp["updated_by"] = $postcode["updated_by"];
			array_push($response["postcodes"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}
	echoResponse(200, $response);
 }
 
/*===============================================*/
/*====================suburbs====================*/
/*===============================================*/
 
 /**
 * Creating new suburb in db
 * method POST
 * params - postcode_id
 * params - suburb_name
 * url - /suburbs/
 */
 function AddSuburb() 
 {
	// check for required params
	verifyRequiredParams(array('postcode_id','suburb_name'));
	$request = \Slim\Slim::getInstance()->request();

	$response = array();
	$postcode_id = $request->post('postcode_id');
	$suburb_name = $request->post('suburb_name');

	global $user_id;
	$db = new DbHandler();

	// creating new category
	$res = $db->createSuburb($postcode_id,$suburb_name,$user_id);

	if ($res == USER_CREATED_SUCCESSFULLY) {
		$response["error"] = false;
		$response["message"] = "New suburb has been added successfully.";
	} else if ($res == USER_CREATE_FAILED) {
		$response["error"] = true;
		$response["message"] = "Failed to create suburb. Please try again.";
	} else if ($res == USER_ALREADY_EXISTED) {
		$response["error"] = true;
		$response["message"] = "Sorry, this suburb already existed.";
	} 
	echoResponse(200, $response);
 }
 
 /**
 * updating suburb in db
 * method POST
 * params - suburb_id
 * params - postcode_id
 * params - suburb_name
 * url - /suburbs/:id
 */
	function UpdateSuburb($suburb_id) 
	{
		// check for required params
		verifyRequiredParams(array('suburb_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$postcode_id = $request->post('postcode_id');
		$suburb_name = $request->post('suburb_name');

		global $user_id;
		$db = new DbHandler();

		// updating Suburb
		$res = $db->updateSuburb($suburb_id, $postcode_id, $suburb_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Suburb has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update suburb. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this suburb already existed.";
		} 
		echoResponse(200, $response);           
	}
 
 /**
 * Listing all suburbs
 * method GET
 * url /suburbs          
 */
 
 function GetSuburbs() 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all suburb
	$result = $db->getAllSuburbs();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["suburbs"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($suburb = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["suburb_id"] = $suburb["suburb_id"];
			$tmp["postcode_id"] = $suburb["postcode_id"];
			$tmp["postcode_name"] = $suburb["postcode_name"];
			$tmp["state_name"] = $suburb["state_name"];
			$tmp["suburb_name"] = $suburb["suburb_name"];
			$tmp["country_id"] = $suburb["country_id"];
			$tmp["country_name"] = $suburb["country_name"];
			$tmp["updated_on"] = $suburb["updated_on"];
			$tmp["updated_by"] = $suburb["updated_by"];
			array_push($response["suburbs"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 /**
 * Listing particular suburb
 * method GET
 * url /suburbs/:id          
 */
 function GetSuburb($suburb_id) 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all suburb
	$result = $db->getSuburb($suburb_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["suburbs"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($suburb = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["suburb_id"] = $suburb["suburb_id"];
			$tmp["postcode_id"] = $suburb["postcode_id"];
			$tmp["postcode_name"] = $suburb["postcode_name"];
			$tmp["state_id"] = $suburb["state_id"];
			$tmp["state_name"] = $suburb["state_name"];
			$tmp["suburb_name"] = $suburb["suburb_name"];
			$tmp["country_id"] = $suburb["country_id"];
			$tmp["country_name"] = $suburb["country_name"];
			$tmp["updated_on"] = $suburb["updated_on"];
			$tmp["updated_by"] = $suburb["updated_by"];
			array_push($response["suburbs"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
 }
 
 /**
 * Listing all suburbs of particular postcode
 * method GET
 * param int $postcode_id
 * url /suburbsofpostcode/:id          
 */
 function GetSuburbsOfPostcode($postcode_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all suburbs of particular postcode
	$result = $db->getAllSuburbsByPostcode($postcode_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["suburbs"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($suburb = $result->fetch_assoc()) {
			$tmp["suburb_id"] = $suburb["suburb_id"];
			$tmp["suburb_name"] = $suburb["suburb_name"];
			$tmp["postcode_id"] = $suburb["postcode_id"];
			$tmp["postcode_name"] = $suburb["postcode_name"];
			$tmp["state_id"] = $suburb["state_id"];
			$tmp["state_name"] = $suburb["state_name"];
			$tmp["country_id"] = $suburb["country_id"];
			$tmp["country_name"] = $suburb["country_name"];		
			$tmp["updated_on"] = $suburb["updated_on"];
			$tmp["updated_by"] = $suburb["updated_by"];
			array_push($response["suburbs"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}
	echoResponse(200, $response);
 }
 
 function GetRelationalData() 
 {
	$return = array();
	$db = new DbHandler();
	$return = $db->getRelationalData();	
	echo json_encode($return);
 }

 function GetSpsAndResidences($postcode,$user_role) 
 {
	$return = array();
	$db = new DbHandler();
	//$return = $db->getSpAndResidence($postcode);	
	$return = $db->getSpsOrResidences($postcode,$user_role);
	echo json_encode($return);
 }
 //get category wise sp for specific postcode
 function GetSps($user_id,$postcode) 
 {
 	$user_role = 2;
	$return = array();
	$db = new DbHandler();
	//$return = $db->getSpAndResidence($postcode);	
	$return = $db->getSpsOrResidences($user_id,$postcode,$user_role);
	echo json_encode($return);
 }
 
 //get number of current links and favourite of specific sp or residence
 function GetCurrentLinksFavoured($user_id) 
 {
	$return = array();
	$db = new DbHandler();	
	$return = $db->getCurrentLinksFavoured($user_id);
	echo json_encode($return);
 }
 
 //get category wise sp for specific postcode
 function SearchSps($user_id,$query) 
 {
 	$user_role = 2;
	$return = array();
	$db = new DbHandler();
	//$return = $db->getSpAndResidence($postcode);	
	$return = $db->searchSpsOrResidences($user_id,$query);
	echo json_encode($return);
 }
 
// //get category wise sp for specific postcode
// function GetAllSps($user_id) 
// {
// 	$user_role = 2;
//	$return = array();
//	$db = new DbHandler();
//	//$return = $db->getSpAndResidence($postcode);	
//	$return = $db->getAllSpsOrResidences($user_id,$user_role);
//	echo json_encode($return);
// }
 
 //get category wise sp for specific postcode
 function GetSpsForRes($user_id,$postcode) 
 {
 	$user_role = 2;
	$return = array();
	$db = new DbHandler();
	//$return = $db->getSpsForResidence($postcode);	
	$return = $db->getSpsForResidence($user_id,$postcode,$user_role);
	echo json_encode($return);
 }
 
 //get category wise sp for specific postcode
 function SearchSpsForRes($user_id,$query) 
 {
 	$user_role = 2;
	$return = array();
	$db = new DbHandler();
	//$return = $db->getSpsForResidence($postcode);	
	$return = $db->searchSpsForResidence($user_id,$query,$user_role);
	echo json_encode($return);
 }
 //get category wise residence for specific postcode
 function GetResidences($user_id,$postcode) 
 {
 	$user_role = 3;
	$return = array();
	$db = new DbHandler();
	//$return = $db->getSpAndResidence($postcode);	
	$return = $db->getSpsOrResidences($user_id,$postcode,$user_role);
	echo json_encode($return);
 }


 //get assigned residence for specific sp
 function GetAssignedResidenceForSp($sp_id) 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all assigned residence for specific sp
	$result = $db->getAssignedResidenceForSp($sp_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["sps"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($sp = $result->fetch_assoc()) {
			$tmp = array();
			$path = ROOT_PATH."images/profile/";
			$tmp["user_id"] = $sp["user_id"];
			$tmp["organisation_name"] = $sp["organisation_name"];
			$tmp["image_url"] = $path.$sp["image_url"];
			array_push($response["sps"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 //get assigned residence for specific sp
 function GetAssignedSpsForRes($res_id) 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all assigned sps for specific residence
	$result = $db->getAssignedSpsForRes($res_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["sps"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($sp = $result->fetch_assoc()) {
			$tmp = array();
			$path = ROOT_PATH."images/profile/";
			$tmp["user_id"] = $sp["user_id"];
			$tmp["organisation_name"] = $sp["organisation_name"];
			$tmp["image_url"] = $path.$sp["image_url"];
			array_push($response["sps"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 //get assigned individuals for specific residence
 function GetAssignedIndividualsForRes($res_id) 
 {	
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all assigned residence for specific sp
	$result = $db->getAssignedIndividualsForRes($res_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["individuals"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($individual = $result->fetch_assoc()) {
			$tmp = array();
			$path = ROOT_PATH."images/profile/";
			$tmp["user_id"] = $individual["user_id"];
			$tmp["name"] = $individual["first_name"].' '.$individual["last_name"];
			$tmp["image_url"] = $path.$individual["image_url"];
			array_push($response["individuals"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 
 /**
 * get assigned level one with unread message for specific app user
 * @param int $app_user_id
 * @param UNIX timestamp $timestamp
 * @return array as json
 */	
 function GetLevelOneWithUnreadMsg($app_user_id, $timestamp) 
 {	
 	$return = array();
	$db = new DbHandler();
	$return = $db->getLevelOneWithUnreadMsg($app_user_id, $timestamp);
	echo json_encode($return);
 }
 /**
 * get assigned FNF with unread message for specific app user
 * @param int $app_user_id
 * @param UNIX timestamp $timestamp
 * @return array as json
 */	
 function GetFnfWithUnreadMsgForApp($app_user_id, $timestamp) 
 {	
 	$return = array();
	$db = new DbHandler();
	$return = $db->getFnfWithUnreadMsgForApp($app_user_id, $timestamp);
	echo json_encode($return);
 }
 
 /**
 * get assigned Sps with unread message for specific app user and specific category_id
 * @param int $app_user_id
 * @param UNIX timestamp $timestamp
 * @return array as json
 */	
 function GetSpsWithUnreadMsgForApp($category_id, $app_user_id, $timestamp) 
 {	
 	$return = array();
	$db = new DbHandler();
	$return = $db->getSpsWithUnreadMsgForApp($category_id, $app_user_id, $timestamp);
	echo json_encode($return);
 }
 
 //get assigned sps for specific residence
 function GetAssignedSpsBroadcastOrIndividualForRes($msg_type, $res_id) 
 {	
	$response = array();
	$db = new DbHandler();

	// fetching all assigned residence for specific sp
	$result = $db->getAssignedSpsBroadcastOrIndividualForRes($msg_type, $res_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["sps"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($sp = $result->fetch_assoc()) {
			$tmp = array();
			$path = ROOT_PATH."images/profile/";
			$tmp["user_id"] = $sp["user_id"];
			$tmp["organisation_name"] = $sp["organisation_name"];
			$tmp["image_url"] = $path.$sp["image_url"];
			$tmp["sender_id"] = $sp["sender_id"];
			$tmp["receiver_id"] = $sp["receiver_id"];
			$tmp["message_title"] = $sp["message_title"];
			$tmp["description"] = $sp["description"];
			$tmp["send_date"] = $sp["sent_time"];
			$tmp["sent_time"] = $sp["timestamp"];
			$tmp["event"] = $sp["event"];
			array_push($response["sps"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 
 //get assigned individuals' msg for specific residence
 function GetAssignedIndividualsMsgForRes($res_id) 
 {	
	$response = array();
	$db = new DbHandler();

	// fetching all assigned residence for specific sp
	$result = $db->getAssignedIndividualsMsgForRes($res_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["sps"] = array();

	// looping through result and preparing suburb array
	if ($num_rows > 0) //if data exist
	{
		while ($sp = $result->fetch_assoc()) {
			$tmp = array();
			$path = ROOT_PATH."images/profile/";
			$tmp["user_id"] = $sp["user_id"];
			$tmp["organisation_name"] = $sp["organisation_name"];
			$tmp["name"] = $sp["first_name"].' '.$sp["last_name"];
			$tmp["image_url"] = $path.$sp["image_url"];
			$tmp["sender_id"] = $sp["sender_id"];
			$tmp["receiver_id"] = $sp["receiver_id"];
			$tmp["description"] = $sp["description"];
			$tmp["send_date"] = $sp["sent_time"];
			$tmp["sent_time"] = $sp["timestamp"];
			$tmp["event"] = $sp["event"];
			array_push($response["sps"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 
 
 
 /*===============================================*/
/*==================levelOneClass===================*/
/*===============================================*/
 
 /**
 * Listing all levelOneClass
 * method GET
 * url /levelOneClass          
 */
 function GetLevelOneClasses() 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all classes
	$result = $db->getAllLevelOneClass();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["classes"] = array();

	// looping through result and preparing category array
	if ($num_rows > 0) //if data exist
	{
		while ($class = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["level_one_class_id"] = $class["level_one_class_id"];
			$tmp["level_one_class_name"] = $class["level_one_class_name"];
			$tmp["level_one_class_order"] = $class["level_one_class_order"];
			$tmp["level_one_class_contain_level_two"] = $class["level_one_class_contain_level_two"];
			$tmp["user_role"] = $class["user_role"];
			$tmp["updated_on"] = $class["updated_on"];
			$tmp["updated_by"] = $class["updated_by"];
			array_push($response["classes"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 /**
 * Listing particular category
 * method GET
 * url /levelOneClass/:id         
 */
 function GetLevelOneClass($level_one_class_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all LevelOneClass
	$result = $db->getLevelOneClass($level_one_class_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["classes"] = array();

	// looping through result and preparing class array
	if ($num_rows > 0) //if data exist
	{
		while ($class = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["level_one_class_id"] = $class["level_one_class_id"];
			$tmp["level_one_class_name"] = $class["level_one_class_name"];
			$tmp["level_one_class_order"] = $class["level_one_class_order"];
			$tmp["level_one_class_contain_level_two"] = $class["level_one_class_contain_level_two"];
			$tmp["user_role"] = $class["user_role"];
			$tmp["updated_on"] = $class["updated_on"];
			$tmp["updated_by"] = $class["updated_by"];
			array_push($response["classes"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
 }
 
  /**
  * Creating new LevelOneClass in db
  * method POST
  * params - level_one_class_name
  * url - /levelOneClass/
  */
	function AddLevelOneClass() 
	{
		// check for required params
		verifyRequiredParams(array('level_one_class_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$level_one_class_name = $request->post('level_one_class_name');
		$level_one_class_order = $request->post('level_one_class_order');
		$level_one_class_contain_level_two = "";
		//$user_role = $request->post('user_role');
		if($request->post('level_one_class_contain_level_two')==null){
			$level_one_class_contain_level_two = "false";
		}
		else{
			$level_one_class_contain_level_two = "true";
		}
		
		/*$response["error"] = false;
		$response["message"] = $level_one_class_contain_level_two;
		echoResponse(201, $response);*/

		global $user_id;
		$db = new DbHandler();

		// creating new category
		//$res = $db->createLevelOneClass($level_one_class_name,$level_one_class_order,$level_one_class_contain_level_two,$user_role,$user_id);
		$res = $db->createLevelOneClass($level_one_class_name,$level_one_class_order,$level_one_class_contain_level_two,$user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "New class has been added successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to create class. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this class already existed.";
		}  
		echoResponse(200, $response);          
	}
	
/**
 * updating category in db
 * method PUT
 * params - level_one_class_name
 * url - /categories/
 */
	function UpdateLevelOneClass($level_one_class_id) 
	{
		// check for required params
		verifyRequiredParams(array('level_one_class_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$level_one_class_name = $request->post('level_one_class_name');
		$level_one_class_order = $request->post('level_one_class_order');
		$level_one_class_contain_level_two = "";
		//$user_role = $request->post('user_role');
		if($request->post('level_one_class_contain_level_two') == null){
			$level_one_class_contain_level_two = "false";
		}
		else{
			$level_one_class_contain_level_two = "true";
		}

		global $user_id;
		$db = new DbHandler();

		// creating new category
		$res = $db->updateLevelOneClass($level_one_class_id, $level_one_class_name,$level_one_class_order,$level_one_class_contain_level_two,$user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Class has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update class. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this class already existed.";
		} 
		echoResponse(200, $response);           
	}
	
 
/*===============================================*/
/*==================categories===================*/
/*===============================================*/
 
 /**
 * Listing all categories
 * method GET
 * url /categories          
 */
 function GetCategories() 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all categories
	$result = $db->getAllCategories();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["categories"] = array();

	// looping through result and preparing category array
	if ($num_rows > 0) //if data exist
	{
		while ($category = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["category_id"] = $category["category_id"];
			$tmp["category_name"] = $category["category_name"];
			$tmp["updated_on"] = $category["updated_on"];
			$tmp["updated_by"] = $category["updated_by"];
			array_push($response["categories"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
 
 /**
 * Listing particular category
 * method GET
 * url /categories/:id         
 */
 function GetCategory($category_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all categories
	$result = $db->getCategory($category_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["categories"] = array();

	// looping through result and preparing category array
	if ($num_rows > 0) //if data exist
	{
		while ($category = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["category_id"] = $category["category_id"];
			$tmp["category_name"] = $category["category_name"];
			$tmp["updated_on"] = $category["updated_on"];
			$tmp["updated_by"] = $category["updated_by"];
			array_push($response["categories"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
 }
 
 // /**
 // * Creating new category in db
 // * method POST
 // * params - category_name
 // * url - /categories/
 // */
	function AddCategory() 
	{
		// check for required params
		verifyRequiredParams(array('category_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$category_name = $request->post('category_name');

		global $user_id;
		$db = new DbHandler();

		// creating new category
		$res = $db->createCategory($category_name,$user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "New category has been added successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to create category. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this category already existed.";
		}  
		echoResponse(200, $response);          
	}
	
/**
 * updating category in db
 * method PUT
 * params - category_name
 * url - /categories/
 */
	function UpdateCategory($category_id) 
	{
		// check for required params
		verifyRequiredParams(array('category_name'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		//$category_id = $request->post('category_id');
		$category_name = $request->post('category_name');

		global $user_id;
		$db = new DbHandler();

		// creating new category
		$res = $db->updateCategory($category_id, $category_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Category has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update category. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this category already existed.";
		}  
		echoResponse(200, $response);          
	}
	
	function GetFeedbackCategories() 
	{
		global $user_id;
		$response = array();
		$db = new DbHandler();

		// fetching all categories
		$result = $db->getAllFeedbackCategories();
		$num_rows = $result->num_rows;

		$response["error"] = false;
		$response["categories"] = array();

		// looping through result and preparing category array
		if ($num_rows > 0) //if data exist
		{
			while ($category = $result->fetch_assoc()) {
				$tmp = array();
				$tmp["feedback_category_id"] = $category["feedback_category_id"];
				$tmp["feedback_category_name"] = $category["feedback_category_name"];
				$tmp["updated_on"] = $category["updated_on"];
				$tmp["updated_by"] = $category["updated_by"];
				array_push($response["categories"], $tmp);
			}
		}
		else
		{
			$response["error"] = true;
			$response["message"] = "No Result Found.";
		}

		echoResponse(200, $response);
	}
	
	function GetFeedbackCategory($feedback_category_id) 
	{
		global $user_id;
		$response = array();
		$db = new DbHandler();

		// fetching all categories
		$result = $db->getFeedbackCategory($feedback_category_id);
		$num_rows = $result->num_rows;

		$response["error"] = false;
		$response["categories"] = array();

		// looping through result and preparing category array
		if ($num_rows > 0) //if data exist
		{
			while ($category = $result->fetch_assoc()) {
				$tmp = array();
				$tmp["feedback_category_id"] = $category["feedback_category_id"];
				$tmp["feedback_category_name"] = $category["feedback_category_name"];
				$tmp["updated_on"] = $category["updated_on"];
				$tmp["updated_by"] = $category["updated_by"];
				array_push($response["categories"], $tmp);
			}
		}
		else
		{
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exists";
		}
		echoResponse(200, $response);
	}
	
	function AddFeedbackCategory() 
	{
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();
		$feedback_category_name = $request->post('feedback_category_name');

		global $user_id;
		$db = new DbHandler();
		// creating new feedback
		$res = $db->addFeedbackCategory($feedback_category_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "New feedback category has been added successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to create feedback category. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this category already existed.";
		}
		echoResponse(200, $response);          
	}
	
	function UpdateFeedbackCategory($feedback_category_id) 
	{

		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$feedback_category_name = $request->post('feedback_category_name');

		global $user_id;
		$db = new DbHandler();

		// creating new country
		$res = $db->updateFeedbackCategory($feedback_category_id, $feedback_category_name, $user_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Category has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to update category. Please try again.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this category already existed.";
		}
		echoResponse(200, $response);            
	}
	
 /**
  * Creating new feedback in db
  * method POST
  * params - user_id
  * @param - description
  * url - /addFeedback/
  */
	function AddFeedback() 
	{
		// check for required params
		verifyRequiredParams(array('user_id','description','feedback_category_id'));
		$request = \Slim\Slim::getInstance()->request();

		$response = array();
		$user_id = $request->post('user_id');
		$description = $request->post('description');
		$feedback_category_id = $request->post('feedback_category_id');

		//global $user_id;
		$db = new DbHandler();

		// creating new feedback
		$res = $db->createFeedback($user_id, $description, $feedback_category_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "New feedback has been added successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Failed to create feedback. Please try again.";
		} 
		echoResponse(200, $response);          
	}
	
	/**
 * Listing all feedback
 * method GET
 * url /getFeedbacks          
 */
 function GetFeedbacks() 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all categories
	$result = $db->getAllFeedbacks();
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["feedbacks"] = array();

	// looping through result and preparing category array
	if ($num_rows > 0) //if data exist
	{
		$path = ROOT_PATH."images/profile/";
		while ($feedback = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["user_id"] = $feedback["user_id"];
			$tmp["first_name"] = $feedback["first_name"];
			$tmp["last_name"] = $feedback["last_name"];
			$tmp["email"] = $feedback["email"];
			$tmp["feedback_id"] = $feedback["feedback_id"];
			$tmp["feedback_category_name"] = $feedback["feedback_category_name"];
			$tmp["description"] = $feedback["description"];
			$tmp["sent_time"] = $feedback["timestamp"];
			$tmp["image_url"] = $path.$feedback['image_url'];
			array_push($response["feedbacks"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
 }
	
/*===============================================*/
/*=====================users=====================*/
/*===============================================*/
 
 /**
 * Creating new admin in db
 * method POST
 * url - /users/
 */
	function AddAdmin() 
	{
		// check for required params
		verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$first_name = $request->post('first_name');
		$last_name = $request->post('last_name');
		$email = $request->post('email');
		$password = $request->post('password');

		// validating email address
		validateEmail($email);

		$db = new DbHandler();
		$res = $db->createUser($first_name, $last_name, $email, $password);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "You are successfully registered";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred while registereing";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this email already existed";
		}
		// echo json response
		echoResponse(201, $response);
    
	}
	
	function UpdateAdmin($user_id) 
	{
		// check for required params
		verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$first_name = $request->post('first_name');
		$last_name = $request->post('last_name');
		$email = $request->post('email');
		$password = $request->post('password');

		// validating email address
		validateEmail($email);

		$db = new DbHandler();
		$res = $db->updateUser($user_id, $first_name, $last_name, $email, $password);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "User updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred while updating";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this email already existed";
		}
		// echo json response
		echoResponse(201, $response);
    
	}
	
/**
 * Creating new user in db for app user
 * method POST
 * url - /users/
 */
	function AppRegistration() 
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$salutation = $request->post('salutation');
		$first_name = $request->post('first_name');
		$last_name = $request->post('last_name');
		$gender = $request->post('gender');
		$date_of_birth_month = $request->post('date_of_birth_month');
		$date_of_birth_year = $request->post('date_of_birth_year');
		$phone = $request->post('phone');
		$country = $request->post('country');
		$state = $request->post('state');
		$postcode = $request->post('postcode');
		$suburb = $request->post('suburb');
		$residence = $request->post('residence');
		$email = $request->post('email');
		$password = $request->post('password');
		
		$image_url = "male.jpg";
		if($gender == "Female"){
			$image_url = "female.jpg";
		}
		

		// validating email address
		validateEmail($email);

		$db = new DbHandler();
		$res = $db->appRegistration($salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $image_url, $country, $state, $postcode, $suburb, $residence, $email, $password);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$user = $db->getUserByEmail($email);
			$response["error"] = false;
			$response["message"] = "You are successfully registered";
			$response['user_id'] = $user['user_id'];
			$response['api_key'] = $user['api_key'];
			$response['postcode'] = $user['postcode'];
			$response['image_url'] = ROOT_PATH."images/profile/".$user['image_url'];
			
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred while registereing";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this email already existed";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	/**
 * Creating new user in db for service provider or residence
 * method POST
 * url - /users/
 */
	function Registration() 
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$user_role = 2;
		$category = 0;
		$state = '';
		$postcode = ''; 
		$suburb = ''; 
		
				
		$organisation_name = $request->post('organisation_name');
		$address = $request->post('address');
		$country = $request->post('country');
		if($country == 'Australia'){
			$state = $request->post('state'); 
			$postcode = $request->post('postcode'); 
			$suburb = $request->post('suburb');
		}else{
			$state = $request->post('state-text'); 
			$postcode = $request->post('postcode-text'); 
			$suburb = $request->post('suburb-text');
		}
		$primary_contact = $request->post('primary_contact');
		$phone = $request->post('phone');		
		$organisation_description = $request->post('organisation_description');
		$email = $request->post('email');
		$password = $request->post('password');
		//$current_image = $request->post('current_image');
		
		if($request->post('user_role') == 'on'){
			$user_role = 3;
			$category = 4;
		}else{
			$category = $request->post('category');
		}
		
		$response["error"] = true;
		//$response["message"] = $user_role;

		$image_url = "";
		$thumbnail_path = '../images/profile/';
		if($user_role == 2){
			$image_url = "sp.png";		
		}else{
			$image_url = "residence.png";
		}
		// validating email address
		validateEmail($email);
		
		$thumb_name = "";
		$thumb_tmp_name="";
		//$response["error"] = false;
		$db = new DbHandler();
		if(isset($_FILES["profile"]["name"]))
		{
			if($_FILES["profile"]["name"] != ""){
				$thumb_name = $_FILES["profile"]["name"];
				$temp_thumb = explode(".", $thumb_name);
				$ext_thumb = strtolower(end($temp_thumb));
				$thumb_name = time().".".$ext_thumb;
				$thumb_tmp_name = $_FILES["profile"]["tmp_name"];
				
				if(move_uploaded_file($thumb_tmp_name,$thumbnail_path.$thumb_name)){
					$res = $db->spRegistration($user_role, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $thumb_name, $category, $organisation_description, $email, $password);
				}
			}else{
				$res = $db->spRegistration($user_role, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password);
			}
			
		}else{
			$res = $db->spRegistration($user_role, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password);
		}
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$user = $db->getUserByEmail($email);
			$response["error"] = false;
			$response["message"] = "You are successfully registered";
			$response['user_id'] = $user['user_id'];
			$response['user_role'] = $user['user_role'];
			$response['email'] = $user['email'];
			$response['api_key'] = $user['api_key'];
			$response['organisation_name'] = $user['organisation_name'];
			$response['postcode'] = $user['postcode'];
			$response['image_url'] = ROOT_PATH."images/profile/".$user['image_url'];			
			
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred while registereing";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this email already existed";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	/**
 * Change Password
 * method POST
 * url - /changePassword/
 */
	function ChangePassword()
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$user_id = $request->post('user_id');
		$old_password = $request->post('old_password');
		$new_password = $request->post('new_password');
		
		$response["error"] = true;
		$db = new DbHandler();
		$res = $db->changePassword($user_id, $old_password, $new_password);
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "You are successfully changed your password.";			
			
		} else if ($res == USER_ALREADY_EXISTED){
			$response["error"] = false;
			$response["message"] = "Old password is wrong.";
		}
		else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred while changing password.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	function ForgotPassword()
	{
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$email = $request->post('email');
		
		$response["error"] = true;
		$db = new DbHandler();
		$res = $db->forgotPassword($email);
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Activation code has been send to your email address.";			
			
		} else if ($res == USER_EMAIL_NOT_MATCH){
			$response["error"] = true;
			$response["message"] = "This email is not registered.";
		}
		else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	function ActivateForgotPassword()
	{
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$email = $request->post('email');
		$new_password = $request->post('new_password');
		$activation_code = $request->post('activation_code');
		
		$response["error"] = true;
		$db = new DbHandler();
		$res = $db->activateForgotPassword($email, $new_password, $activation_code);
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "You are successfully changed your password.";			
			
		} else if ($res == USER_EMAIL_NOT_MATCH){
			$response["error"] = true;
			$response["message"] = "Activation code is wrong.";
		}
		else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	function ManageLike()
	{
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$sp_id = $request->post('sp_id');
		$app_user_id = $request->post('app_user_id');
		
		$response["error"] = true;
		$db = new DbHandler();
		$res = $db->manageLike($sp_id, $app_user_id);
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "You are successfully changed your like.";			
			
		}
		else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
		/**
 * Change Email
 * method POST
 * url - /changePassword/
 */
	function ChangeEmail()
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$user_id = $request->post('user_id');
		$old_email = $request->post('old_email');
		$new_email = $request->post('new_email');
		
		$response["error"] = true;
		$db = new DbHandler();
		$res = $db->changeEmail($user_id, $old_email, $new_email);
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "You are successfully changed your email.";			
			
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred while changing email.";
		}else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this email already existed.";
		}else if($res == USER_EMAIL_NOT_MATCH){
			$response["error"] = true;
			$response["message"] = "Sorry, this old email is wrong.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	function UpdateProfile() {
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$user_role = 2;
		$state = '';
		$postcode = ''; 
		$suburb = ''; 
		
		if($request->post('user_role') == 'on'){
			$user_role = 3;
		}
		$user_id = $request->post('user_id');
		$organisation_name = $request->post('organisation_name');
		$address = $request->post('address');
		$country = $request->post('country');
		if($country == 'Australia'){
			$state = $request->post('state'); 
			$postcode = $request->post('postcode'); 
			$suburb = $request->post('suburb');
		}else{
			$state = $request->post('state-text'); 
			$postcode = $request->post('postcode-text'); 
			$suburb = $request->post('suburb-text');
		}
		$primary_contact = $request->post('primary_contact');
		$phone = $request->post('phone');
		$category = $request->post('category');
		$organisation_description = $request->post('organisation_description');
		$email = $request->post('email');
		$password = $request->post('password');
		
		$response["error"] = true;
		$response["message"] = $user_role;

		$image_url = $request->post('current_image');
		$thumbnail_path = '../images/profile/';
//		if($user_role == 2){
//			$image_url = "sp.png";		
//		}else{
//			$image_url = "residence.png";
//		}
		// validating email address
		validateEmail($email);
		
		$thumb_name = "";
		$thumb_tmp_name="";
		//$response["error"] = false;
		$db = new DbHandler();
		if(isset($_FILES["profile"]["name"]))
		{
			if($_FILES["profile"]["name"] != ""){
				$thumb_name = $_FILES["profile"]["name"];
				$temp_thumb = explode(".", $thumb_name);
				$ext_thumb = strtolower(end($temp_thumb));
				$thumb_name = time().".".$ext_thumb;
				$thumb_tmp_name = $_FILES["profile"]["tmp_name"];
				
				if(move_uploaded_file($thumb_tmp_name,$thumbnail_path.$thumb_name)){
					$res = $db->updateProfile($user_id, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $thumb_name, $category, $organisation_description, $email, $password);
				}
			}else{
				$res = $db->updateProfile($user_id, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password);
			}
			
		}else{
			$res = $db->updateProfile($user_id, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password);
		}
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$user = $db->getUserByEmail($email);
			$response["error"] = false;
			$response["message"] = "Profile updated successfully.";
			$response['user_id'] = $user['user_id'];
			$response['user_role'] = $user['user_role'];
			$response['email'] = $user['email'];
			$response['api_key'] = $user['api_key'];
			$response['organisation_name'] = $user['organisation_name'];
			$response['postcode'] = $user['postcode'];
			$response['image_url'] = ROOT_PATH."images/profile/".$user['image_url'];			
			
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred while updating";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, this email already existed";
		}
		// echo json response
		echoResponse(200, $response); 
	}
	
	function UpdateAppProfile() {
		$response = array();
		// reading post params
		$request = \Slim\Slim::getInstance()->request();

		
		// reading post params
		$app_user_id = $request->post('user_id');
		$salutation = $request->post('salutation');
		$first_name = $request->post('first_name');
		$last_name = $request->post('last_name');
		$gender = $request->post('gender');
		$date_of_birth_month = $request->post('date_of_birth_month');
		$date_of_birth_year = $request->post('date_of_birth_year');
		$phone = $request->post('phone');
		$country = $request->post('country');
		$state = $request->post('state');
		$postcode = $request->post('postcode');
		$suburb = $request->post('suburb');
		$residence = $request->post('residence');
		//$email = $request->post('email');
		//$password = $request->post('password');	
		
		$db = new DbHandler();
		$res = $db->updateAppProfile($app_user_id, $salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $country, $state, $postcode, $suburb, $residence);
		
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Profile has been updated successfully.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oopps! An error occurred while updating profile.";
		}

		// echo json response
		echoResponse(200, $response); 
	}
	
	function UpdateProfilePicture() {
		$response = array();
		// reading post params
		$request = \Slim\Slim::getInstance()->request();

		$app_user_id = $request->post('user_id');	
		$thumbnail_path = '../images/profile/';
		
		$thumb_name = "";
		$thumb_tmp_name="";
		//$response["error"] = false;
		
		if(isset($_FILES["profile"]["name"]))
		{
			if($_FILES["profile"]["name"] != ""){
				$thumb_name = $_FILES["profile"]["name"];
				$temp_thumb = explode(".", $thumb_name);
				$ext_thumb = strtolower(end($temp_thumb));
				$thumb_name = time().".".$ext_thumb;
				$thumb_tmp_name = $_FILES["profile"]["tmp_name"];
				
				if(move_uploaded_file($thumb_tmp_name,$thumbnail_path.$thumb_name)){				
					$db = new DbHandler();
					$res = $db->updateProfilePicture($app_user_id, $thumb_name);
					if ($res == USER_CREATED_SUCCESSFULLY) {
						$response["error"] = false;
						$response["message"] = "Profile picture has been added successfully.";
					} else if ($res == USER_CREATE_FAILED) {
						$response["error"] = true;
						$response["message"] = "Oopps! An error occurred while adding profile picture.";
					}
				}
			}else{
				$response["error"] = true;
				$response["message"] = "File is empty.";
			}
			
		}
		else{
			$response["error"] = true;
			$response["message"] = "File is missing.";
		}

		// echo json response
		echoResponse(200, $response); 
	}
 
  /**
 * Listing all users
 * method GET
 * url /users          
 */

function GetUsers($user_role) 
{
	$response = array();
	$db = new DbHandler();

	// fetching all users
	$result = $db->getAllUsers($user_role);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["users"] = array();

	// looping through result and preparing users array
	if ($num_rows > 0) //if data exist
	{
		while ($user = $result->fetch_assoc()) {
			$tmp = array();			
			$path = ROOT_PATH."images/profile/";
			$tmp["user_id"] = $user["user_id"];
			$tmp["salutation"] = $user["salutation"];
			$tmp["first_name"] = $user["first_name"];
			$tmp["last_name"] = $user["last_name"];
			$tmp["organisation_name"] = $user["organisation_name"];
			$tmp["organisation_description"] = $user["organisation_description"];
			$tmp["address"] = $user["address"];
			$tmp["name"] = $user["first_name"].' '.$user["last_name"];
			$tmp["primary_contact"] = $user["primary_contact"];
			$tmp["phone"] = $user["phone"];
			$tmp["country"] = $user["country"];
			$tmp["suburb"] = $user["suburb"];
			$tmp["postcode"] = $user["postcode"];
			$tmp["state"] = $user["state"];
			$tmp["residence"] = $user["residence"];
			$tmp["image_url"] = $path.$user["image_url"];
			$tmp["image_name"] = $user["image_url"];
			$tmp["email"] = $user["email"];
			$tmp["category"] = $user["category"];
			$tmp["user_status"] = $user["user_status"];
			$tmp["updated_on"] = $user["updated_on"];
			$tmp["updated_by"] = $user["updated_by"];
			array_push($response["users"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "No Result Found.";
	}

	echoResponse(200, $response);
}

/**
 * Listing particular user
 * method GET
 * url /users/:id         
 */
 function GetAdmin($user_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetching all categories
	$result = $db->getAdmin($user_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["users"] = array();

	// looping through result and preparing user array
	if ($num_rows > 0) //if data exist
	{
		while ($user = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["user_id"] = $user["user_id"];
			$tmp["first_name"] = $user["first_name"];
			$tmp["last_name"] = $user["last_name"];
			$tmp["email"] = $user["email"];
			$tmp["updated_on"] = $user["updated_on"];
			$tmp["updated_by"] = $user["updated_by"];
			array_push($response["users"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
 }
 
 /**
 * Listing particular user
 * method GET
 * url /getUserInfo/:id         
 */
 function GetUserInfo($user_id) 
 {

	$response = array();
	$db = new DbHandler();

	// fetching all categories
	$result = $db->getUserInfo($user_id);
	$num_rows = $result->num_rows;

	$response["error"] = false;
	$response["users"] = array();

	// looping through result and preparing user array
	if ($num_rows > 0) //if data exist
	{
		while ($user = $result->fetch_assoc()) {
			$tmp = array();
			$path = ROOT_PATH."images/profile/";
			$tmp["user_id"] = $user["user_id"];
			$tmp["user_role"] = $user["user_role"];
			$tmp["salutation"] = $user["salutation"];
			$tmp["first_name"] = $user["first_name"];
			$tmp["last_name"] = $user["last_name"];
			$tmp["gender"] = $user["gender"];
			$tmp["date_of_birth_month"] = $user["date_of_birth_month"];
			$tmp["date_of_birth_year"] = $user["date_of_birth_year"];
			$tmp["organisation_name"] = $user["organisation_name"];
			$tmp["organisation_description"] = $user["organisation_description"];
			$tmp["address"] = $user["address"];
			$tmp["name"] = $user["first_name"].' '.$user["last_name"];
			$tmp["primary_contact"] = $user["primary_contact"];
			$tmp["phone"] = $user["phone"];
			$tmp["country"] = $user["country"];
			$tmp["suburb"] = $user["suburb"];
			$tmp["postcode"] = $user["postcode"];
			$tmp["state"] = $user["state"];
			$tmp["residence"] = $user["residence"];
			$tmp["image_url"] = $path.$user["image_url"];
			$tmp["image_name"] = $user["image_url"];
			$tmp["email"] = $user["email"];
			$tmp["category"] = $user["category"];
			$tmp["updated_on"] = $user["updated_on"];
			$tmp["updated_by"] = $user["updated_by"];
			array_push($response["users"], $tmp);
		}
	}
	else
	{
		$response["error"] = true;
		$response["message"] = "The requested resource doesn't exists";
	}
	echoResponse(200, $response);
 }



/**
 * Add Request for FNF
 * method POST
 * url - /addfnf/
 */
	function FnfRequestForAppUser() 
	{
//		$request = \Slim\Slim::getInstance()->request();		
//		$response = array();
//
//		// reading post params
//		$user_id = $request->post('user_id');
//		$user_emails = $request->post('user_emails');
//
//		$db = new DbHandler();
//		$res = $db->fnfRequestForAppUser($user_id, $user_emails);
//
//		if ($res == USER_CREATED_SUCCESSFULLY) {
//			$response["error"] = false;
//			$response["message"] = "FNF request has been send.";
//		} else if ($res == USER_CREATE_FAILED) {
//			$response["error"] = true;
//			$response["message"] = "Oops! An error occurred.";
//		}
//		// echo json response
//		echoResponse(200, $response);
		
		$return = array();
		$db = new DbHandler();
		$request = \Slim\Slim::getInstance()->request();	
		$user_id = $request->post('user_id');
		$user_emails = $request->post('user_emails');
		$return = $db->fnfRequestForAppUser($user_id, $user_emails);
		//$return = $db->getSpsMessage($sender_id, $user_id);
		echo json_encode($return);
    
	}
	
	function FnfRequestAcceptOrDecline()
	{

		$request = \Slim\Slim::getInstance()->request();	
		$response = array();

		// reading post params
		$sender_id = $request->post('sender_id');
		$receiver_id = $request->post('receiver_id');
		$accept = $request->post('accept');

		$db = new DbHandler();
		$res = $db->fnfRequestAcceptOrDecline($sender_id, $receiver_id, $accept);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "FNF has been updated.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		}
		// echo json response
		echoResponse(200, $response);
	}
	
	function RemoveFnfForAppUser() 
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$user_id = $request->post('user_id');
		$fnf_ids = $request->post('fnf_ids');

		// validating email address
		//validateEmail($email);

		$db = new DbHandler();
		$res = $db->removeFnfForAppUser($user_id, $fnf_ids);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "FNF has been removed.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	/**
 * Unfriend Request for FNF
 * method POST
 * url - /unfriendFnfs/
 */
	function UnfriendFnfs()
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$app_user_id = $request->post('app_user_id');
		$fnf_ids = $request->post('fnf_ids');

		// validating email address
		//validateEmail($email);

		$db = new DbHandler();
		$res = $db->unfriendFnfs($app_user_id, $fnf_ids);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Friends have been unfriened.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}

	function FnfRequestForResidence() 
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$res_user_id = $request->post('res_user_id');
		$frnd_user_emails = $request->post('frnd_user_emails');

		// validating email address
		//validateEmail($email);

		$db = new DbHandler();
		$res = $db->fnfRequestForResidence($res_user_id, $frnd_user_emails);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "FNF request has been send.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, some email already existed in your list.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	function DisconnectFnfForResidence() 
	{
		$request = \Slim\Slim::getInstance()->request();		
		$response = array();

		// reading post params
		$residence_id = $request->post('residence_id');
		$individual_id = $request->post('individual_id');

		$db = new DbHandler();
		$res = $db->disconnectFnfForResidence($residence_id, $individual_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "FNF has been disconnected.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		} 
		// echo json response
		echoResponse(200, $response);
    
	}

/**
 * Add Request for FNF
 * method POST
 * url - /addfnf/
 */
	function AddServiceProviderForAppUser()
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$user_id = $request->post('user_id');
		$sp_ids = '';
		if($request->post('sp_ids') != NULL){
			$sp_ids =  $request->post('sp_ids');
		}
		//$sp_ids = $request->post('sp_ids');

		// validating email address
		//validateEmail($email);

		$db = new DbHandler();
		$res = $db->addSpsForAppUser($user_id, $sp_ids);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Service providers have been updated.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, some service provider already existed in your list.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	function AddSpForAppUser()
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$app_user_id = $request->post('app_user_id');
		$sp_id =  $request->post('sp_id');

		$db = new DbHandler();
		$res = $db->addSpForAppUser($app_user_id, $sp_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Service provider has been added.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, some service provider already existed in your list.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}
	
	function ManageIndividualSpForAppUser(){
		$request = \Slim\Slim::getInstance()->request();		
		$response = array();
		// reading post params
		$app_user_id = $request->post('app_user_id');
		$sp_id =  $request->post('sp_id');

		// validating email address
		//validateEmail($email);

		$db = new DbHandler();
		$res = $db->manageIndividualSpForAppUser($app_user_id, $sp_id);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Service provider has been updated.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		}
		// echo json response
		echoResponse(200, $response);
	}

function AddServiceProviderForResidence()
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$res_user_id = $request->post('res_user_id');
		$sp_ids = $request->post('sp_ids');

		// validating email address
		//validateEmail($email);

		$db = new DbHandler();
		$res = $db->addSpsForResidence($res_user_id, $sp_ids);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Service providers have been updated.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		} else if ($res == USER_ALREADY_EXISTED) {
			$response["error"] = true;
			$response["message"] = "Sorry, No service provider selected.";
		}
		// echo json response
		echoResponse(200, $response);
    
	}


function SendMessage()
	{
		
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$sender_id = $request->post('sender_id');
		$sender_role = $request->post('sender_role');
		$receiver_role = $request->post('receiver_role');
		$message_title = 'Notice';
		$description = $request->post('description');
		$event = $request->post('event');
		$start_date = '0000-00-00';
		$start_time = '00:00';
		$end_date = '0000-00-00';
		$end_time = '00:00';
		if($event == 1){
			$start_date = $request->post('start_date');
			$start_time = $request->post('start_time');
			$end_date = $request->post('end_date');
			$end_time = $request->post('end_time');
			$message_title = $request->post('message_title');
		}
		
		$offset = $request->post('offset');
		$status = $request->post('status');
		
		$attachment_url = 'event.jpg';
		$thumbnail_path = '../images/attachments/';	
		$thumb_name = "";
		$thumb_tmp_name="";
		$db = new DbHandler();
		if(isset($_FILES["attachment"]["name"])){
			if($_FILES["attachment"]["name"] != "")
			{
				$thumb_name = $_FILES["attachment"]["name"];
				$temp_thumb = explode(".", $thumb_name);
				$ext_thumb = strtolower(end($temp_thumb));
				$thumb_name = time().".".$ext_thumb;
				$thumb_tmp_name = $_FILES["attachment"]["tmp_name"];
				
				if(move_uploaded_file($thumb_tmp_name,$thumbnail_path.$thumb_name)){
					$res = $db->sendMessage($sender_id, $sender_role, $receiver_role, $message_title, $description, $event, $start_date, $start_time, $end_date, $end_time, $offset, $status, $thumb_name);
				}
			}else{
				$res = $db->sendMessage($sender_id, $sender_role, $receiver_role, $message_title, $description, $event, $start_date, $start_time, $end_date, $end_time, $offset, $status, $attachment_url);
			}
		}else{
			$res = $db->sendMessage($sender_id, $sender_role, $receiver_role, $message_title, $description, $event, $start_date, $start_time, $end_date, $end_time, $offset, $status, $attachment_url);
		}
		

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Message has been sent.";
			GetSentBroadcast($sender_id);
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
			// echo json response
			echoResponse(200, $response);
		} 
		
    
	}
	
	function SendIndividualMessage()
	{
		// check for required params
		//verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));
		$request = \Slim\Slim::getInstance()->request();
		
		$response = array();

		// reading post params
		$sender_id = $request->post('sender_id');
		$sender_role = $request->post('sender_role');
		$receiver_id = $request->post('receiver_id');
		$message_title = $request->post('message_title');
		$description = $request->post('description');
		$status = $request->post('status');
		
		$attachment_url = 'indivisual.jpg';
		$thumbnail_path = '../images/attachments/';	
		$thumb_name = "";
		$thumb_tmp_name="";
		$db = new DbHandler();
		if(isset($_FILES["attachment"]["name"])){
			if($_FILES["attachment"]["name"] != "")
			{
				$thumb_name = $_FILES["attachment"]["name"];
				$temp_thumb = explode(".", $thumb_name);
				$ext_thumb = strtolower(end($temp_thumb));
				$thumb_name = time().".".$ext_thumb;
				$thumb_tmp_name = $_FILES["attachment"]["tmp_name"];
				
				if(move_uploaded_file($thumb_tmp_name,$thumbnail_path.$thumb_name)){
					$res = $db->sendIndividualMessage($sender_id, $sender_role, $receiver_id, $message_title, $description, $status, $thumb_name);
				}
			}else{
				$res = $db->sendIndividualMessage($sender_id, $sender_role, $receiver_id, $message_title, $description, $status, $attachment_url);
			}
		}else{
			$res = $db->sendIndividualMessage($sender_id, $sender_role, $receiver_id, $message_title, $description, $status, $attachment_url);
		}

		// validating email address
		//validateEmail($email);

		//$db = new DbHandler();
		//$res = $db->sendIndividualMessage($sender_id, $sender_role, $receiver_id, $message_title, $description, $status);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Message has been sent.";
			$page = 1;
			GetIndividualMessage($sender_id, $receiver_id, $page);
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
			// echo json response
			echoResponse(200, $response);
		} 
		
    
	}
	
	function ShareMessage()
	{
		$request = \Slim\Slim::getInstance()->request();		
		$response = array();

		// reading post params
		$message_id = $request->post('message_id');
		$description = $request->post('description');
		$shared_by = $request->post('shared_by');
		$shared_to_ids = $request->post('shared_to_ids');

		$db = new DbHandler();
		$res = $db->shareMessage($message_id, $description, $shared_by, $shared_to_ids);

		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Message has been shared.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
			
		} 
		// echo json response
		echoResponse(200, $response);
    
	}
	
	function DeleteIndividualMessage($message_id, $user_id)
	{
		$request = \Slim\Slim::getInstance()->request();
		$db = new DbHandler();
		$response = array();
		$res = $db->deleteIndividualMessage($message_id, $user_id);
		if ($res == USER_CREATED_SUCCESSFULLY) {
			$response["error"] = false;
			$response["message"] = "Message has been deleted.";
		} else if ($res == USER_CREATE_FAILED) {
			$response["error"] = true;
			$response["message"] = "Oops! An error occurred.";
		} 
		echoResponse(200, $response);
    
	}

//function GetIndividualMessage($sender_id, $receiver_id) 
// {
//	global $user_id;
//	$response = array();
//	$db = new DbHandler();
//
//	// fetch salutation
//	$result = $db->getIndividualMessage($sender_id, $receiver_id);
//	$num_rows = $result->num_rows;
//	
//	$response["error"] = false;
//	$response["messages"] = array();
//
//	if ($num_rows > 0) //if data exist
//	{
//		while ($message = $result->fetch_assoc()) {
//			$tmp = array();
//			$tmp["message_id"] = $message["message_id"];
//			$tmp["sender_role"] = $message["sender_role"];
//			$tmp["sender_id"] = $message["sender_id"];
//			$tmp["receiver_id"] = $message["receiver_id"];
//			$tmp["message_title"] = $message["message_title"];
//			$tmp["description"] = $message["description"];
//			$tmp["send_date"] = $message["sent_time"];
//			$tmp["send_time"] = $message["timestamp"];
//			array_push($response["messages"], $tmp);			
//		}
//	}
//	else {
//		$response["error"] = true;
//		$response["message"] = "No message available";
//	}
//	echoResponse(200, $response);
// }

function GetIndividualMessage($sender_id, $receiver_id, $page) 
 {
	$return = array();
	$db = new DbHandler();
	$return = $db->getIndividualMessage($sender_id, $receiver_id, $page);
	echo json_encode($return);
 }


//function GetSpsMessage($sender_id) 
// {
//	global $user_id;
//	$response = array();
//	$db = new DbHandler();
//
//	// fetch salutation
//	$result = $db->getSpsMessage($sender_id);
//	$num_rows = $result->num_rows;
//	
//	$response["error"] = false;
//	$response["messages"] = array();
//
//	if ($num_rows > 0) //if data exist
//	{
//		while ($message = $result->fetch_assoc()) {
//			$tmp = array();
//			$tmp["message_id"] = $message["message_id"];
//			$tmp["sender_role"] = $message["sender_role"];
//			$tmp["receiver_id"] = $message["receiver_id"];
//			$tmp["message_title"] = $message["message_title"];
//			$tmp["description"] = $message["description"];
//			$tmp["send_date"] = $message["sent_time"];
//			array_push($response["messages"], $tmp);			
//		}
//	}
//	else {
//		$response["error"] = true;
//		$response["message"] = "No message available";
//	}
//	echoResponse(200, $response);
// }
 
 function GetSpsMessage($sender_id, $user_id) 
 {
 	$return = array();
	$db = new DbHandler();
	$return = $db->getSpsMessage($sender_id, $user_id);
	echo json_encode($return);
 }
 
 function GetResidencePostcodeWise($postcode) 
 {
 	$return = array();
	$db = new DbHandler();
	$return = $db->getResidencePostcodeWise($postcode);
	echo json_encode($return);
 }
 
 function GetBroadcastForAppUser($app_user_id, $event, $timestamp) 
 {
	$return = array();
	$db = new DbHandler();	
	$return = $db->getBroadcastForAppUser($app_user_id, $event, $timestamp);
	echo json_encode($return);
 }
 
 function GetSentBroadcastForAppUser($sender_id, $app_user_id, $event) 
 {
	$return = array();
	$db = new DbHandler();	
	$return = $db->getSentBroadcastForAppUser($sender_id, $app_user_id, $event);
	echo json_encode($return);
 }
 
 function SearchBroadcastForAppUser($app_user_id, $event, $query)
 {
	$return = array();
	$db = new DbHandler();	
	$return = $db->searchBroadcastForAppUser($app_user_id, $event, $query);
	echo json_encode($return);
 }
 
// function GetBroadcastForAppUser($app_user_id, $event, $timestamp) 
// {
//	global $user_id;
//	$response = array();
//	$db = new DbHandler();
//
//	// fetch salutation
//	$result = $db->getBroadcastForAppUser($app_user_id, $event, $timestamp);
//	$num_rows = $result->num_rows;
//	
//	$response["error"] = false;
////	$response["app_user_id"] = $app_user_id;
////	$response["event"] = $event;
////	$response["timestamp"] = $timestamp;
//	$response["messages"] = array();
//
//	if ($num_rows > 0) //if data exist
//	{
//		while ($message = $result->fetch_assoc()) {
//			$tmp = array();
//			$tmp["user_id"] = $message["user_id"];
//			$tmp["organisation_name"] = $message["organisation_name"];
//			$tmp["image_url"] = ROOT_PATH."images/profile/".$message["image_url"];
//			$tmp["message_id"] = $message["message_id"];
//			$tmp["sender_role"] = $message["sender_role"];
//			$tmp["receiver_id"] = $message["receiver_id"];
//			$tmp["message_title"] = $message["message_title"];
//			$tmp["description"] = $message["description"];
//			$tmp["send_date"] = $message["sent_time"];
//			$tmp["start_date"] = $message["event_start_date"];
//			$tmp["end_date"] = $message["event_end_date"];
//			array_push($response["messages"], $tmp);			
//		}
//	}
//	else {
//		$response["error"] = true;
//		$response["message"] = "No message available";
//	}
//	echoResponse(200, $response);
//	//echoResponse(200, $result);
// }
 
//  function SearchBroadcastForAppUser($app_user_id, $event, $query) 
// {
//	global $user_id;
//	$response = array();
//	$db = new DbHandler();
//
//	// fetch salutation
//	$result = $db->searchBroadcastForAppUser($app_user_id, $event, $query);
//	$num_rows = $result->num_rows;
//	
//	$response["error"] = false;
//	$response["messages"] = array();
//
//	if ($num_rows > 0) //if data exist
//	{
//		while ($message = $result->fetch_assoc()) {
//			$tmp = array();
//			$tmp["user_id"] = $message["user_id"];
//			$tmp["organisation_name"] = $message["organisation_name"];
//			$tmp["image_url"] = ROOT_PATH."images/profile/".$message["image_url"];
//			$tmp["message_id"] = $message["message_id"];
//			$tmp["sender_role"] = $message["sender_role"];
//			$tmp["receiver_id"] = $message["receiver_id"];
//			$tmp["message_title"] = $message["message_title"];
//			$tmp["description"] = $message["description"];
//			$tmp["send_date"] = $message["sent_time"];
//			$tmp["start_date"] = $message["event_start_date"];
//			$tmp["end_date"] = $message["event_end_date"];
//			array_push($response["messages"], $tmp);			
//		}
//	}
//	else {
//		$response["error"] = true;
//		$response["message"] = "No message available";
//	}
//	echoResponse(200, $response);
// }
// 
 function GetSentBroadcast($sender_id) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetch salutation
	$result = $db->getSentBroadcast($sender_id);
	$num_rows = $result->num_rows;
	
	$response["error"] = false;
	$response["messages"] = array();

	if ($num_rows > 0) //if data exist
	{
		while ($message = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["message_id"] = $message["message_id"];
			$tmp["sender_role"] = $message["sender_role"];
			$tmp["sender_id"] = $message["sender_id"];
			$tmp["receiver_id"] = $message["receiver_id"];
			$tmp["event"] = $message["event"];
			$tmp["message_title"] = $message["message_title"];
			$tmp["description"] = $message["description"];
			$tmp["send_date"] = $message["sent_time"];
			$tmp["send_time"] = $message["timestamp"];
			array_push($response["messages"], $tmp);			
		}
	}
	else {
		$response["error"] = true;
		$response["message"] = "No message available";
	}
	echoResponse(200, $response);
 }
 
 function GetYourlinkNotice($receiver_role) 
 {
	global $user_id;
	$response = array();
	$db = new DbHandler();

	// fetch salutation
	$result = $db->getYourlinkNotice($receiver_role);
	$num_rows = $result->num_rows;
	
	$response["error"] = false;
	$response["messages"] = array();

	if ($num_rows > 0) //if data exist
	{
		while ($message = $result->fetch_assoc()) {
			$tmp = array();
			$tmp["message_id"] = $message["message_id"];
			$tmp["sender_role"] = $message["sender_role"];
			$tmp["receiver_id"] = $message["receiver_id"];
			$tmp["receiver_role"] = $message["receiver_role"];
			$tmp["message_title"] = $message["message_title"];
			$tmp["description"] = $message["description"];
			$tmp["send_date"] = $message["sent_time"];
			$tmp["send_time"] = $message["timestamp"];
			array_push($response["messages"], $tmp);			
		}
	}
	else {
		$response["error"] = true;
		$response["message"] = "No message available";
	}
	echoResponse(200, $response);
 }



$app->run();



/**
 * ----------- METHODS WITHOUT AUTHENTICATION ---------------------------------
 */
 
 // /**
 // * User Registration
 // * url - /register
 // * method - POST
 // * params - name, email, password
 // */
// $app->post('/users', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('first_name', 'last_name', 'email', 'password'));

            // $response = array();

            // // reading post params
            // $first_name = $app->request->post('first_name');
			// $last_name = $app->request->post('last_name');
            // $email = $app->request->post('email');
            // $password = $app->request->post('password');

            // // validating email address
            // validateEmail($email);

            // $db = new DbHandler();
            // $res = $db->createUser($first_name, $last_name, $email, $password);

            // if ($res == USER_CREATED_SUCCESSFULLY) {
                // $response["error"] = false;
                // $response["message"] = "You are successfully registered";
            // } else if ($res == USER_CREATE_FAILED) {
                // $response["error"] = true;
                // $response["message"] = "Oops! An error occurred while registereing";
            // } else if ($res == USER_ALREADY_EXISTED) {
                // $response["error"] = true;
                // $response["message"] = "Sorry, this email already existed";
            // }
            // // echo json response
            // echoResponse(201, $response);
        // });
		
/**
 * Listing all users
 * method GET
 * url /tasks          
 */
// $app->get('/users', 'authenticate', function() {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all user tasks
            // $result = $db->getAllUsers();

            // $response["error"] = false;
            // $response["users"] = array();

            // // looping through result and preparing tasks array
            // while ($user = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["user_id"] = $user["user_id"];
				// $tmp["first_name"] = $user["first_name"];
                // $tmp["last_name"] = $user["last_name"];
                // $tmp["user_status"] = $user["user_status"];
                // $tmp["updated_on"] = $user["updated_on"];
				// $tmp["updated_by"] = $user["updated_by"];
                // array_push($response["users"], $tmp);
            // }

            // echoResponse(200, $response);
        // });

 
// /**
 // * User Registration
 // * url - /register
 // * method - POST
 // * params - name, email, password
 // */
// $app->post('/register', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('name', 'email', 'password'));

            // $response = array();

            // // reading post params
            // $name = $app->request->post('name');
            // $email = $app->request->post('email');
            // $password = $app->request->post('password');

            // // validating email address
            // validateEmail($email);

            // $db = new DbHandler();
            // $res = $db->createUser($name, $email, $password);

            // if ($res == USER_CREATED_SUCCESSFULLY) {
                // $response["error"] = false;
                // $response["message"] = "You are successfully registered";
            // } else if ($res == USER_CREATE_FAILED) {
                // $response["error"] = true;
                // $response["message"] = "Oops! An error occurred while registereing";
            // } else if ($res == USER_ALREADY_EXISTED) {
                // $response["error"] = true;
                // $response["message"] = "Sorry, this email already existed";
            // }
            // // echo json response
            // echoResponse(201, $response);
        // });

// /**
 // * User Login
 // * url - /login
 // * method - POST
 // * params - email, password
 // */
// $app->post('/login', function() use ($app) {
            // // check for required params
            // //verifyRequiredParams(array('email', 'password'));
			
			// //$app = \Slim\Slim::getInstance();
			// //if request data type json
			// //$json_request = json_decode($app->$request()->getBody());
			// //$email = $json_request->email;
			// //$password = $json_request->password;
			
			// //$request = \Slim\Slim::getInstance()->request();
			// //if request data type json
			// //$json_request = json_decode($request->getBody());
			// //$email = $json_request('email');
			// //$password = $json_request->password;
			
			// //$req = $app->request(); // Getting parameter with names
			// //$email = $req->params('email');
			// //$password = $req->params('password');

            // // reading post params
            // $email = $app->request()->post('email');
            // $password = $app->request()->post('password');
			
            // $response = array();
			
			// //$response['error'] = true;
            // //$response['message'] = $email;
			// //$response['message'] = "Hello";

            // $db = new DbHandler();
            // // check for correct email and password
            // if ($db->checkLogin($email, $password)) {
                // // get the user by email
                // $user = $db->getUserByEmail($email);

                // if ($user != NULL) {
                    // $response["error"] = false;
					// $response['message'] = 'You are successfully login';
                    // $response['user_name'] = $user['first_name']." ".$user['last_name'];
                    // $response['email'] = $user['email'];
                    // $response['api_key'] = $user['api_key'];
                    // $response['updated_on'] = $user['updated_on'];
					
                // } else {
                    // // unknown error occurred
                    // $response['error'] = true;
                    // $response['message'] = "An error occurred. Please try again";
                // }
            // } else {
                // // user credentials are wrong
                // $response['error'] = true;
                // $response['message'] = 'Login failed. Incorrect credentials';
            // }

            // echoResponse(200, $response);
        // });

// /*
 // * ------------------------ METHODS WITH AUTHENTICATION ------------------------
 // */

// /**
 // * Listing all tasks of particual user
 // * method GET
 // * url /tasks          
 // */
// $app->get('/tasks', 'authenticate', function() {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all user tasks
            // $result = $db->getAllUserTasks($user_id);

            // $response["error"] = false;
            // $response["tasks"] = array();

            // // looping through result and preparing tasks array
            // while ($task = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["id"] = $task["id"];
                // $tmp["task"] = $task["task"];
                // $tmp["status"] = $task["status"];
                // $tmp["createdAt"] = $task["created_at"];
                // array_push($response["tasks"], $tmp);
            // }

            // echoResponse(200, $response);
        // });

// /**
 // * Listing single task of particual user
 // * method GET
 // * url /tasks/:id
 // * Will return 404 if the task doesn't belongs to user
 // */
// $app->get('/tasks/:id', 'authenticate', function($task_id) {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetch task
            // $result = $db->getTask($task_id, $user_id);

            // if ($result != NULL) {
                // $response["error"] = false;
                // $response["id"] = $result["id"];
                // $response["task"] = $result["task"];
                // $response["status"] = $result["status"];
                // $response["createdAt"] = $result["created_at"];
                // echoResponse(200, $response);
            // } else {
                // $response["error"] = true;
                // $response["message"] = "The requested resource doesn't exists";
                // echoResponse(404, $response);
            // }
        // });

// /**
 // * Creating new category in db
 // * method POST
 // * params - category_name
 // * url - /categories/
 // */
// $app->post('/categories', 'authenticate', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('category_name'));

            // $response = array();
            // $category_name = $app->request->post('category_name');

            // global $user_id;
            // $db = new DbHandler();

            // // creating new category
            // $res = $db->createCategory($category_name,$user_id);

			// if ($res == USER_CREATED_SUCCESSFULLY) {
				// $response["error"] = false;
				// $response["message"] = "New category has been added successfully.";
				// echoResponse(201, $response);
			// } else if ($res == USER_CREATE_FAILED) {
				// $response["error"] = true;
				// $response["message"] = "Failed to create category. Please try again.";
				// echoResponse(200, $response);
			// } else if ($res == USER_ALREADY_EXISTED) {
				// $response["error"] = true;
				// $response["message"] = "Sorry, this category already existed.";
				// echoResponse(200, $response);
			// }            
        // });

// /**
 // * Listing all categories
 // * method GET
 // * url /categories          
 // */
// $app->get('/categories',  function() {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all user tasks
            // $result = $db->getAllCategories();

            // $response["error"] = false;
            // $response["categories"] = array();

            // // looping through result and preparing category array
            // while ($category = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["category_id"] = $category["category_id"];
                // $tmp["category_name"] = $category["category_name"];
                // $tmp["updated_on"] = $category["updated_on"];
				// $tmp["updated_by"] = $category["updated_by"];
                // array_push($response["categories"], $tmp);
            // }

            // echoResponse(200, $response);
        // });

// /**
 // * Listing all categories
 // * method GET
 // * url /categories          
 // */
// $app->get('/categories/:id',  function($category_id) {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all user tasks
            // $result = $db->getCategory($category_id);

            // $response["error"] = false;
            // $response["categories"] = array();

            // // looping through result and preparing category array
            // while ($category = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["category_id"] = $category["category_id"];
                // $tmp["category_name"] = $category["category_name"];
                // $tmp["updated_on"] = $category["updated_on"];
				// $tmp["updated_by"] = $category["updated_by"];
                // array_push($response["categories"], $tmp);
            // }

            // echoResponse(200, $response);
        // });


// /**
 // * Creating new salutation in db
 // * method POST
 // * params - salutation_name
 // * url - /salutations/
 // */
// $app->post('/salutations', 'authenticate', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('salutation_name'));

            // $response = array();
            // $salutation_name = $app->request->post('salutation_name');

            // global $user_id;
            // $db = new DbHandler();

            // // creating new category
            // $res = $db->createSalutation($salutation_name,$user_id);

			// if ($res == USER_CREATED_SUCCESSFULLY) {
				// $response["error"] = false;
				// $response["message"] = "New salutation has been added successfully.";
				// echoResponse(201, $response);
			// } else if ($res == USER_CREATE_FAILED) {
				// $response["error"] = true;
				// $response["message"] = "Failed to create salutation. Please try again.";
				// echoResponse(200, $response);
			// } else if ($res == USER_ALREADY_EXISTED) {
				// $response["error"] = true;
				// $response["message"] = "Sorry, this salutation already existed.";
				// echoResponse(200, $response);
			// }            
        // });

// /**
 // * Listing all salutations
 // * method GET
 // * url /salutations          
 // */
// $app->get('/salutations',  function() {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all salutations
            // $result = $db->getAllSalutations();

            // $response["error"] = false;
            // $response["salutations"] = array();

            // // looping through result and preparing salutation array
            // while ($salutation = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["salutation_id"] = $salutation["salutation_id"];
                // $tmp["salutation_name"] = $salutation["salutation_name"];
                // $tmp["updated_on"] = $salutation["updated_on"];
				// $tmp["updated_by"] = $salutation["updated_by"];
                // array_push($response["salutations"], $tmp);
            // }

            // echoResponse(200, $response);
        // });

// /**
 // * Creating new state in db
 // * method POST
 // * params - state_name
 // * url - /states/
 // */
// $app->post('/states', 'authenticate', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('state_name'));

            // $response = array();
            // $state_name = $app->request->post('state_name');

            // global $user_id;
            // $db = new DbHandler();

            // // creating new category
            // $res = $db->createState($state_name,$user_id);

			// if ($res == USER_CREATED_SUCCESSFULLY) {
				// $response["error"] = false;
				// $response["message"] = "New state has been added successfully.";
				// echoResponse(201, $response);
			// } else if ($res == USER_CREATE_FAILED) {
				// $response["error"] = true;
				// $response["message"] = "Failed to create state. Please try again.";
				// echoResponse(200, $response);
			// } else if ($res == USER_ALREADY_EXISTED) {
				// $response["error"] = true;
				// $response["message"] = "Sorry, this state already existed.";
				// echoResponse(200, $response);
			// }            
        // });

// /**
 // * Listing all states
 // * method GET
 // * url /states          
 // */
// $app->get('/states',  function() {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all salutations
            // $result = $db->getAllStates();

            // $response["error"] = false;
            // $response["states"] = array();

            // // looping through result and preparing state array
            // while ($state = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["state_id"] = $state["state_id"];
                // $tmp["state_name"] = $state["state_name"];
                // $tmp["updated_on"] = $state["updated_on"];
				// $tmp["updated_by"] = $state["updated_by"];
                // array_push($response["states"], $tmp);
            // }

            // echoResponse(200, $response);
        // });

// /**
 // * Creating new postcode in db
 // * method POST
 // * params - state_id
 // * params - postcode_name
 // * url - /postcodes/
 // */
// $app->post('/postcodes', 'authenticate', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('state_id','postcode_name'));

            // $response = array();
			// $state_id = $app->request->post('state_id');
            // $postcode_name = $app->request->post('postcode_name');

            // global $user_id;
            // $db = new DbHandler();

            // // creating new category
            // $res = $db->createPostcode($state_id,$postcode_name,$user_id);

			// if ($res == USER_CREATED_SUCCESSFULLY) {
				// $response["error"] = false;
				// $response["message"] = "New postcode has been added successfully.";
				// echoResponse(201, $response);
			// } else if ($res == USER_CREATE_FAILED) {
				// $response["error"] = true;
				// $response["message"] = "Failed to create postcode. Please try again.";
				// echoResponse(200, $response);
			// } else if ($res == USER_ALREADY_EXISTED) {
				// $response["error"] = true;
				// $response["message"] = "Sorry, this postcode already existed.";
				// echoResponse(200, $response);
			// }            
        // });

// /**
 // * Listing all postcodes
 // * method GET
 // * url /postcodes          
 // */
// $app->get('/postcodes', 'authenticate', function() {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all salutations
            // $result = $db->getAllPostcodes();

            // $response["error"] = false;
            // $response["postcodes"] = array();

            // // looping through result and preparing postcode array
            // while ($postcode = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["postcode_id"] = $postcode["postcode_id"];
				// $tmp["state_id"] = $postcode["state_id"];
                // $tmp["postcode_name"] = $postcode["postcode_name"];
                // $tmp["updated_on"] = $postcode["updated_on"];
                // array_push($response["postcodes"], $tmp);
            // }

            // echoResponse(200, $response);
        // });

// /**
 // * Listing all postcodes of particular state
 // * method GET
 // * url /postcodes/:id          
 // */
// $app->get('/postcodes/:id', 'authenticate', function($state_id) {
            // global $user_id;
            // $response = array();
            // $db = new DbHandler();

            // // fetching all postcodes of particular state
            // $result = $db->getAllPostcodesByState($state_id);

            // $response["error"] = false;
            // $response["postcodes"] = array();

            // // looping through result and preparing postcode array
            // while ($postcode = $result->fetch_assoc()) {
                // $tmp = array();
                // $tmp["postcode_id"] = $postcode["postcode_id"];
				// $tmp["state_id"] = $postcode["state_id"];
                // $tmp["postcode_name"] = $postcode["postcode_name"];
                // $tmp["updated_on"] = $postcode["updated_on"];
                // array_push($response["postcodes"], $tmp);
            // }

            // echoResponse(200, $response);
        // });

// /**
 // * Creating new suburb in db
 // * method POST
 // * params - postcode_id
 // * params - suburb_name
 // * url - /suburbs/
 // */
// $app->post('/suburbs', 'authenticate', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('postcode_id','suburb_name'));

            // $response = array();
			// $postcode_id = $app->request->post('postcode_id');
            // $suburb_name = $app->request->post('suburb_name');

            // global $user_id;
            // $db = new DbHandler();

            // // creating new category
            // $res = $db->createSuburb($postcode_id,$suburb_name,$user_id);

			// if ($res == USER_CREATED_SUCCESSFULLY) {
				// $response["error"] = false;
				// $response["message"] = "New suburb has been added successfully.";
				// echoResponse(201, $response);
			// } else if ($res == USER_CREATE_FAILED) {
				// $response["error"] = true;
				// $response["message"] = "Failed to create suburb. Please try again.";
				// echoResponse(200, $response);
			// } else if ($res == USER_ALREADY_EXISTED) {
				// $response["error"] = true;
				// $response["message"] = "Sorry, this suburb already existed.";
				// echoResponse(200, $response);
			// }            
        // });

// /**
 // * Creating new task in db
 // * method POST
 // * params - name
 // * url - /tasks/
 // */
// $app->post('/tasks', 'authenticate', function() use ($app) {
            // // check for required params
            // verifyRequiredParams(array('task'));

            // $response = array();
            // $task = $app->request->post('task');

            // global $user_id;
            // $db = new DbHandler();

            // // creating new task
            // $task_id = $db->createTask($user_id, $task);

            // if ($task_id != NULL) {
                // $response["error"] = false;
                // $response["message"] = "Task created successfully";
                // $response["task_id"] = $task_id;
                // echoResponse(201, $response);
            // } else {
                // $response["error"] = true;
                // $response["message"] = "Failed to create task. Please try again";
                // echoResponse(200, $response);
            // }            
        // });

// /**
 // * Updating existing task
 // * method PUT
 // * params task, status
 // * url - /tasks/:id
 // */
// $app->put('/tasks/:id', 'authenticate', function($task_id) use($app) {
            // // check for required params
            // verifyRequiredParams(array('task', 'status'));

            // global $user_id;            
            // $task = $app->request->put('task');
            // $status = $app->request->put('status');

            // $db = new DbHandler();
            // $response = array();

            // // updating task
            // $result = $db->updateTask($user_id, $task_id, $task, $status);
            // if ($result) {
                // // task updated successfully
                // $response["error"] = false;
                // $response["message"] = "Task updated successfully";
            // } else {
                // // task failed to update
                // $response["error"] = true;
                // $response["message"] = "Task failed to update. Please try again!";
            // }
            // echoResponse(200, $response);
        // });

// /**
 // * Deleting task. Users can delete only their tasks
 // * method DELETE
 // * url /tasks
 // */
// $app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {
            // global $user_id;

            // $db = new DbHandler();
            // $response = array();
            // $result = $db->deleteTask($user_id, $task_id);
            // if ($result) {
                // // task deleted successfully
                // $response["error"] = false;
                // $response["message"] = "Task deleted succesfully";
            // } else {
                // // task failed to delete
                // $response["error"] = true;
                // $response["message"] = "Task failed to delete. Please try again!";
            // }
            // echoResponse(200, $response);
        // });

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoResponse(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

//$app->run();
?>