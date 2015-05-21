<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbHandler {

    private $conn;

    function __construct() {
    	date_default_timezone_set('UTC');
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /* ------------- `users` table method ------------------ */
	
	/**
     * Creating new user as admin
     * @param String $first_name
	 * @param String $last_name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function createUser($first_name, $last_name, $email, $password) {
        require_once 'PassHash.php';
        $response = array();
		$user_id=1;
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $api_key = $this->generateApiKey();

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users(user_role, user_status, first_name, last_name, email, password, api_key, created_on, created_by, updated_on, updated_by) values(0, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssisi", $first_name, $last_name, $email, $password_hash, $api_key, $dateTime, $user_id, $dateTime, $user_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }
    /* update admin user */
    public function updateUser($user_id, $first_name, $last_name, $email, $password) {
        require_once 'PassHash.php';
        $response = array();
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);

        // First check if user already existed in db
        if (!$this->checkUserExistenceForUpdate($user_id, $email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // insert query
            $stmt = $this->conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, updated_on = ?, updated_by = ? WHERE user_id = ?");
            $stmt->bind_param("sssssii", $first_name, $last_name, $email, $password_hash, $dateTime, $user_id, $user_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }
	
	/**
     * Creating new user for app user
     * @param String $first_name
	 * @param String $last_name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function appRegistration($salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $image_url, $country, $state, $postcode, $suburb, $residence, $email, $password) {
        require_once 'PassHash.php';
        $response = array();
		$user_id = 1;
		$category = 1;
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
		
		// Generating password hash
        $password_hash = PassHash::hash($password);

        // Generating API key
        $api_key = $this->generateApiKey();

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users(user_role, user_status, salutation, first_name, last_name, gender, date_of_birth_month, date_of_birth_year, phone, category, image_url, country, state, postcode, suburb, residence, email, password, api_key, created_on, created_by, updated_on, updated_by) values(1, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssisssssissssisi", $salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $category, $image_url, $country, $state, $postcode, $suburb, $residence, $email, $password_hash, $api_key, $dateTime, $user_id, $dateTime, $user_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
				//update relationship for that requested before registration
//				$user = $this->getUserByEmail($email);
//				$second_user_id = $user['user_id'];
//				$active = 1;
//				$this->updateAppApp($second_user_id, $active, $email);
//				$this->updateResidenceApp($second_user_id, $active, $email);
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
        	if (!$this->isUserActive($email)){
				$user = $this->getUserByEmail($email);
				$app_user_id = $user['user_id'];
				return $this->updateInvitedAppUser($app_user_id, $salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $category, $image_url, $country, $state, $postcode, $suburb, $residence, $password_hash, $api_key);
			}else{
				// User with same email already existed in the db
            	return USER_ALREADY_EXISTED;
			}
            
        }

        //return $response;
    }
    
    public function updateInvitedAppUser($app_user_id, $salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $category, $image_url, $country, $state, $postcode, $suburb, $residence, $password_hash, $api_key) {
        $response = array();
        $unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
        $stmt = $this->conn->prepare("UPDATE users SET user_role = 1, user_status = 1, salutation = ?, first_name = ?, last_name = ?, gender = ?, date_of_birth_month = ?, date_of_birth_year = ?, phone = ?, category = ?, image_url = ?, country = ?, state = ?, postcode = ?, suburb = ?, residence = ?, password = ?, api_key = ?, created_on = ?, created_by = ?, updated_on = ?, updated_by = ? WHERE user_id = ?");
        $stmt->bind_param("sssssssisssssisssisii", $salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $category, $image_url, $country, $state, $postcode, $suburb, $residence, $password_hash, $api_key, $dateTime, $app_user_id, $dateTime, $app_user_id, $app_user_id);        
        $result = $stmt->execute();
        $stmt->close();
        
        // Check for successful insertion
        if ($result) {
            return USER_CREATED_SUCCESSFULLY;
        } else {
            return USER_CREATE_FAILED;
        }

        return $response;
    }
    
    public function updateAppProfile($app_user_id, $salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $country, $state, $postcode, $suburb, $residence) {
        $response = array();
        $unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
        $stmt = $this->conn->prepare("UPDATE users SET salutation = ?, first_name = ?, last_name = ?, gender = ?, date_of_birth_month = ?, date_of_birth_year = ?, phone = ?, country = ?, state = ?, postcode = ?, suburb = ?, residence = ?, updated_on = ?, updated_by = ? WHERE user_id = ?");
        $stmt->bind_param("sssssssssssisii", $salutation, $first_name, $last_name, $gender, $date_of_birth_month, $date_of_birth_year, $phone, $country, $state, $postcode, $suburb, $residence, $dateTime, $app_user_id, $app_user_id);        
        $result = $stmt->execute();
        $stmt->close();
        
        // Check for successful insertion
        if ($result) {
            return USER_CREATED_SUCCESSFULLY;
        } else {
            return USER_CREATE_FAILED;
        }

        return $response;
    }
    
    /**
     * Creating new user for app user
     * @param String $first_name
	 * @param String $last_name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function updateProfilePicture($app_user_id, $thumb_name) {
        $response = array();
        $stmt = $this->conn->prepare("UPDATE users SET image_url = ? WHERE user_id = ?");
        $stmt->bind_param("si", $thumb_name, $app_user_id);
        $result = $stmt->execute();
        $stmt->close();

        // Check for successful insertion
        if ($result) {
            return USER_CREATED_SUCCESSFULLY;
        } else {
            return USER_CREATE_FAILED;
        }

        return $response;
    }
	
	/**
     * Creating new user for service provider or residence user
     * @param String $first_name
	 * @param String $last_name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function spRegistration($user_role, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password) {
        require_once 'PassHash.php';
        $response = array();
		$user_id=0;
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
		$user_status = 1;

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $api_key = $this->generateApiKey();

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users(user_role, user_status, organisation_name, address, country, state, postcode, suburb, primary_contact, phone, image_url, category, organisation_description, email, password, api_key, created_on, created_by, updated_on, updated_by) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssssssssisssssisi", $user_role, $user_status, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password_hash, $api_key, $dateTime, $user_id, $dateTime, $user_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
//				//if residence
//				if($user_role == 3){
//					//update relationship that requested before registration
//					$user = $this->getUserByEmail($email);
//					$second_residence_id = $user['user_id'];
//					$active = 'true';
//					$this->updateResRes($second_residence_id, $active, $email);				
//				}
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }
    
    /**
     * Change password
     * @param INT $user_id
     * @param String $password
     */
    public function changePassword($user_id, $old_password, $new_password) {
        require_once 'PassHash.php';
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
		$password_hash = PassHash::hash($new_password);
		
		
		$stmt = $this->conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($password);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (PassHash::check_password($password, $old_password)) {
                // User password is correct
                $stmt = $this->conn->prepare("UPDATE users SET password = ?, updated_on = ? WHERE user_id = ?");
		        $stmt->bind_param("ssi", $password_hash, $dateTime, $user_id);
		        $result = $stmt->execute();
		        $stmt->close();
		        return USER_CREATED_SUCCESSFULLY;
            } else {
                // user password is incorrect
                return USER_ALREADY_EXISTED;
            }
        } else {
            $stmt->close();
            // user not existed with the email
            return USER_CREATE_FAILED;
        }

    }
    
    public function forgotPassword($email) {	
		$stmt = $this->conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $activation_code = rand(10000, 99999);
            $stmt = $this->conn->prepare("UPDATE users SET activation_code = ? WHERE email = ?");
	        $stmt->bind_param("is", $activation_code, $email);
	        $result = $stmt->execute();
	        $stmt->close();
	        //send activation code by email
	        $subject = "Forgot password activation code.";
			$message = "Dear Yourlink App User,\r\nYour yourlink's activation code is ".$activation_code;
			$headers = 'From: '.YOURLINK_EMAIL. "\r\n" .
    			'Reply-To: '. REPLY_TO_EMAIL . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
			mail($email,$subject,$message,$headers) ;
	        
	        return USER_CREATED_SUCCESSFULLY;
        } else {
            $stmt->close();
            // user not existed with the email
            return USER_EMAIL_NOT_MATCH;
        }

    }
    
    public function activateForgotPassword($email, $new_password, $activation_code) {
        require_once 'PassHash.php';
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
		$password_hash = PassHash::hash($new_password);
		
		
		$stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ? AND activation_code = ?");
        $stmt->bind_param("si", $email, $activation_code);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt = $this->conn->prepare("UPDATE users SET password = ?, updated_on = ? WHERE user_id = ?");
	        $stmt->bind_param("ssi", $password_hash, $dateTime, $user_id);
	        $result = $stmt->execute();
	        $stmt->close();
	        return USER_CREATED_SUCCESSFULLY;
        } else {
            $stmt->close();
            // user not existed with the email
            return USER_EMAIL_NOT_MATCH;
        }

    }
    
    public function manageLike($sp_id, $app_user_id) {
    	//if app user already like or dislike this sp
    	if($this->isAppExistsInStars($sp_id, $app_user_id)){
    		//if app user already like this sp
    		if($this->isAppAlreadyLikeTheSp($sp_id, $app_user_id)){
    			$stmt = $this->conn->prepare("UPDATE stars SET active = 0 WHERE sp_id = ? AND app_user_id = ?");
	            $stmt->bind_param("ii", $sp_id, $app_user_id);
	            $result = $stmt->execute();
	            
	            $this->manageStarInUserTable($sp_id, false);
	            $stmt->close();
				
			}else{
				$stmt = $this->conn->prepare("UPDATE stars SET active = 1 WHERE sp_id = ? AND app_user_id = ?");
	            $stmt->bind_param("ii", $sp_id, $app_user_id);
	            $result = $stmt->execute();
	            
	            $this->manageStarInUserTable($sp_id, true);
	            $stmt->close();
			}
			
		}else{
			// insert query
            $stmt = $this->conn->prepare("INSERT INTO stars(sp_id, app_user_id) values(?, ?)");
            $stmt->bind_param("ii", $sp_id, $app_user_id);
            $result = $stmt->execute();

            $this->manageStarInUserTable($sp_id, true);
	        $stmt->close();	        
		}

		if($result){
			return USER_CREATED_SUCCESSFULLY;
		}else{
			return USER_CREATE_FAILED;
		}
    }
    
    private function isAppExistsInStars($sp_id,$app_user_id) {
        $stmt = $this->conn->prepare("SELECT star_id from stars WHERE sp_id = ? AND app_user_id = ?");
        $stmt->bind_param("ii", $sp_id,$app_user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function isAppAlreadyLikeTheSp($sp_id,$app_user_id) {
        $stmt = $this->conn->prepare("SELECT star_id from stars WHERE sp_id = ? AND app_user_id = ? AND active = 1");
        $stmt->bind_param("ii", $sp_id,$app_user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function manageStarInUserTable($sp_id, $like) {
		if($like){
			$stmt = $this->conn->prepare("UPDATE users SET star = star + 1 WHERE user_id = ?");	        
		}else{
			$stmt = $this->conn->prepare("UPDATE users SET star = star - 1 WHERE user_id = ?");
		}
        $stmt->bind_param("i", $sp_id);
	    $stmt->execute();

    }
    
    /**
     * Change Email
     * @param INT $user_id
     * @param String $email
     */
    public function changeEmail($user_id, $old_email, $new_email) {
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
		
		if($this->checkUserExistenceForChangeEmail($user_id, $old_email)){
			if (!$this->checkUserExistenceForUpdate($user_id, $new_email)){
				$stmt = $this->conn->prepare("UPDATE users SET email = ?, updated_on = ? WHERE user_id = ?");
		        $stmt->bind_param("ssi", $new_email, $dateTime, $user_id);
		        $result = $stmt->execute();
		        $stmt->close();
		        
		        if ($result) {
		            return USER_CREATED_SUCCESSFULLY;
		        } else {
		            // Failed to create user
		            return USER_CREATE_FAILED;
		        }
			}else {
	            // User with same email already existed in the db
	            return USER_ALREADY_EXISTED;
	        }
		}else{
			return USER_EMAIL_NOT_MATCH;
		}
		
		
		
		

    }
    
    public function updateProfile($user_id, $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password) {
        require_once 'PassHash.php';
        $response = array();
		$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);

        // First check if user already existed in db
        if (!$this->checkUserExistenceForUpdate($user_id, $email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);


            // insert query
            $update_query = "UPDATE users SET organisation_name = ?, address = ?, country = ?, state = ?, postcode = ?, suburb = ?, primary_contact = ?, phone = ?, image_url = ?, category = ?, organisation_description = ?, email = ?, password = ?, updated_on = ?, updated_by = ? WHERE user_id = ?";
            $stmt = $this->conn->prepare($update_query);
            $stmt->bind_param("sssssssssissssii", $organisation_name, $address, $country, $state, $postcode, $suburb, $primary_contact, $phone, $image_url, $category, $organisation_description, $email, $password_hash, $dateTime, $user_id, $user_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }
	
	private function updateResRes($second_residence_id, $active, $email) {
        $stmt = $this->conn->prepare("UPDATE residencesresidences SET second_residence_id = ?, active = ? WHERE second_residence_email = ?");
		$stmt->bind_param("iss", $second_residence_id, $active, $email);
		$result = $stmt->execute();
		$stmt->close();
        return $result;
    }
	private function updateAppApp($second_user_id, $active, $email) {
        $stmt = $this->conn->prepare("UPDATE appusersappusers SET second_user_id = ?, active = ? WHERE second_user_email = ?");
		$stmt->bind_param("iis", $second_user_id, $active, $email);
		$result = $stmt->execute();
		$stmt->close();
        return $result;
    }
    
    private function updateResidenceApp($second_user_id, $active, $email) {
        $stmt = $this->conn->prepare("UPDATE residencesindividuals SET individual_id = ?, active = ? WHERE individual_email = ?");
		$stmt->bind_param("iis", $second_user_id, $active, $email);
		$result = $stmt->execute();
		$stmt->close();
        return $result;
    }

    /**
     * Creating new user
     * @param String $name User full name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function createUser_old($name, $email, $password) {
        require_once 'PassHash.php';
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $api_key = $this->generateApiKey();

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users(name, email, password_hash, api_key, status) values(?, ?, ?, ?, 1)");
            $stmt->bind_param("ssss", $name, $email, $password_hash, $api_key);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }

    /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
    public function checkLogin($email, $user_password) {
        // fetching user by email
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->bind_result($password);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Found user with the email
            // Now verify the password

            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password, $user_password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            $stmt->close();

            // user not existed with the email
            return FALSE;
        }
    }

    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT user_id from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function isUserActive($email) {
        $stmt = $this->conn->prepare("SELECT user_id from users WHERE email = ? AND user_status = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function checkUserExistenceForUpdate($user_id, $email){
		$stmt = $this->conn->prepare("SELECT user_id from users WHERE user_id <> ? AND email = ?");
        $stmt->bind_param("is", $user_id, $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
	
	private function checkUserExistenceForChangeEmail($user_id, $email){
		$stmt = $this->conn->prepare("SELECT user_id from users WHERE user_id = ? AND email = ?");
        $stmt->bind_param("is", $user_id, $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}

    /**
     * Fetching user by email
     * @param String $email User email id
     */

	 public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT user_id, user_role,first_name, last_name,organisation_name, email, api_key, user_status, postcode, image_url, updated_on FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
	
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $user_role, $first_name, $last_name, $organisation_name, $email, $api_key, $user_status, $postcode, $image_url, $updated_on);
            $stmt->fetch();
            $user = array();
			$user["user_id"] = $user_id;
			$user["user_role"] = $user_role;
            $user["first_name"] = $first_name;
			$user["last_name"] = $last_name;
			$user["organisation_name"] = $organisation_name;
            $user["email"] = $email;
            $user["api_key"] = $api_key;
            $user["user_status"] = $user_status;
            $user["postcode"] = $postcode;
            $user["image_url"] = $image_url;
            $user["updated_on"] = $updated_on;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
		
    }
    
    public function getNumberOfLikeOfUser($user_id) {
        $stmt = $this->conn->prepare("SELECT star FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
	
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($star);
            $stmt->fetch();
            //$stmt->close();
            return $star;
        } else {
            return NULL;
        }
		
    }
    
    /**
     * Fetching user by email
     * @param String $email User email id
     */

	 public function getUserByEmailAndRole($email, $user_role) {
        $stmt = $this->conn->prepare("SELECT user_id, user_role,first_name, last_name,organisation_name, email, api_key, user_status, postcode, image_url, updated_on FROM users WHERE email = ? AND user_role = ?");
        $stmt->bind_param("si", $email, $user_role);
	
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $user_role, $first_name, $last_name, $organisation_name, $email, $api_key, $user_status, $postcode, $image_url, $updated_on);
            $stmt->fetch();
            $user = array();
			$user["user_id"] = $user_id;
			$user["user_role"] = $user_role;
            $user["first_name"] = $first_name;
			$user["last_name"] = $last_name;
			$user["organisation_name"] = $organisation_name;
            $user["email"] = $email;
            $user["api_key"] = $api_key;
            $user["user_status"] = $user_status;
            $user["postcode"] = $postcode;
            $user["image_url"] = $image_url;
            $user["updated_on"] = $updated_on;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
		
    }

	/**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT user_id, user_role,first_name, last_name, email, user_status, updated_on FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
		//$stmt->execute();
		//$result = $stmt->get_result();
		//$num_rows = $result->num_rows;
	
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $user_role, $first_name, $last_name, $email, $user_status, $updated_on);
            $stmt->fetch();
            $user = array();
			$user["user_id"] = $user_id;
			$user["user_role"] = $user_role;
            $user["first_name"] = $first_name;
			$user["last_name"] = $last_name;
            $user["email"] = $email;
            $user["user_status"] = $user_status;
            $user["updated_on"] = $updated_on;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user api key
     * @param String $user_id user id primary key in user table
     */
    public function getApiKeyById($user_id) {
        $stmt = $this->conn->prepare("SELECT api_key FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }
	
	/**
     * Fetching all users
     * @param String
     */
    public function getAllUsers($user_role) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_role = ?");
        $stmt->bind_param("i", $user_role);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getUserId($api_key) {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT user_id from users WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }
    
/*===============================================================================*/
/*========================== `LevelOneClass` table method ==========================*/
/*===============================================================================*/
	/**
     * Creating new LevelOneClass
     * @param int $user_id who created the LevelOneClass
     * @param String $category_name
     */
    public function createLevelOneClass($level_one_class_name,$level_one_class_order,$level_one_class_contain_level_two,$user_id) {
		if (!$this->isClassExists($level_one_class_name)) 
		{
			$stmt = $this->conn->prepare("INSERT INTO level_one_classes(level_one_class_name,level_one_class_order,level_one_class_contain_level_two,updated_by) VALUES(?,?,?,?)");
			$stmt->bind_param("sisi", $level_one_class_name,$level_one_class_order,$level_one_class_contain_level_two,$user_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // category with same category_name already existed in the db
        }
        
    }
	
	/**
     * Updating category
     * @param int $category_id
     * @param String $category_name
     */
    public function updateLevelOneClass($level_one_class_id, $level_one_class_name,$level_one_class_order,$level_one_class_contain_level_two,$user_id) {
		if (!$this->checkClassExistenceForUpdate($level_one_class_id, $level_one_class_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE level_one_classes SET level_one_class_name = ?,level_one_class_order=?,level_one_class_contain_level_two=?,updated_by = ? WHERE level_one_class_id = ?");
			$stmt->bind_param("sisii", $level_one_class_name,$level_one_class_order,$level_one_class_contain_level_two,$user_id, $level_one_class_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // category with same category_name already existed in the db
        }
        
    }

	/**
     * Fetching all categories
     * @param String $user_id id of the user
     */
    public function getAllLevelOneClass() {
        $stmt = $this->conn->prepare("SELECT * FROM level_one_classes ORDER BY level_one_class_order, level_one_class_name");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

	/**
     * Fetching particular category
     * @param String $user_id id of the user
     */
    public function getLevelOneClass($level_one_class_id) {
        $stmt = $this->conn->prepare("SELECT * FROM level_one_classes WHERE level_one_class_id=?");
		$stmt->bind_param("i", $level_one_class_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


	/**
     * Checking for duplicate category by category_name
     * @param String $category_name
     * @return boolean
     */
    private function isClassExists($level_one_class_name) {
        $stmt = $this->conn->prepare("SELECT level_one_class_id from level_one_classes WHERE level_one_class_name = ?");
        $stmt->bind_param("s", $level_one_class_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	/**
     * Checking for duplicate category by category_name for updating
	 * @param int $category_id
     * @param String $category_name
     * @return boolean
     */	
	private function checkClassExistenceForUpdate($level_one_class_id, $level_one_class_name){
		$stmt = $this->conn->prepare("SELECT level_one_class_id from level_one_classes WHERE level_one_class_id <> ? AND level_one_class_name = ?");
        $stmt->bind_param("is", $level_one_class_id, $level_one_class_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
/*=====================================End LevelOneClass===================================*/

/*===============================================================================*/
/*========================== `categories` table method ==========================*/
/*===============================================================================*/
	/**
     * Creating new category
     * @param int $user_id who created the category
     * @param String $category_name
     */
    public function createCategory($category_name,$user_id) {
		if (!$this->isCategoryExists($category_name)) 
		{
			$stmt = $this->conn->prepare("INSERT INTO categories(category_name,updated_by) VALUES(?,?)");
			$stmt->bind_param("si", $category_name,$user_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // category with same category_name already existed in the db
        }
        
    }
	
	/**
     * Updating category
     * @param int $category_id
     * @param String $category_name
     */
    public function updateCategory($category_id, $category_name, $user_id) {
		if (!$this->checkCategoryExistenceForUpdate($category_id, $category_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE categories SET category_name = ?,updated_by = ? WHERE category_id = ?");
			$stmt->bind_param("sii", $category_name, $user_id, $category_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // category with same category_name already existed in the db
        }
        
    }

	/**
     * Fetching all categories
     * @param String $user_id id of the user
     */
    public function getAllCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

	/**
     * Fetching particular category
     * @param String $user_id id of the user
     */
    public function getCategory($category_id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_id=?");
		$stmt->bind_param("i", $category_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


	/**
     * Checking for duplicate category by category_name
     * @param String $category_name
     * @return boolean
     */
    private function isCategoryExists($category_name) {
        $stmt = $this->conn->prepare("SELECT category_id from categories WHERE category_name = ?");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	/**
     * Checking for duplicate category by category_name for updating
	 * @param int $category_id
     * @param String $category_name
     * @return boolean
     */	
	private function checkCategoryExistenceForUpdate($category_id, $category_name){
		$stmt = $this->conn->prepare("SELECT category_id from categories WHERE category_id <> ? AND category_name = ?");
        $stmt->bind_param("is", $category_id, $category_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
	
	public function addFeedbackCategory($feedback_category_name, $user_id) {
		if (!$this->isFeedbackCategoryExists($feedback_category_name)){
			$stmt = $this->conn->prepare("INSERT INTO feedback_categories(feedback_category_name,updated_by) VALUES(?,?)");
			$stmt->bind_param("si", $feedback_category_name,$user_id);
			$result = $stmt->execute();
			$stmt->close();

			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}else{
			return USER_ALREADY_EXISTED;
		}
		      
    }
    
    public function updateFeedbackCategory($feedback_category_id, $feedback_category_name, $user_id) {
		if (!$this->checkFeedbackCategoryExistenceForUpdate($feedback_category_id, $feedback_category_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE feedback_categories SET feedback_category_name = ?,updated_by = ? WHERE feedback_category_id = ?");
			$stmt->bind_param("sii", $feedback_category_name, $user_id, $feedback_category_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // category with same category_name already existed in the db
        }
        
    }

	/**
     * Fetching all categories
     * @param String $user_id id of the user
     */
    public function getAllFeedbackCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM feedback_categories");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

	/**
     * Fetching particular category
     * @param String $user_id id of the user
     */
    public function getFeedbackCategory($feedback_category_id) {
        $stmt = $this->conn->prepare("SELECT * FROM feedback_categories WHERE feedback_category_id = ?");
		$stmt->bind_param("i", $feedback_category_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
    
    private function isFeedbackCategoryExists($feedback_category_name) {
        $stmt = $this->conn->prepare("SELECT feedback_category_id from feedback_categories WHERE feedback_category_name = ?");
        $stmt->bind_param("s", $feedback_category_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    private function checkFeedbackCategoryExistenceForUpdate($feedback_category_id, $feedback_category_name){
		$stmt = $this->conn->prepare("SELECT feedback_category_id from feedback_categories WHERE feedback_category_id <> ? AND feedback_category_name = ?");
        $stmt->bind_param("is", $feedback_category_id, $feedback_category_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
	
	/**
     * Creating new feedback
     * @param int $user_id
     * @param String $description
     */
    public function createFeedback($user_id, $description, $feedback_category_id) {
    	$date = new DateTime();
		$sent_time = $date->format("Y-m-d H:i:s");
		$stmt = $this->conn->prepare("INSERT INTO feedbacks(user_id, feedback_category_id, description, sent_time) VALUES(?,?,?,?)");
		$stmt->bind_param("iiss", $user_id, $feedback_category_id, $description, $sent_time);
		$result = $stmt->execute();
		$stmt->close();

		// Check for successful insertion
		if ($result) 
		{              
			return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
		} 
		else 
		{             
			return USER_CREATE_FAILED;   // Failed to create user
		}
        
    }
    
    /**
     * Fetching all feedbacks
     */
    public function getAllFeedbacks() {
        $stmt = $this->conn->prepare("SELECT u.user_id,u.first_name,u.last_name,u.email,u.image_url,fc.feedback_category_name,f.feedback_id,f.description,UNIX_TIMESTAMP(f.sent_time) AS timestamp FROM users u INNER JOIN feedbacks f ON u.user_id=f.user_id INNER JOIN feedback_categories fc ON f.feedback_category_id = fc.feedback_category_id");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
/*=====================================End Category===================================*/

/*====================================================================================*/
/* =========================== `salutations` table method ============================*/
/*====================================================================================*/
	
	/**
     * Creating new salutation
     * @param int $user_id who created the salutation
     * @param String $salutation_name
     */
    public function createSalutation($salutation_name,$user_id) {
		if (!$this->isSalutationExists($salutation_name)) 
		{
			$stmt = $this->conn->prepare("INSERT INTO salutations(salutation_name,updated_by) VALUES(?,?)");
			$stmt->bind_param("si", $salutation_name,$user_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // salutation successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create salutation
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // salutation with same salutation_name already existed in the db
        }
        
    }

	/**
     * Updating Salutation
     * @param int $salutation_id
     * @param String $salutation_name
     */
    public function updateSalutation($salutation_id, $salutation_name, $user_id) {
		if (!$this->checkSalutationExistenceForUpdate($salutation_id, $salutation_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE salutations SET salutation_name = ?,updated_by = ? WHERE salutation_id = ?");
			$stmt->bind_param("sii", $salutation_name, $user_id, $salutation_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful updating
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  
        }
        
    }

	/**
     * Fetching all salutations
     * @param String $user_id id of the user
     */
    public function getAllSalutations() {
		$stmt = $this->conn->prepare("SELECT * FROM salutations");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	/**
     * Fetching particular salutation
     * @param int $salutation_id id of the salutation
     */
    public function getSalutation($salutation_id) {
		$stmt = $this->conn->prepare("SELECT * FROM salutations WHERE salutation_id = ?");
		$stmt->bind_param("i", $salutation_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	

	/**
     * Checking for duplicate salutation by salutation_name
     * @param String $salutation_name
     * @return boolean
     */
    private function isSalutationExists($salutation_name) {
        $stmt = $this->conn->prepare("SELECT salutation_id from salutations WHERE salutation_name = ?");
        $stmt->bind_param("s", $salutation_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

	/**
     * Checking for duplicate category by category_name for updating
	 * @param int $salutation_id
     * @param String $salutation_name
     * @return boolean
     */	
	private function checkSalutationExistenceForUpdate($salutation_id, $salutation_name){
		$stmt = $this->conn->prepare("SELECT salutation_id from salutations WHERE salutation_id <> ? AND salutation_name = ?");
        $stmt->bind_param("is", $salutation_id, $salutation_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
/*=====================================End Salutations===================================*/

/*===============================================================================*/
/*========================== `countries` table method ==========================*/
/*===============================================================================*/
	/**
     * Creating new country
     * @param int $user_id who created the country
     * @param String $country_name
     */
    public function createCountry($country_name,$user_id) {
		if (!$this->isCountryExists($country_name)) 
		{
			$stmt = $this->conn->prepare("INSERT INTO countries(country_name,updated_by) VALUES(?,?)");
			$stmt->bind_param("si", $country_name,$user_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // country successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create country
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // country with same country_name already existed in the db
        }
        
    }
	
	/**
     * Updating country
     * @param int $country_id
     * @param String $country_name
     */
    public function updateCountry($country_id, $country_name, $user_id) {
		if (!$this->checkCountryExistenceForUpdate($country_id, $country_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE countries SET country_name = ?,updated_by = ? WHERE country_id = ?");
			$stmt->bind_param("sii", $country_name, $user_id, $country_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // country successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create country
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // country with same country_name already existed in the db
        }
        
    }

	/**
     * Fetching all countries
     * @param String $user_id id of the user
     */
    public function getAllCountries() {
        $stmt = $this->conn->prepare("SELECT * FROM countries");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

	/**
     * Fetching particular Country
     * @param String $user_id id of the user
     */
    public function getCountry($country_id) {
        $stmt = $this->conn->prepare("SELECT * FROM countries WHERE country_id=?");
		$stmt->bind_param("i", $country_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


	/**
     * Checking for duplicate Country by country_name
     * @param String $country_name
     * @return boolean
     */
    private function isCountryExists($country_name) {
        $stmt = $this->conn->prepare("SELECT country_id from countries WHERE country_name = ?");
        $stmt->bind_param("s", $country_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	/**
     * Checking for duplicate country by country_name for updating
	 * @param int $country_id
     * @param String $country_name
     * @return boolean
     */	
	private function checkCountryExistenceForUpdate($country_id, $country_name){
		$stmt = $this->conn->prepare("SELECT country_id from countries WHERE country_id <> ? AND country_name = ?");
        $stmt->bind_param("is", $country_id, $country_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
/*=====================================End country===================================*/

/*=======================================================================================*/
/* ================================`states` table method ================================*/
/*=======================================================================================*/

	/**
     * Creating new state
     * @param int $user_id who created the state
	 * @param int $country_id
     * @param String $state_name
     */
    public function createState($country_id,$state_name,$user_id) {
		if (!$this->isStateExists($country_id, $state_name)) 
		{
			$stmt = $this->conn->prepare("INSERT INTO states(country_id,state_name,updated_by) VALUES(?,?,?)");
			$stmt->bind_param("isi", $country_id,$state_name,$user_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // state successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create state
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // state with same state_name already existed in the db
        }
        
    }

	/**
     * Updating State
     * @param int $state_id
	 * @param int $country_id
     * @param String $state_name
     */
    public function updateState($state_id, $country_id, $state_name, $user_id) {
		if (!$this->checkStateExistenceForUpdate($country_id, $state_id, $state_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE states SET country_id = ?,state_name = ?,updated_by = ? WHERE state_id = ?");
			$stmt->bind_param("isii", $country_id, $state_name, $user_id, $state_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful updating
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  
        }
        
    }

	/**
     * Fetching all states
     * @param String $user_id id of the user
     */
    public function getAllStates() {
        $stmt = $this->conn->prepare("SELECT s.*,c.country_id,c.country_name FROM states s INNER JOIN countries c ON s.country_id = c.country_id");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	/**
     * Fetching particular state
     * @param int $state_id id of the state
     */
    public function getState($state_id) {
		$stmt = $this->conn->prepare("SELECT s.*,c.country_id,c.country_name FROM states s INNER JOIN countries c ON s.country_id = c.country_id WHERE state_id = ?");
		$stmt->bind_param("i", $state_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	/**
     * Fetching all states of particular country
     * @param String $state_id id of the user
     */
    public function getAllStatesByCountry($country_id) {
        $stmt = $this->conn->prepare("SELECT s.*,c.country_id,c.country_name FROM states s INNER JOIN countries c ON c.country_id = s.country_id WHERE c.country_id=? OR c.country_name = ?");
		$stmt->bind_param("is", $country_id, $country_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	

/**
     * Checking for duplicate state by state_name
     * @param String $state_name
     * @return boolean
     */
    private function isStateExists($country_id,$state_name) {
        $stmt = $this->conn->prepare("SELECT state_id from states WHERE state_name = ? AND country_id = ?");
        $stmt->bind_param("si", $state_name, $country_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	
	/**
     * Checking for duplicate state by state_name for updating
	 * @param int $state_id
     * @param String $state_name
     * @return boolean
     */	
	private function checkStateExistenceForUpdate($country_id, $state_id, $state_name){
		$stmt = $this->conn->prepare("SELECT state_id from states WHERE state_id <> ? AND state_name = ? AND country_id = ?");
        $stmt->bind_param("isi", $state_id, $state_name, $country_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
/*=====================================End States===================================*/

/*==================================================================================*/
/* ============================ `postcodes` table method ===========================*/
/*==================================================================================*/

	/**
     * Creating new postcode
	 * @param int $state_id
     * @param int $user_id who created the postcode
     * @param String $postcode_name
     */
    public function createPostcode($state_id,$postcode_name,$user_id) {
		if (!$this->isPostcodeExists($state_id,$postcode_name)) 
		{
			$stmt = $this->conn->prepare("INSERT INTO postcodes(state_id,postcode_name,updated_by) VALUES(?,?,?)");
			$stmt->bind_param("isi", $state_id,$postcode_name,$user_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // postcode successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create postcode
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // postcode with same postcode_name already existed in the db
        }
        
    }

	/**
     * Updating Postcode
     * @param int $postcode_id
	 * @param int $state_id
     * @param String $postcode_name
     */
    public function updatePostcode($postcode_id, $state_id, $postcode_name, $user_id) {
		if (!$this->checkPostcodeExistenceForUpdate($postcode_id, $postcode_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE postcodes SET state_id = ?,postcode_name = ?,updated_by = ? WHERE postcode_id = ?");
			$stmt->bind_param("isii", $state_id, $postcode_name, $user_id, $postcode_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful updating
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  
        }
        
    }

	/**
     * Fetching all postcodes
     * @param String $user_id id of the user
     */
    public function getAllPostcodes() {
        $stmt = $this->conn->prepare("SELECT p.*,s.state_id,s.state_name,c.country_id,c.country_name FROM postcodes p INNER JOIN states s ON p.state_id=s.state_id INNER JOIN countries c ON c.country_id = s.country_id");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	/**
     * Fetching particular postcode
     * @param int $postcode_id id of the postcode
     */
    public function getPostcode($postcode_id) {
		$stmt = $this->conn->prepare("SELECT p.*,s.state_id,s.state_name,c.country_id,c.country_name FROM postcodes p INNER JOIN states s ON p.state_id=s.state_id INNER JOIN countries c ON c.country_id = s.country_id WHERE p.postcode_id = ?");
		$stmt->bind_param("i", $postcode_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	/**
     * Fetching all postcodes of particular state
     * @param String $state_id id of the user
     */
    public function getAllPostcodesByState($state_id) {
    	$state_id = $this->conn->real_escape_string($state_id);
        $stmt = $this->conn->prepare("SELECT p.*,s.state_id,s.state_name,c.country_id,c.country_name FROM postcodes p INNER JOIN states s ON p.state_id=s.state_id INNER JOIN countries c ON c.country_id = s.country_id WHERE s.state_id=? OR s.state_name=?");
		$stmt->bind_param("is", $state_id, $state_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


/**
     * Checking for duplicate postcode by postcode_name and state_id
	 * @param int $state_id
     * @param String $postcode_name
     * @return boolean
     */
    private function isPostcodeExists($state_id,$postcode_name) {
        $stmt = $this->conn->prepare("SELECT postcode_id from postcodes WHERE state_id = ? AND postcode_name = ?");
        $stmt->bind_param("is", $state_id,$postcode_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	
	/**
     * Checking for duplicate state by state_name for updating
	 * @param int $postcode_id
     * @param String $postcode_name
     * @return boolean
     */	
	private function checkPostcodeExistenceForUpdate($postcode_id, $postcode_name){
		$stmt = $this->conn->prepare("SELECT postcode_id from postcodes WHERE postcode_id <> ? AND postcode_name = ?");
        $stmt->bind_param("is", $postcode_id, $postcode_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
/*=====================================End Postcodes===================================*/

/*=====================================================================================*/
/*=============================== `suburbs` table method ==============================*/
/*=====================================================================================*/

	/**
     * Creating new suburb
	 * @param int $postcode_id
     * @param int $user_id who created the suburb
     * @param String $suburb_name
     */
    public function createSuburb($postcode_id,$suburb_name,$user_id) {
		if (!$this->isSuburbExists($postcode_id,$suburb_name)) 
		{
			$stmt = $this->conn->prepare("INSERT INTO suburbs(postcode_id,suburb_name,updated_by) VALUES(?,?,?)");
			$stmt->bind_param("isi", $postcode_id,$suburb_name,$user_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful insertion
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // Suburb successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create Suburb
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  // Suburb with same suburb_name already existed in the db
        }
        
    }


	/**
     * Updating Suburb
     * @param int $postcode_id
	 * @param int $suburb_id
     * @param String $suburb_name
     */
    public function updateSuburb($suburb_id, $postcode_id, $suburb_name, $user_id) {
		if (!$this->checkSuburbExistenceForUpdate($suburb_id, $suburb_name)) 
		{
			$stmt = $this->conn->prepare("UPDATE suburbs SET postcode_id = ?,suburb_name = ?,updated_by = ? WHERE suburb_id = ?");
			$stmt->bind_param("isii", $postcode_id, $suburb_name, $user_id, $suburb_id);
			$result = $stmt->execute();
			$stmt->close();
	
			// Check for successful updating
			if ($result) 
			{              
				return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
			} 
			else 
			{             
				return USER_CREATE_FAILED;   // Failed to create user
			}
		}
		else 
		{          
            return USER_ALREADY_EXISTED;  
        }
        
    }

	/**
     * Fetching all suburbs
     * @param 
     */
    public function getAllSuburbs() {
        $stmt = $this->conn->prepare("SELECT s.*,p.postcode_name,st.state_id,st.state_name,c.country_id,c.country_name FROM suburbs s INNER JOIN postcodes p ON p.postcode_id=s.postcode_id INNER JOIN states st ON p.state_id=st.state_id INNER JOIN countries c ON c.country_id = st.country_id");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	/**
     * Fetching particular suburb
     * @param int $suburb_id id of the suburb
     */
    public function getSuburb($suburb_id) {
		$stmt = $this->conn->prepare("SELECT s.*,p.postcode_name,st.state_id,st.state_name,c.country_id,c.country_name FROM suburbs s INNER JOIN postcodes p ON p.postcode_id=s.postcode_id INNER JOIN states st ON p.state_id=st.state_id INNER JOIN countries c ON c.country_id = st.country_id WHERE s.suburb_id = ?");
		$stmt->bind_param("i", $suburb_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	/**
     * Fetching all suburbs of particular postcode
     * @param int $postcode_id
     */
    public function getAllsuburbsByPostcode($postcode_id) {
        $stmt = $this->conn->prepare("SELECT s.*,p.postcode_id,p.postcode_name,st.state_id,st.state_name,c.country_id,c.country_name FROM suburbs s INNER JOIN postcodes p ON p.postcode_id=s.postcode_id INNER JOIN states st ON p.state_id=st.state_id INNER JOIN countries c ON c.country_id = st.country_id WHERE p.postcode_id = ? OR p.postcode_name = ?");
		$stmt->bind_param("is", $postcode_id, $postcode_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    
/**
     * Checking for duplicate Suburb by suburb_name and postcode_id
	 * @param int $postcode_id
     * @param String $suburb_name
     * @return boolean
     */
    private function isSuburbExists($postcode_id,$suburb_name) {
        $stmt = $this->conn->prepare("SELECT suburb_id from suburbs WHERE postcode_id = ? AND suburb_name = ?");
        $stmt->bind_param("is", $postcode_id,$suburb_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
/**
     * Checking for duplicate suburb by suburb_name for updating
	 * @param int $suburb_id
     * @param String $suburb_name
     * @return boolean
     */	
	private function checkSuburbExistenceForUpdate($suburb_id, $suburb_name){
		$stmt = $this->conn->prepare("SELECT suburb_id from suburbs WHERE suburb_id <> ? AND suburb_name = ?");
        $stmt->bind_param("is", $suburb_id, $suburb_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
	
	/**
     * Individual Home Page For App
	 * @param int $app_user_id
     * @param UNIX timestamp $timestamp
     * @return array
     */	
	public function getLevelOneWithUnreadMsg($app_user_id, $timestamp) {
		$sent_time = date("Y-m-d H:i:s", $timestamp);
		$category_results = $this->conn->query("SELECT DISTINCT category_id, category_name,second_level FROM view_sp_res WHERE user_id IN ( SELECT sp_id FROM appuserssps WHERE app_user_id = $app_user_id AND active = 1 ) OR user_id IN ( SELECT residence_id FROM residencesindividuals WHERE individual_id = $app_user_id AND active = 1 ) OR user_id IN ( SELECT first_user_id FROM appusersappusers WHERE second_user_id = $app_user_id AND (active = 1 OR active = 0) ) OR user_id IN ( SELECT second_user_id FROM appusersappusers WHERE first_user_id = $app_user_id AND (active = 1 OR active = 0) )");
		$no_of_rows_category = $category_results->num_rows;
		if ($no_of_rows_category > 0) //if data exist
		{
			$i = 0;
			while( $row = $category_results->fetch_assoc() )
			{
				$category_id = $row['category_id'];
				//$user_id = $row['user_id'];
				$message_results = $this->conn->query("SELECT message_id FROM messages WHERE sent_time > '".$sent_time."' AND (receiver_id =0 OR receiver_id = $app_user_id) AND sender_id IN (SELECT DISTINCT user_id FROM view_sp_res WHERE category_id = $category_id AND user_id IN ( SELECT sp_id FROM appuserssps WHERE app_user_id = $app_user_id ) OR user_id IN ( SELECT residence_id FROM residencesindividuals WHERE individual_id = $app_user_id ) OR user_id IN ( SELECT first_user_id FROM appusersappusers WHERE second_user_id = $app_user_id ) OR user_id IN ( SELECT second_user_id FROM appusersappusers WHERE first_user_id = $app_user_id ) )");
				$no_of_msg = $message_results->num_rows;
				$rows[] = array(
					'category_id'=> $row['category_id'],
					'category_name' => $row['category_name'],
					'second_level' => $row['second_level'], 
					'no_of_msg' => $no_of_msg           
				);
				$i++;
			}
			$return = array(
				'message'=>"Ok",
				'categories' => $rows   
			);
		}
		else
		{
			$return = array(
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}
	
	/**
     * get assigned FNF with unread message for specific app user
	 * @param int $app_user_id
     * @param UNIX timestamp $timestamp
     * @return array
     */	
	public function getFnfWithUnreadMsgForApp($app_user_id, $timestamp) {
		//$user_results = $this->conn->query("SELECT user_id, user_role, first_name, last_name, organisation_name,image_url FROM users WHERE user_id IN ( SELECT first_user_id FROM appusersappusers WHERE second_user_id = $app_user_id AND active = 1  ) OR user_id IN ( SELECT second_user_id FROM appusersappusers WHERE first_user_id = $app_user_id AND active = 1 )");
		$user_results = $this->conn->query("SELECT user_id, user_role, first_name, last_name, organisation_name,image_url,email FROM users WHERE user_id IN ( SELECT first_user_id FROM appusersappusers WHERE second_user_id = $app_user_id AND active = 1  )");
		$no_of_rows_user = $user_results->num_rows;
		if ($no_of_rows_user > 0) //if data exist
		{
			$i = 0;
			while( $row = $user_results->fetch_assoc() )
			{
				$user_id = $row['user_id'];
				$message_results = $this->conn->query("SELECT message_id FROM messages WHERE receiver_id = $app_user_id AND (sender_id <> $app_user_id AND sender_id = $user_id)");
				$no_of_msg = $message_results->num_rows;
				$rows[] = array(
					'user_id'=> $row['user_id'],
					'user_role'=> $row['user_role'],
					'first_name' => $row['first_name'],
					'last_name' => $row['last_name'], 
					'organisation_name' => $row['organisation_name'], 
					'image_url' => ROOT_PATH."images/profile/".$row['image_url'],
					'email' => $row['email'], 
					'sender_id' => $row['user_id'], 
					'receiver_id' => $app_user_id, 
					'active' => 1,
					'no_of_msg' => $no_of_msg           
				);
				$i++;
			}
//			$return = array(
//				'message'=>"Ok",
//				'categories' => $rows   
//			);
		}
		
		$user_results1 = $this->conn->query("SELECT user_id, user_role, first_name, last_name, organisation_name,image_url,email FROM users WHERE user_id IN ( SELECT second_user_id FROM appusersappusers WHERE first_user_id = $app_user_id AND active = 1 )");
		$no_of_rows_user1 = $user_results1->num_rows;
		if ($no_of_rows_user1 > 0) //if data exist
		{
			$i = 0;
			while( $row1 = $user_results1->fetch_assoc() )
			{
				$user_id = $row1['user_id'];
				$message_results1 = $this->conn->query("SELECT message_id FROM messages WHERE receiver_id = $app_user_id AND (sender_id <> $app_user_id AND sender_id = $user_id)");
				$no_of_msg1 = $message_results1->num_rows;
				$rows[] = array(
					'user_id'=> $row1['user_id'],
					'user_role'=> $row1['user_role'],
					'first_name' => $row1['first_name'],
					'last_name' => $row1['last_name'], 
					'organisation_name' => $row1['organisation_name'], 
					'image_url' => ROOT_PATH."images/profile/".$row1['image_url'],
					'email' => $row1['email'],
					'sender_id' => $app_user_id, 
					'receiver_id' => $row1['user_id'], 					
					'active' => 1,
					'no_of_msg' => $no_of_msg1           
				);
				$i++;
			}
//			$return = array(
//				'message'=>"Ok",
//				'categories' => $rows   
//			);
		}
		
		$user_results2 = $this->conn->query("SELECT user_id, user_role, first_name, last_name, organisation_name,image_url,email FROM users WHERE user_id IN ( SELECT second_user_id FROM appusersappusers WHERE first_user_id = $app_user_id AND active = 0 )");
		$no_of_rows_user2 = $user_results2->num_rows;
		if ($no_of_rows_user2 > 0) //if data exist
		{
			$i = 0;
			while( $row2 = $user_results2->fetch_assoc() )
			{
				$user_id = $row2['user_id'];
				//$message_results2 = $this->conn->query("SELECT message_id FROM messages WHERE receiver_id = $app_user_id AND (sender_id <> $app_user_id AND sender_id = $user_id)");
				//$no_of_msg2 = $message_results2->num_rows;
				$rows[] = array(
					'user_id'=> $row2['user_id'],
					'user_role'=> $row2['user_role'],
					'first_name' => $row2['first_name'],
					'last_name' => $row2['last_name'], 
					'organisation_name' => $row2['organisation_name'], 
					'image_url' => ROOT_PATH."images/profile/".$row2['image_url'],
					'email' => $row2['email'],
					'sender_id' => $app_user_id, 
					'receiver_id' => $row2['user_id'], 					
					'active' => 0,
					'no_of_msg' => 0           
				);
				$i++;
			}
//			$return = array(
//				'message'=>"Ok",
//				'categories' => $rows   
//			);
		}
		
		$user_results3 = $this->conn->query("SELECT user_id, user_role, first_name, last_name, organisation_name,image_url,email FROM users WHERE user_id IN ( SELECT first_user_id FROM appusersappusers WHERE second_user_id = $app_user_id AND active = 0  )");
		$no_of_rows_user3 = $user_results3->num_rows;
		if ($no_of_rows_user3 > 0) //if data exist
		{
			$i = 0;
			while( $row3 = $user_results3->fetch_assoc() )
			{
				$user_id = $row3['user_id'];
				//$message_results = $this->conn->query("SELECT message_id FROM messages WHERE receiver_id = $app_user_id AND (sender_id <> $app_user_id AND sender_id = $user_id)");
				//$no_of_msg = $message_results->num_rows;
				$rows[] = array(
					'user_id'=> $row3['user_id'],
					'user_role'=> $row3['user_role'],
					'first_name' => $row3['first_name'],
					'last_name' => $row3['last_name'], 
					'organisation_name' => $row3['organisation_name'], 
					'image_url' => ROOT_PATH."images/profile/".$row3['image_url'],
					'email' => $row3['email'],
					'sender_id' => $row3['user_id'], 
					'receiver_id' => $app_user_id, 
					'active' => 0,
					'no_of_msg' => 0           
				);
				$i++;
			}
//			$return = array(
//				'message'=>"Ok",
//				'categories' => $rows   
//			);
		}
		
		$return = array(
			'message'=>"Ok",
			'categories' => $rows   
		);
		
//		else
//		{
//			$return = array(
//				'message'=>"No Result Found."  
//			); 
//		}
		return $return;
		
	}
	
	/**
     * get assigned Sps with unread message for specific app user and specific category
     * @param int $category_id
	 * @param int $app_user_id
     * @param UNIX timestamp $timestamp
     * @return array
     */	
	public function getSpsWithUnreadMsgForApp($category_id, $app_user_id, $timestamp) {
		$user_results = $this->conn->query("SELECT user_id, user_role, organisation_name, address, image_url FROM users WHERE category = $category_id AND (user_id IN ( SELECT sp_id FROM appuserssps WHERE app_user_id = $app_user_id AND active = 1 ) OR user_id IN ( SELECT residence_id FROM residencesindividuals WHERE individual_id = $app_user_id AND active = 1 ))");
		$no_of_rows_user = $user_results->num_rows;
		if ($no_of_rows_user > 0) //if data exist
		{
			$i = 0;
			while( $row = $user_results->fetch_assoc() )
			{
				$user_id = $row['user_id'];
				$message_results = $this->conn->query("SELECT message_id FROM messages WHERE receiver_id = 0 AND (sender_id <> $app_user_id AND sender_id = $user_id)");
				$no_of_msg = $message_results->num_rows;
				$rows[] = array(
					'user_id'=> $row['user_id'],
					'user_role'=> $row['user_role'], 
					'organisation_name' => $row['organisation_name'], 
					'address' => $row['address'], 
					'image_url' => ROOT_PATH."images/profile/".$row['image_url'],
					'no_of_msg' => $no_of_msg           
				);
				$i++;
			}
			$return = array(
				'message'=>"Ok",
				'categories' => $rows   
			);
		}
		else
		{
			$return = array(
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}
	
	public function getRelationalData() {
		$country_results = $this->conn->query("SELECT * FROM countries");
		$no_of_rows_country = $country_results->num_rows;
		if ($no_of_rows_country > 0) //if data exist
		{
			$i = 0;
			while( $row = $country_results->fetch_assoc() )
			{
				$country_id = $row['country_id'];
				$rows[] = array(
					'country_id'=> $row['country_id'],
					'country_name' => $row['country_name'],            
					'updated_on'=> $row['updated_on'],
					'updated_by' => $row['updated_by'],
					'states'=> array()
				);
				$state_results = $this->conn->query("SELECT * FROM states WHERE country_id = $country_id");
				$no_of_rows_state = $state_results->num_rows;
				if ($no_of_rows_state > 0) //if data exist
				{
					$j = 0;
					while( $row2 = $state_results->fetch_assoc() )
					{
						$state_id = $row2['state_id'];
						$rows[$i]['states'][] = array(
							'state_id'=> $row2['state_id'],
							'state_name' => $row2['state_name'],            
							'updated_on'=> $row2['updated_on'],
							'updated_by' => $row2['updated_by'],
							'postcodes'=> array()
						);
						$postcode_results = $this->conn->query("SELECT * FROM postcodes WHERE state_id = $state_id");
						$no_of_rows_postcode = $postcode_results->num_rows;
						if ($no_of_rows_postcode > 0) //if data exist
						{
							$k = 0;
							while( $row3 = $postcode_results->fetch_assoc() )
							{
								$postcode_id = $row3['postcode_id'];
								$rows[$i]['states'][$j]['postcodes'][] = array(
									'postcode_id'=> $row3['postcode_id'],
									'postcode_name' => $row3['postcode_name'],            
									'updated_on'=> $row3['updated_on'],
									'updated_by' => $row3['updated_by'],
									'suburbs'=> array()
								);
								$suburb_results = $this->conn->query("SELECT * FROM suburbs WHERE postcode_id = $postcode_id");
								$no_of_rows_suburb = $suburb_results->num_rows;
								if ($no_of_rows_suburb > 0) //if data exist
								{
									$l = 0;
									while( $row4 = $suburb_results->fetch_assoc() )
									{
										$suburb_id = $row4['suburb_id'];
										$rows[$i]['states'][$j]['postcodes'][$k]['suburbs'][] = array(
											'suburb_id'=> $row4['suburb_id'],
											'suburb_name' => $row4['suburb_name'],            
											'updated_on'=> $row4['updated_on'],
											'updated_by' => $row4['updated_by']
										); 
										$l++;
									}
								}
								$k++;
							}
						}
						$j++;
					}
				}
				$i++;
			}
			$return = array(
				'message'=>"Ok",
				'countries' => $rows   
			);
		}
		else
		{
			$return = array(
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}

	/*public function getSpAndResidence($postcode) {
		$category_results = $this->conn->query("SELECT * FROM categories");
		$no_of_rows_category = $category_results->num_rows;
		if ($no_of_rows_category > 0) //if data exist
		{
			$i = 0;
			while( $row = $category_results->fetch_assoc() )
			{
				$category_id = $row['category_id'];
				$rows[] = array(
					'category_id'=> $row['category_id'],
					'category_name' => $row['category_name'],            
					'updated_on'=> $row['updated_on'],
					'updated_by' => $row['updated_by'],
					'sps'=> array(),
					'residences'=> array()
				);
				$sp_results = $this->conn->query("SELECT * FROM users WHERE category = $category_id AND user_role = 2");
				$no_of_rows_sp = $sp_results->num_rows;
				$residence_results = $this->conn->query("SELECT * FROM users WHERE category = $category_id AND user_role = 3");
				$no_of_rows_residence = $residence_results->num_rows;
				if ($no_of_rows_sp > 0) //if data exist
				{
					while( $row2 = $sp_results->fetch_assoc() )
					{
						$rows[$i]['sps'][] = array(
							'user_id'=> $row2['user_id'],
							'organisation_name' => $row2['organisation_name'],
							'organisation_description' => $row2['organisation_description'],
							'image_url' => ROOT_PATH."images/sp/".$row2['image_url']
						);
						
					}
				}
				if ($no_of_rows_residence > 0) //if data exist
				{
					while( $row3 = $residence_results->fetch_assoc() )
					{
						$rows[$i]['residences'][] = array(
							'user_id'=> $row3['user_id'],
							'organisation_name' => $row3['organisation_name'],
							'organisation_description' => $row2['organisation_description'],
							'image_url' => ROOT_PATH."images/residence/".$row3['image_url']
						);
						
					}
				}
				$i++;
			}
			$return = array(
				'message'=>"Ok",
				'categories' => $rows   
			);
		}
		else
		{
			$return = array(
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}*/
	
	public function getSpAndResidence($postcode) {
		$category_results = $this->conn->query("SELECT DISTINCT category_id, category_name FROM view_sp_res WHERE postcode = $postcode");
		$no_of_rows_category = $category_results->num_rows;
		if ($no_of_rows_category > 0) //if data exist
		{
			$i = 0;
			while( $row = $category_results->fetch_assoc() )
			{
				$category_id = $row['category_id'];
				$rows[] = array(
					'category_id'=> $row['category_id'],
					'category_name' => $row['category_name'],            
					//'updated_on'=> $row['updated_on'],
					//'updated_by' => $row['updated_by'],
					'sps'=> array(),
					'residences'=> array()
				);
				$sp_results = $this->conn->query("SELECT * FROM view_sp_res WHERE category = $category_id AND user_role = 2 AND postcode = $postcode");
				$no_of_rows_sp = $sp_results->num_rows;
				$residence_results = $this->conn->query("SELECT * FROM view_sp_res WHERE category = $category_id AND user_role = 3 AND postcode = $postcode");
				$no_of_rows_residence = $residence_results->num_rows;
				if ($no_of_rows_sp > 0) //if data exist
				{
					while( $row2 = $sp_results->fetch_assoc() )
					{
						$rows[$i]['sps'][] = array(
							'user_id'=> $row2['user_id'],
							'organisation_name' => $row2['organisation_name'],
							'organisation_description' => $row2['organisation_description'],
							'image_url' => ROOT_PATH."images/profile/".$row2['image_url']
						);
						
					}
				}
				if ($no_of_rows_residence > 0) //if data exist
				{
					while( $row3 = $residence_results->fetch_assoc() )
					{
						$rows[$i]['residences'][] = array(
							'user_id'=> $row3['user_id'],
							'organisation_name' => $row3['organisation_name'],
							'organisation_description' => $row3['organisation_description'],
							'image_url' => ROOT_PATH."images/profile/".$row3['image_url']
						);
						
					}
				}
				$i++;
			}
			$return = array(
				'message'=>"Ok",
				'categories' => $rows   
			);
		}
		else
		{
			$return = array(
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}
	
	
	public function getSpsOrResidences($user_id,$postcode,$user_role) {
		$sql = "SELECT DISTINCT category_id, category_name FROM view_sp_res WHERE (postcode = $postcode AND user_role = $user_role) OR user_id IN(SELECT sp_id FROM appuserssps WHERE active = 1 AND app_user_id = $user_id)";
		$category_results = $this->conn->query($sql);		
		$no_of_rows_category = $category_results->num_rows;
		if ($no_of_rows_category > 0) //if data exist
		{
			$i = 0;
			while( $row = $category_results->fetch_assoc() )
			{
				$category_id = $row['category_id'];
				if($user_role == 2){
					$rows[] = array(
						'category_id'=> $row['category_id'],
						'category_name' => $row['category_name'],            
						//'updated_on'=> $row['updated_on'],
						//'updated_by' => $row['updated_by'],
						'sps'=> array()
					);
				}
				else{
					$rows[] = array(
						'category_id'=> $row['category_id'],
						'category_name' => $row['category_name'],            
						//'updated_on'=> $row['updated_on'],
						//'updated_by' => $row['updated_by'],
						'residences'=> array()
					);
				}
				
				$sql_sp = "SELECT * FROM view_sp_res WHERE category = $category_id AND ((user_role = $user_role AND postcode = $postcode) OR user_id IN(SELECT sp_id FROM appuserssps WHERE active = 1 AND app_user_id = $user_id))";
					
				$sp_results = $this->conn->query($sql_sp);
				$no_of_rows_sp = $sp_results->num_rows;
				if ($no_of_rows_sp > 0) //if data exist
				{
					while( $row2 = $sp_results->fetch_assoc() )
					{
						$sp = "";
						$path = "";
						$sp_res_id = $row2['user_id'];
						$already_added = 0;
						$already_liked = 0;
						if($user_role == 2){
							$sp = 'sps';
							$path = ROOT_PATH."images/profile/";
							if($this->isThisSpAlreadyAdded($user_id, $sp_res_id))
							{
								$already_added = 1;
							}
						}else{
							$sp = 'residences';
							$path = ROOT_PATH."images/profile/";
							if($this->isThisResidenceAlreadyAdded($user_id, $sp_res_id))
							{
								$already_added = 1;
							}
						}
						if($this->isAppAlreadyLikeTheSp($sp_res_id, $user_id))
						{
							$already_liked = 1;
						}
						
						
						$rows[$i][$sp][] = array(
							'user_id'=> $row2['user_id'],
							'organisation_name' => $row2['organisation_name'],
							'organisation_description' => $row2['organisation_description'],
							'image_url' => $path.$row2['image_url'],
							'number_of_likes' => $row2['star'],
							'already_added' => $already_added,
							'already_liked' => $already_liked
						);
						
					}
				}
				$i++;
			}
			$return = array(
				'error'=>false,
				'categories' => $rows   
			);
		}
		else
		{
			$return = array(
				'error'=>true,
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}
	
	public function getCurrentLinksFavoured($user_id) {
		$user_info = $this->getUserInfo($user_id);
        $num_rows_user_info = $user_info->num_rows;
        $numberOfFavoured = "";
        if ($num_rows_user_info > 0)
		{
			while ($user = $user_info->fetch_assoc()){
				$numberOfFavoured = $user["star"];
			}
		}
		
		$resultAppUsersForSp = $this->conn->query("SELECT COUNT(*) AS numberOfAppUsersForSp FROM appuserssps WHERE (app_user_id = $user_id OR sp_id = $user_id) AND active = 1");
		$appUsersForSp = $resultAppUsersForSp->fetch_assoc();
		$numberOfAppUsersForSp = $appUsersForSp['numberOfAppUsersForSp'];
		
		$resultAppUsersForRes = $this->conn->query("SELECT COUNT(*) AS numberOfAppUsersForRes FROM residencesindividuals WHERE residence_id = $user_id AND active = 1");
		$appUsersForRes = $resultAppUsersForRes->fetch_assoc();
		$numberOfAppUsersForRes = $appUsersForRes['numberOfAppUsersForRes'];
		
		$resultSpsForRes = $this->conn->query("SELECT COUNT(*) AS numberOfSpsForRes FROM residencessps WHERE res_user_id = $user_id AND active = 1");
		$spsForRes = $resultSpsForRes->fetch_assoc();
		$numberOfSpsForRes = $spsForRes['numberOfSpsForRes'];

		$this->conn->close();
		
		$currentLinks = $numberOfAppUsersForSp + $numberOfAppUsersForRes + $numberOfSpsForRes;
		
		$response = array();
		$response["error"] = false;
		$response["currentLinks"] = $currentLinks;
		$response["numberOfFavoured"] = $numberOfFavoured;
		
		return $response;		
		
	}
	
	private function isThisSpAlreadyAdded($user_id, $sp_id) {
        $stmt = $this->conn->prepare("SELECT appuserssp_id from appuserssps WHERE app_user_id = ? AND sp_id = ? AND active = 1");
        $stmt->bind_param("ii", $user_id, $sp_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function isThisResidenceAlreadyAdded($user_id, $sp_res_id) {
        $stmt = $this->conn->prepare("SELECT appusersresidence_id from appusersresidences WHERE app_user_id = ? AND residence_id = ? AND active = 1");
        $stmt->bind_param("ii", $user_id, $sp_res_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    public function getSpsForResidence($user_id,$postcode,$user_role) {
		$category_results = $this->conn->query("SELECT DISTINCT category_id, category_name FROM view_sp_res WHERE (postcode = $postcode AND user_role = $user_role AND category_id <> 1 AND category_id <> 4) OR user_id IN(SELECT sp_id FROM residencessps WHERE res_user_id = $user_id AND active = 1)");
		$no_of_rows_category = $category_results->num_rows;
		if ($no_of_rows_category > 0) //if data exist
		{
			$i = 0;
			while( $row = $category_results->fetch_assoc() )
			{
				$category_id = $row['category_id'];
				$rows[] = array(
					'category_id'=> $row['category_id'],
					'category_name' => $row['category_name'],            
					//'updated_on'=> $row['updated_on'],
					//'updated_by' => $row['updated_by'],
					'sps'=> array()
				);
					
				$sp_results = $this->conn->query("SELECT * FROM view_sp_res WHERE category = $category_id AND ((user_role = $user_role AND postcode = $postcode) OR user_id IN(SELECT sp_id FROM residencessps WHERE res_user_id = $user_id AND active = 1))");
				$no_of_rows_sp = $sp_results->num_rows;
				if ($no_of_rows_sp > 0) //if data exist
				{
					while( $row2 = $sp_results->fetch_assoc() )
					{
						$path = "";
						$sp_res_id = $row2['user_id'];
						$already_added = 0;
						$send_receive = 0;

						$path = ROOT_PATH."images/profile/";
						if($this->isThisSpAlreadyAddedByRes($user_id, $sp_res_id))
						{
							$already_added = 1;
							$user = $this->getSendReceive($user_id, $sp_res_id);
							$send_receive = $user['send_receive'];
						}
						
						
						$rows[$i]['sps'][] = array(
							'user_id'=> $row2['user_id'],
							'organisation_name' => $row2['organisation_name'],
							'organisation_description' => $row2['organisation_description'],
							'image_url' => $path.$row2['image_url'],
							'already_added' => $already_added,
							'send_receive' => $send_receive
						);
						
					}
				}
				$i++;
			}
			$return = array(
				'error'=>false,
				'categories' => $rows   
			);
		}
		else
		{
			$return = array(
				'error'=>true,
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}
	
	public function searchSpsForResidence($user_id,$query,$user_role) {
		$searchQuery = "%".$query."%";
		$category_results = $this->conn->query("SELECT DISTINCT category_id, category_name FROM view_sp_res WHERE (organisation_name LIKE '".$searchQuery."' AND user_role = $user_role AND category_id <> 1 AND category_id <> 4) OR user_id IN(SELECT sp_id FROM residencessps WHERE res_user_id = $user_id AND active = 1)");
		$no_of_rows_category = $category_results->num_rows;
		if ($no_of_rows_category > 0) //if data exist
		{
			$i = 0;
			while( $row = $category_results->fetch_assoc() )
			{
				$category_id = $row['category_id'];
				$rows[] = array(
					'category_id'=> $row['category_id'],
					'category_name' => $row['category_name'],            
					//'updated_on'=> $row['updated_on'],
					//'updated_by' => $row['updated_by'],
					'sps'=> array()
				);
					
				$sp_results = $this->conn->query("SELECT * FROM view_sp_res WHERE category = $category_id AND ((organisation_name LIKE '".$searchQuery."' AND user_role = $user_role) OR user_id IN(SELECT sp_id FROM residencessps WHERE res_user_id = $user_id AND active = 1))");
				$no_of_rows_sp = $sp_results->num_rows;
				if ($no_of_rows_sp > 0) //if data exist
				{
					while( $row2 = $sp_results->fetch_assoc() )
					{
						$path = "";
						$sp_res_id = $row2['user_id'];
						$already_added = 0;
						$send_receive = 0;

						$path = ROOT_PATH."images/profile/";
						if($this->isThisSpAlreadyAddedByRes($user_id, $sp_res_id))
						{
							$already_added = 1;
							$user = $this->getSendReceive($user_id, $sp_res_id);
							$send_receive = $user['send_receive'];
						}
						
						
						$rows[$i]['sps'][] = array(
							'user_id'=> $row2['user_id'],
							'organisation_name' => $row2['organisation_name'],
							'organisation_description' => $row2['organisation_description'],
							'image_url' => $path.$row2['image_url'],
							'already_added' => $already_added,
							'send_receive' => $send_receive
						);
						
					}
				}
				$i++;
			}
			$return = array(
				'error'=>false,
				'categories' => $rows   
			);
		}
		else
		{
			$return = array(
				'error'=>true,
				'message'=>"No Result Found."  
			); 
		}
		return $return;
		
	}
	
	public function getSendReceive($res_user_id, $sp_id) {
        $stmt = $this->conn->prepare("SELECT send_receive from residencessps WHERE res_user_id = ? AND sp_id = ? AND active = 1");
        $stmt->bind_param("ii", $res_user_id, $sp_id);
	
        if ($stmt->execute()) {
            $stmt->bind_result($send_receive);
            $stmt->fetch();
            $residencessps = array();
			$residencessps["send_receive"] = $send_receive;
            $stmt->close();
            return $residencessps;
        } else {
            return NULL;
        }
		
    }

	
	private function isThisSpAlreadyAddedByRes($user_id, $sp_id) {
        $stmt = $this->conn->prepare("SELECT residencessp_id from residencessps WHERE res_user_id = ? AND sp_id = ? AND active = 1");
        $stmt->bind_param("ii", $user_id, $sp_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	
	public function getAssignedResidenceForSp($sp_id) {
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id IN(SELECT res_user_id FROM residencessps WHERE active = 1 AND send_receive = 1 AND sp_id = ?)");
		$stmt->bind_param("i", $sp_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;		
	}
	public function getAssignedSpsForRes($res_id) {
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id IN(SELECT sp_id FROM residencessps WHERE active = 1 AND send_receive = 1 AND res_user_id = ?)");
		$stmt->bind_param("i", $res_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;		
	}
	public function getAssignedIndividualsForRes($res_id) {
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id IN(SELECT individual_id FROM residencesindividuals WHERE active = 1 AND residence_id = ?)");
		$stmt->bind_param("i", $res_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;		
	}
	public function getAssignedSpsBroadcastOrIndividualForRes($msg_type, $res_id) {
		if($msg_type == 'broadcast'){
			$query = "SELECT u . * , t1 . * FROM users u INNER JOIN (SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE receiver_id = 0 AND sender_id IN (SELECT sp_id FROM residencessps WHERE res_user_id = ?))t1 ON u.user_id = t1.sender_id ORDER BY t1.sent_time DESC";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param("i", $res_id);
		}
		elseif($msg_type == 'individual'){
			$query = "SELECT u . * , t1 . * FROM users u INNER JOIN (SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE receiver_id = ? AND sender_id IN (SELECT sp_id FROM residencessps WHERE res_user_id = ?))t1 ON u.user_id = t1.sender_id ORDER BY t1.sent_time DESC";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param("ii", $res_id, $res_id);
		}
		
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;		
	}
	
	public function getAssignedIndividualsMsgForRes($res_id) {
		$query = "SELECT u . * , t1 . * FROM users u INNER JOIN (SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE receiver_id = ? AND sender_id IN (SELECT individual_id FROM residencesindividuals WHERE residence_id = ?))t1 ON u.user_id = t1.sender_id ORDER BY t1.sent_time DESC";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("ii", $res_id, $res_id);
		
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;		
	}
/*=====================================End Suburbs===================================*/


/*=====================================================================================*/
/*=============================== `users(admin)` table method ==============================*/
/*=====================================================================================*/



/**
     * Fetching particular admin user
     * @param String $user_id id of the user
     */
    public function getAdmin($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_role = 0 AND user_id=?");
		$stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
    
    /**
     * Fetching particular admin user
     * @param String $user_id id of the user
     */
    public function getUserInfo($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
		$stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


/**
     * Creating new user for app user
     * @param String $first_name
	 * @param String $last_name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function fnfRequestForAppUser($user_id, $user_emails) {
        $response = array();

		//$result;
		// message lines should not exceed 70 characters (PHP rule), so wrap it
    	//$message = wordwrap($message, 70);
		$user = $this->getUserByUserId($user_id);
		$user_email = $user['email'];
		$emails = "";
		$fnf_acceptance_invitation_emails = "";
		$app_installation_invitation_emails = "";
		$user_role = 1;
		$active = 0;
		$number_of_due_mail = NUMBER_OF_NOTIFICATION;
		$add = NOTIFICATION_DURATION_DAYS;
		$next_mail_date = date('Y-m-d H:i:s', strtotime('+'.$add.' days'));
		$userEmailsArray = explode(',', $user_emails);
		
		$response = array();
		$response["error"] = false;
		$response["already_invited_or_accepted"] = array();
		$response["successfully_invited"] = array();
		foreach($userEmailsArray as $email){
			if($email != ''){
				$email_in_users_table = $this->getUserByEmail($email);				
				//email exist in user table
				if($email_in_users_table != NULL){
					if($email_in_users_table['user_id'] != null){
						//email exist in user table as app user
						//$response["email"] = $email_in_users_table['user_id'];
						if($email_in_users_table['user_role'] == $user_role){
							
							//return USER_CREATED_SUCCESSFULLY;
							$second_user_id = $email_in_users_table['user_id'];
							$tmp1 = array();
							$tmp2 = array();
							if($this->isFriendExistsInAppUser($user_id, $second_user_id)){
								$tmp1["emails"] = $email;
								array_push($response["already_invited_or_accepted"], $tmp1);
								
							}
							else{
								// insert query
								
								$stmt = $this->conn->prepare("INSERT INTO appusersappusers(first_user_id, second_user_id, second_user_email, active, number_of_due_mail, next_mail_date) values(?, ?, ?, ?, ?, ?)");
								$stmt->bind_param("iisiis", $user_id, $second_user_id, $email, $active, $number_of_due_mail, $next_mail_date);		
								$result = $stmt->execute();
								$stmt->close();							
								$tmp2["emails"] = $email;
								array_push($response["successfully_invited"], $tmp2);
								$fnf_acceptance_invitation_emails .= $email.",";
							}
							
						}	
					}else{
						//$response["email"] = false;
						$app_installation_invitation_emails .= $email.",";
						$tmp3 = array();
						$second_user_id = $this->appRegistrationWhenSomeoneInvite($email);
						//already this friend requested or not
						if($second_user_id != 0){
							$stmt = $this->conn->prepare("INSERT INTO appusersappusers(first_user_id, second_user_id, second_user_email, active, number_of_due_mail, next_mail_date) values(?, ?, ?, ?, ?, ?)");
							$stmt->bind_param("iisiis", $user_id, $second_user_id, $email, $active, $number_of_due_mail, $next_mail_date);		
							$result = $stmt->execute();
							$stmt->close();
							$tmp3["emails"] = $email;
							array_push($response["successfully_invited"], $tmp3);
						}	
					}
						
				}else{
								
					$response["error"] = true;	
					$response["message"] = "Oops!! Error occured.";				
					
				}	
	
			}
		}
		
		
        
        
        $subject = "";
        if($app_installation_invitation_emails != ""){
			$subject = "App Installation Invitation";
			$message = "Dear Family or Friend, 
You have been invited by ".$user_email." to join YourLink. YourLink is an App which you can download from the App store. To read more about YourLink please visit www.YourLink.com.au 
If you wish to connect with ".$user_email." please do not hesitate in downloading YourLink from The App Store or ……….. . You will be able to connect on your smart device through our App. 
Kind Regards 
Rick 
Managing Director 
YourLink
";
		
			$headers = "From: ".YOURLINK_EMAIL. "\r\n" .
    			"Reply-To: ".REPLY_TO_EMAIL. "\r\n" .
    			"X-Mailer: PHP/" . phpversion();
			mail($app_installation_invitation_emails,$subject,$message,$headers) ;
		}
		if($fnf_acceptance_invitation_emails != ""){
			$subject = "FNF Request";
			$message = "Dear Family or Friend, 
You have been invited by ".$user_email." to join YourLink. YourLink is an App which you can download from the App store. To read more about YourLink please visit www.YourLink.com.au 
If you wish to connect with ".$user_email." please do not hesitate in downloading YourLink from The App Store or ……….. . You will be able to connect on your smart device through our App. 
Kind Regards 
Rick 
Managing Director 
YourLink
";
		
			$headers = "From: ".YOURLINK_EMAIL. "\r\n" .
    			"Reply-To: ".REPLY_TO_EMAIL. "\r\n" .
    			"X-Mailer: PHP/" . phpversion();
			mail($fnf_acceptance_invitation_emails,$subject,$message,$headers) ;
		}
		
		return $response;
    }
    
    public function appRegistrationWhenSomeoneInvite($email){
    	$unixtime = time();
		$dateTime = date("Y-m-d H:i:s", $unixtime);
		$stmt = $this->conn->prepare("INSERT INTO users(user_role, user_status, email, created_on, updated_on) values(1, 0, ?, ?, ?)");
        $stmt->bind_param("sss", $email, $dateTime, $dateTime);
        $result = $stmt->execute();
        
        $last_inserted_id = $stmt->insert_id;

        // Check for successful insertion
        if ($result) {
            return $last_inserted_id;
        } else {
            return 0;
        }
	}
	
	public function fnfRequestAcceptOrDecline($sender_id, $receiver_id, $accept){
		$active = $accept;
		if($active == 1){
			$stmt = $this->conn->prepare("UPDATE appusersappusers SET active = ?, number_of_due_mail = 0 WHERE first_user_id = ? AND second_user_id = ?");
			$stmt->bind_param("iii", $active, $sender_id, $receiver_id);		
			$result = $stmt->execute();
			$stmt->close();
		}elseif($active == 0){
			$stmt = $this->conn->prepare("DELETE FROM appusersappusers WHERE first_user_id = ? AND second_user_id = ?");
			$stmt->bind_param("ii", $sender_id, $receiver_id);		
			$result = $stmt->execute();
			$stmt->close();
		}
		
		if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}
	}
    
    public function removeFnfForAppUser($user_id, $fnf_ids){
		$fnfIdsArray = explode(',', $fnf_ids);
		$active = 0;
		foreach($fnfIdsArray as $second_user_id){
			$stmt = $this->conn->prepare("DELETE FROM appusersappusers WHERE (first_user_id = ? AND second_user_id = ?) OR (first_user_id = ? AND second_user_id = ?)");
			$stmt->bind_param("iiii", $user_id, $second_user_id, $second_user_id, $user_id);		
			$result = $stmt->execute();
			$stmt->close();
		}
		
		if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}
	}
    
    public function unfriendFnfs($app_user_id, $fnf_ids) {
        $response = array();
		$fnfIdsArray = explode(',', $fnf_ids);
		
		if(count($fnfIdsArray)>0){
			foreach($fnfIdsArray as $fnf_id){
				if($fnf_id != ''){			
					$query1 = "UPDATE appusersappusers SET active = 0 WHERE (first_user_id = $app_user_id AND second_user_id = $fnf_id) OR (first_user_id = $fnf_id AND second_user_id = $app_user_id)";
					$query2 = "UPDATE appuserssps SET active = 0 WHERE (app_user_id = $app_user_id AND sp_id = $fnf_id)";
					$query3 = "UPDATE residencesindividuals SET active = 0 WHERE (residence_id = $fnf_ids AND individual_id = $app_user_id)";
					
					$stmt = $this->conn->prepare("UPDATE appusersappusers SET active = 0 WHERE (first_user_id = ? AND second_user_id = ?) OR (first_user_id = ? AND second_user_id = ?)");
					$stmt->bind_param("iiii", $app_user_id, $fnf_id, $fnf_id, $app_user_id);		
					$result = $stmt->execute();
					$stmt->close();
					
					$stmt = $this->conn->prepare("UPDATE appuserssps SET active = 0 WHERE (app_user_id = ? AND sp_id = ?)");
					$stmt->bind_param("ii", $app_user_id, $fnf_id);		
					$result = $stmt->execute();
					$stmt->close();
					
					$stmt = $this->conn->prepare("UPDATE residencesindividuals SET active = 0 WHERE (residence_id = ? AND individual_id = ?)");
					$stmt->bind_param("ii", $fnf_id, $app_user_id);		
					$result = $stmt->execute();
					$stmt->close();
					
					/*$stmt = $this->conn->prepare($query1);
					$result1 = $stmt->execute();
					$stmt->close();
					$stmt = $this->conn->prepare($query2);
					$result2 = $stmt->execute();
					$stmt->close();
					$stmt = $this->conn->prepare($query3);
					$result3 = $stmt->execute();		
					$stmt->close();*/
																
				}
			}
		}

		if ($result) {
			// fnf successfully unfriend
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to update
			return USER_CREATE_FAILED;
		}

    }

	
	private function isFriendExistsInAppUser($first_user_id, $second_user_id) {
        $stmt = $this->conn->prepare("SELECT appusersappusers_id from appusersappusers WHERE (first_user_id = ? AND second_user_id = ?) OR (first_user_id = ? AND second_user_id = ?)");
        $stmt->bind_param("iiii", $first_user_id, $second_user_id, $second_user_id, $first_user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function isFriendEmailExistsInAppUser($first_user_id, $second_user_email) {
        $stmt = $this->conn->prepare("SELECT appusersappusers_id from appusersappusers WHERE first_user_id = ? AND second_user_email = ?");
        $stmt->bind_param("is", $first_user_id, $second_user_email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function isFriendExistsAsActiveInAppUser($first_user_id, $second_user_id) {
        $stmt = $this->conn->prepare("SELECT appusersappusers_id from appusersappusers WHERE active = 1 AND ((first_user_id = ? AND second_user_id = ?) OR (first_user_id = ? AND second_user_id = ?))");
        $stmt->bind_param("iiii", $first_user_id, $second_user_id, $second_user_id, $first_user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function isFriendExistsInAppUserByEmail($first_user_id, $second_user_email) {
        $stmt = $this->conn->prepare("SELECT appusersappusers_id from appusersappusers WHERE first_user_id = ? AND second_user_email = ?");
        $stmt->bind_param("is", $first_user_id, $second_user_email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

	public function fnfRequestForResidence($res_user_id, $frnd_user_emails) {
        $response = array();

		$subject = "FNF Request";
		$message = "Dear Family or Friend,<br/> 
			You have been invited by Gran@_____ to join YourLink. YourLink is an App which you can download from the App store. To read more about YourLink please visit www.YourLink.com.au 
			If you wish to connect with Gran@_____ please do not hesitate in downloading YourLink from The App Store or ……….. . You will be able to connect on your smart device through our App. <br/>
			Kind Regards <br/>
			Rick <br/>
			Managing Director <br/>
			YourLink";
		// message lines should not exceed 70 characters (PHP rule), so wrap it
    	//$message = wordwrap($message, 70);
		$user = $this->getUserByUserId($res_user_id);
		$user_email = $user['email'];
		$emails = "";
		$user_role = 1;

		$userEmailsArray = explode(',', $frnd_user_emails);
		if(count($userEmailsArray)>0){
			foreach($userEmailsArray as $email){
				if($email != ''){
					//$friend = $this->getUserByEmail($email);
					$friend = $this->getUserByEmailAndRole($email, $user_role);
					
					
					if ($friend['user_id'] == null){
						$emails.= $email.",";
						$active = 0;
						$individual_id = 0;						
					}
					else{
						$individual_id = $friend['user_id'];	
						$active = 1;					
					}
					$result = "";
					$exist = false;
					if (!$this->isFriendExistsInResidence($res_user_id, $email)) 
					{
						// insert query
						$stmt = $this->conn->prepare("INSERT INTO residencesindividuals(residence_id, individual_id, individual_email, active) values(?, ?, ?, ?)");
						$stmt->bind_param("iisi", $res_user_id, $individual_id, $email, $active);		
						$result = $stmt->execute();
						$stmt->close();
					}
					else 
					{          
						$exist = true;  // category with same category_name already existed in the db
					}
									
					
				}
			}
		}
		
		$headers = 'From: '.$user_email. "\r\n" .
    		'Reply-To: webmaster@paraexist.inof' . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();
		mail($emails,$subject,$message,$headers) ;
		// Check for successful insertion
		if($exist){
			return USER_ALREADY_EXISTED;
		}
		else if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}

        //return $response;
    }
    
    public function disconnectFnfForResidence($residence_id, $individual_id) {
        $stmt = $this->conn->prepare("UPDATE residencesindividuals SET active = 0 WHERE (residence_id = ? AND individual_id = ?)");
		$stmt->bind_param("ii", $residence_id, $individual_id);
		$result = $stmt->execute();
		$stmt->close();

		// Check for successful updating
		if ($result) 
		{              
			return USER_CREATED_SUCCESSFULLY;  // User successfully inserted
		} 
		else 
		{             
			return USER_CREATE_FAILED;   // Failed to create user
		}
    }
	
	private function isFriendExistsInResidence($residence_id, $individual_email) {
        $stmt = $this->conn->prepare("SELECT residencesindividual_id from residencesindividuals WHERE residence_id = ? AND individual_email = ?");
        $stmt->bind_param("is", $residence_id, $individual_email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


	public function addSpsForAppUser($app_user_id, $sp_ids) {
        $response = array();
        $spIdsArray;
        if($sp_ids != ""){
			$spIdsArray = explode(',', $sp_ids);
		}
		
		//atfirst update active to false
		$active = 0;
		$stmt = $this->conn->prepare("UPDATE appuserssps SET active = 0 WHERE app_user_id = ?");
		$stmt->bind_param("i", $app_user_id);		
		$result = $stmt->execute();
		$stmt->close();
		if($sp_ids == ""){
			return USER_CREATED_SUCCESSFULLY;
		}
		
		if(count($spIdsArray)>0){
			foreach($spIdsArray as $sp_id){
				if($sp_id != ''){			
					$result = "";
					$exist = false;
					if (!$this->isSpExists($app_user_id, $sp_id)) 
					{
						// insert query
						$stmt = $this->conn->prepare("INSERT INTO appuserssps(app_user_id, sp_id) values(?, ?)");
						$stmt->bind_param("ii", $app_user_id, $sp_id);		
						$result = $stmt->execute();
						$stmt->close();
					}
					else 
					{    
						// update query      
						$stmt = $this->conn->prepare("UPDATE appuserssps SET active = 1 WHERE app_user_id = ? AND sp_id = ?");
						$stmt->bind_param("ii", $app_user_id, $sp_id);		
						$result = $stmt->execute();
						$stmt->close();
					}											
				}
			}
		}
		
		// Check for successful insertion
		if($exist){
			return USER_ALREADY_EXISTED;
		}
		else if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}

    }
    
    public function manageIndividualSpForAppUser($app_user_id, $sp_id){
    	if ($this->isSpActive($app_user_id, $sp_id)) 
		{
			// insert query
			$stmt = $this->conn->prepare("UPDATE appuserssps SET active = 0 WHERE app_user_id = ? AND sp_id = ?");
			$stmt->bind_param("ii", $app_user_id, $sp_id);		
			$result = $stmt->execute();
			$stmt->close();
		}
		else 
		{    
			// update query      
			$stmt = $this->conn->prepare("UPDATE appuserssps SET active = 1 WHERE app_user_id = ? AND sp_id = ?");
			$stmt->bind_param("ii", $app_user_id, $sp_id);		
			$result = $stmt->execute();
			$stmt->close();
		}	
		
		if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}
	}

	private function isSpExists($app_user_id, $sp_id) {
        $stmt = $this->conn->prepare("SELECT appuserssp_id from appuserssps WHERE app_user_id = ? AND sp_id = ?");
        $stmt->bind_param("ii", $app_user_id, $sp_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    private function isSpActive($app_user_id, $sp_id) {
        $stmt = $this->conn->prepare("SELECT appuserssp_id from appuserssps WHERE app_user_id = ? AND sp_id = ? AND active = 1");
        $stmt->bind_param("ii", $app_user_id, $sp_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

	public function addSpsForResidence($res_user_id, $sp_ids) {
        $response = array();
		$spIdsArray = explode(',', $sp_ids);
		
		$active = 0;
		$stmt = $this->conn->prepare("UPDATE residencessps SET active = 0 WHERE res_user_id = ?");
		$stmt->bind_param("i", $res_user_id);		
		$result = $stmt->execute();
		$stmt->close();
		$exist = false;
		if(count($spIdsArray)>0){
			foreach($spIdsArray as $sp_id_send_receive){
				if($sp_id_send_receive != ''){			
					$result = "";
					$sp_id = explode('_', $sp_id_send_receive)[0];
					$send_receive = explode('_', $sp_id_send_receive)[1];
					$exist = false;
					if (!$this->isSpExistsInResidence($res_user_id, $sp_id)) 
					{
						// insert query
						$stmt = $this->conn->prepare("INSERT INTO residencessps(res_user_id, sp_id, send_receive) values(?, ?, ?)");
						$stmt->bind_param("iii", $res_user_id, $sp_id, $send_receive);		
						$result = $stmt->execute();
						$stmt->close();
					}
					else 
					{          					
						$stmt = $this->conn->prepare("UPDATE residencessps SET active = 1, send_receive = ? WHERE res_user_id = ? AND sp_id = ?");
						$stmt->bind_param("iii", $send_receive, $res_user_id, $sp_id);		
						$result = $stmt->execute();
						$stmt->close();
					}
									
					
				}
			}
		}
		else{
			$exist = true;
		}
		

		// Check for successful insertion
		if($exist){
			return USER_ALREADY_EXISTED;
		}
		else if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}

    }

	private function isSpExistsInResidence($res_user_id, $sp_id) {
        $stmt = $this->conn->prepare("SELECT residencessp_id from residencessps WHERE res_user_id = ? AND sp_id = ?");
        $stmt->bind_param("ii", $res_user_id, $sp_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	
	public function sendMessage($sender_id, $sender_role, $receiver_role, $message_title, $description, $event, $start_date, $start_time, $end_date, $end_time, $offset, $status, $attachment_url) {
        $response = array();
		// insert query
		$receiver_id = 0;
		$ev_start_date = $start_date." ".$start_time;
		$st_date = new DateTime($ev_start_date);
		$st_timestamp = $st_date->format("U");
		$adjusted_st_timestamp = $st_timestamp + $offset*60;
		$even_start_date = date("Y-m-d H:i:s", $adjusted_st_timestamp);
		$ev_st_date = new DateTime($even_start_date);
		$event_start_date = $ev_st_date->format("Y-m-d H:i:s");
		
		$ev_end_date = $end_date." ".$end_time;
		$en_date = new DateTime($ev_end_date);
		$en_timestamp = $en_date->format("U");
		$adjusted_en_timestamp = $en_timestamp + $offset*60;		
		$even_end_date = date("Y-m-d H:i:s", $adjusted_en_timestamp);
		$ev_en_date = new DateTime($even_end_date);
		$event_end_date = $ev_en_date->format("Y-m-d H:i:s");
		
		$date = new DateTime();
		$sent_time = $date->format("Y-m-d H:i:s");
		
		$stmt = $this->conn->prepare("INSERT INTO messages(sender_id, sender_role, receiver_id, receiver_role, message_title, description, event, event_start_date, event_end_date, status, sent_time, attachment_url) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("iiiississsss", $sender_id, $sender_role, $receiver_id, $receiver_role, $message_title, $description, $event, $event_start_date, $event_end_date, $status, $sent_time, $attachment_url);		
		$result = $stmt->execute();
		$stmt->close();

		// Check for successful insertion
		if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}

    }
	
	public function sendIndividualMessage($sender_id, $sender_role, $receiver_id, $message_title, $description, $status, $attachment_url) {
        $response = array();
		//$event_start_date = date("Y-m-d H:i:s", $event_start_date);
		$event = 0;
		$date = new DateTime();
		$sent_time = $date->format("Y-m-d H:i:s");
		// insert query
		$stmt = $this->conn->prepare("INSERT INTO messages(sender_id, sender_role, receiver_id, message_title, description, event, sent_time, status, attachment_url) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("iiississs", $sender_id, $sender_role, $receiver_id, $message_title, $description, $event, $sent_time, $status, $attachment_url);		
		$result = $stmt->execute();
		$stmt->close();

		// Check for successful insertion
		if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}

    }
    
    public function shareMessage($message_id, $description, $shared_by, $shared_to_ids) {
    	$date = new DateTime();
		$shared_time = $date->format("Y-m-d H:i:s");
    	$shared_to_idsArray;
    	$result;
        if($shared_to_ids != ""){
			$shared_to_idsArray = explode(',', $shared_to_ids);
		}
		$stmt = $this->conn->prepare("INSERT INTO shared_messages(message_id, description, shared_by, shared_to, shared_time) values(?, ?, ?, ?, ?)");
		if(count($shared_to_idsArray)>0){
			foreach($shared_to_idsArray as $shared_to){
				if($shared_to != ''){				
					$stmt->bind_param("isiis", $message_id, $description, $shared_by, $shared_to, $shared_time);		
					$result = $stmt->execute();					
				}
			}
		}
    	$stmt->close();
		

		// Check for successful insertion
		if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}

    }
    
    public function deleteIndividualMessage($message_id, $user_id) {
        $response = array();
		// delete query
		$stmt = $this->conn->prepare("INSERT INTO messages_delete(message_id, user_id) VALUES(?, ?)");
		$stmt->bind_param("ii", $message_id, $user_id);		
		$result = $stmt->execute();
		$stmt->close();

		// Check for successful insertion
		if ($result) {
			// User successfully inserted
			return USER_CREATED_SUCCESSFULLY;
		} else {
			// Failed to create user
			return USER_CREATE_FAILED;
		}

    }

/**
     * Fetching particular category
     * @param String $user_id id of the user
     */
//    public function getIndividualMessage($sender_id, $receiver_id) {
//        $stmt = $this->conn->prepare("SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_time");
//		$stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
//        $stmt->execute();
//        $tasks = $stmt->get_result();        
//        $stmt->close();
//        return $tasks;
//    }
    
    public function getIndividualMessage($sender_id, $receiver_id, $page) {
    	if($page == 0){
			$stmt = $this->conn->prepare("SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_time");
			$stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
		}else{
			$page = $this->conn->real_escape_string($page);
	    	$page -= 1;
			$per_page = ROW_PER_PAGE;
			$start = $page * $per_page;
			
			$sql = "SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_time LIMIT ?, ?";
	        $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("iiiiii", $sender_id, $receiver_id, $receiver_id, $sender_id, $start, $per_page);
	        
		}
    	
    	$stmt->execute();
    	
        $result = $stmt->get_result();
        
        $num_rows = $result->num_rows;
		$response = array();
		$response["error"] = false;
		$response["messages"] = array();

		if ($num_rows > 0) //if data exist
		{
			while ($message = $result->fetch_assoc()) {
				$tmp = array();
				if(!$this->checkMessageDeleted($message["message_id"], $receiver_id)){
					$tmp["message_id"] = $message["message_id"];
					$tmp["sender_role"] = $message["sender_role"];
					$tmp["sender_id"] = $message["sender_id"];
					$tmp["receiver_id"] = $message["receiver_id"];
					$tmp["message_title"] = $message["message_title"];
					$tmp["description"] = $message["description"];
					$tmp["send_date"] = $message["sent_time"];
					$tmp["send_time"] = $message["timestamp"];
					array_push($response["messages"], $tmp);
				}
							
			}
		}
		else {
			$response["error"] = true;
			$response["message"] = "No message available";
		}
        
        $stmt->close();
        return $response;
    }
    
    
    private function checkMessageDeleted($message_id, $user_id){
		$stmt = $this->conn->prepare("SELECT messages_delete_id from messages_delete WHERE message_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $message_id, $user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}

	/**
     * Fetching particular category
     * @param String $user_id id of the user
     */
    
    public function getBroadcastForAppUser($app_user_id, $event, $timestamp) {
    	$sent_time = date("Y-m-d H:i:s", $timestamp);   
    	$postcode = '0';
    	$user_info = $this->getUserInfo($app_user_id);
        $num_rows_user_info = $user_info->num_rows;
        if ($num_rows_user_info > 0) //if data exist
		{
			while ($user = $user_info->fetch_assoc()){
				$postcode = $user["postcode"];
			}
		}
    	   	     
        $sql = "SELECT u.*,m.* FROM users u INNER JOIN  messages m ON u.user_id = m.sender_id WHERE m.receiver_id = 0 AND m.event = $event AND ((u.postcode = '$postcode') OR m.sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = $app_user_id AND active = 1) OR m.sender_id IN(SELECT residence_id FROM residencesindividuals WHERE individual_id = $app_user_id AND active = 1)) ORDER BY m.sent_time";
        //$sql = "SELECT u.*,m.* FROM users u INNER JOIN  messages m ON u.user_id = m.sender_id WHERE m.receiver_id = 0 AND (m.sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = $app_user_id AND active = 1) OR m.sender_id IN(SELECT residence_id FROM residencesindividuals WHERE individual_id = $app_user_id AND active = 1)) ORDER BY m.sent_time";
		$results = $this->conn->query($sql);		
		$num_rows = $results->num_rows;
		//$this->conn->close();
        
        $response = array();
        $response["error"] = false;
		$response["messages"] = array();

		if ($num_rows > 0) //if data exist
		{
			while ($message = $results->fetch_assoc()) {
				$tmp = array();
				$already_liked = 0;
				$sp_id = $message["user_id"];
				if($this->isAppAlreadyLikeTheSp($sp_id, $app_user_id))
				{
					$already_liked = 1;
				}
				
				$tmp["user_id"] = $message["user_id"];
				$tmp["organisation_name"] = $message["organisation_name"];
				$tmp["image_url"] = ROOT_PATH."images/profile/".$message["image_url"];
				$tmp["message_id"] = $message["message_id"];
				$tmp["sender_role"] = $message["sender_role"];
				$tmp["receiver_id"] = $message["receiver_id"];
				$tmp["message_title"] = $message["message_title"];
				$tmp["description"] = $message["description"];
				$tmp["send_date"] = $message["sent_time"];
				$tmp["start_date"] = $message["event_start_date"];
				$tmp["end_date"] = $message["event_end_date"];
				$tmp["number_of_likes"] = $message["star"];
				$tmp["already_liked"] = $already_liked;
				array_push($response["messages"], $tmp);			
			}
		}
		else {
			$response["error"] = true;
			$response["message"] = "No message available";
		}
		$this->conn->close();
		
		return $response;	
	} 
	
	public function getSentBroadcastForAppUser($sender_id, $app_user_id, $event) {
		$response = array();
        $response["error"] = false;		
        $user_info = $this->getUserInfo($sender_id);
        $num_rows_user_info = $user_info->num_rows;
        if ($num_rows_user_info > 0) //if data exist
		{
			while ($user = $user_info->fetch_assoc()){
				$already_liked = 0;
				$sp_id = $user["user_id"];
				if($this->isAppAlreadyLikeTheSp($sp_id, $app_user_id))
				{
					$already_liked = 1;
				}
				$response["user_id"] = $user["user_id"];
				$response["organisation_name"] = $user["organisation_name"];
				$response["image_url"] = ROOT_PATH."images/profile/".$user["image_url"];
				$response["address"] = $user["address"];
				$response["number_of_likes"] = $user["star"];
				$response["already_liked"] = $already_liked;
			}
		}
		
		
		
		$sql_shared = "SELECT m.*, sm.description AS shared_description FROM messages m INNER JOIN shared_messages sm ON m.message_id=sm.message_id WHERE m.message_id IN(SELECT sm.message_id FROM shared_messages sm WHERE shared_to = $app_user_id)";
		$results_shared = $this->conn->query($sql_shared);		
		$num_rows_shared = $results_shared->num_rows;
		
        //$sql = "SELECT * FROM messages WHERE receiver_id = 0 AND event = $event AND sender_id = $sender_id";
        $sql = "SELECT * FROM messages WHERE receiver_id = 0 AND sender_id = $sender_id";
		$results = $this->conn->query($sql);		
		$num_rows = $results->num_rows;
		//$this->conn->close();
		
		if($num_rows_shared == 0 && $num_rows == 0){
			$response["error"] = true;
			$response["message"] = "No message available";
			$this->conn->close();
			return $response;
		}
		$response["messages"] = array();
		
		if ($num_rows_shared > 0) //if data exist
		{
			while ($message = $results_shared->fetch_assoc()) {
				$tmp = array();	
				$message_type = ($message["event"] == 1) ? "Event" : "Notice";	
				$tmp["message_id"] = $message["message_id"];
				$tmp["sender_role"] = $message["sender_role"];
				$tmp["message_type"] = $message_type;
				$tmp["message_status"] = "Shared";
				$tmp["message_title"] = $message["message_title"];
				$tmp["shared_description"] = $message["shared_description"];
				$tmp["description"] = $message["description"];
				$tmp["send_date"] = $message["sent_time"];
				$tmp["start_date"] = $message["event_start_date"];
				$tmp["end_date"] = $message["event_end_date"];				
				array_push($response["messages"], $tmp);			
			}
		}
        
		if ($num_rows > 0) //if data exist
		{
			while ($message = $results->fetch_assoc()) {
				$tmp = array();	
				$message_type = ($message["event"] == 1) ? "Event" : "Notice";	
				$tmp["message_id"] = $message["message_id"];
				$tmp["sender_role"] = $message["sender_role"];
				$tmp["message_type"] = $message_type;
				$tmp["message_status"] = "Normal";
				$tmp["message_title"] = $message["message_title"];
				$tmp["shared_description"] = "";
				$tmp["description"] = $message["description"];
				$tmp["send_date"] = $message["sent_time"];
				$tmp["start_date"] = $message["event_start_date"];
				$tmp["end_date"] = $message["event_end_date"];				
				array_push($response["messages"], $tmp);			
			}
		}
		$this->conn->close();
		
		return $response;	
	} 
	
	public function searchBroadcastForAppUser($app_user_id, $event, $query) {
    	$searchQuery = "%".$query."%";		        
        $sql = "SELECT u.*,m.* FROM users u INNER JOIN  messages m ON u.user_id = m.sender_id WHERE m.receiver_id = 0 AND m.event = $event AND (u.postcode LIKE '".$searchQuery."' OR u.organisation_name LIKE '".$searchQuery."' OR m.message_title LIKE '".$searchQuery."') AND (m.sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = $app_user_id) OR m.sender_id IN(SELECT residence_id FROM residencesindividuals WHERE individual_id = $app_user_id)) ORDER BY m.sent_time";
		$results = $this->conn->query($sql);		
		$num_rows = $results->num_rows;
        
        $response = array();
        $response["error"] = false;
		$response["messages"] = array();

		if ($num_rows > 0) //if data exist
		{
			while ($message = $results->fetch_assoc()) {
				$tmp = array();
				$already_liked = 0;
				$sp_id = $message["user_id"];
				if($this->isAppAlreadyLikeTheSp($sp_id, $app_user_id))
				{
					$already_liked = 1;
				}
				$tmp["user_id"] = $message["user_id"];
				$tmp["organisation_name"] = $message["organisation_name"];
				$tmp["image_url"] = ROOT_PATH."images/profile/".$message["image_url"];
				$tmp["message_id"] = $message["message_id"];
				$tmp["sender_role"] = $message["sender_role"];
				$tmp["receiver_id"] = $message["receiver_id"];
				$tmp["message_title"] = $message["message_title"];
				$tmp["description"] = $message["description"];
				$tmp["send_date"] = $message["sent_time"];
				$tmp["start_date"] = $message["event_start_date"];
				$tmp["end_date"] = $message["event_end_date"];
				$tmp["number_of_likes"] = $message["star"];
				$tmp["already_liked"] = $already_liked;
				array_push($response["messages"], $tmp);			
			}
		}
		else {
			$response["error"] = true;
			$response["message"] = "No message available";
		}
		$this->conn->close();
		
		return $response;
    }
    
//    public function getBroadcastForAppUser($app_user_id, $event, $timestamp) {
//    	$sent_time = date("Y-m-d H:i:s", $timestamp);
//    	//$event = ($event='event') ? 1 : 0;
//        //$stmt = $this->conn->prepare("SELECT u.*,m.* FROM users u INNER JOIN  messages m ON u.user_id = m.sender_id WHERE m.receiver_id = 0 AND m.sent_time > ? AND m.event = ? AND (sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = ?) OR sender_id IN(SELECT residence_id FROM residencesindividuals WHERE individual_id = ?)) ORDER BY sent_time");
//        $stmt = $this->conn->prepare("SELECT u.*,m.* FROM users u INNER JOIN  messages m ON u.user_id = m.sender_id WHERE m.receiver_id = 0 AND m.event = ? AND (m.sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = ?) OR m.sender_id IN(SELECT residence_id FROM residencesindividuals WHERE individual_id = ?)) ORDER BY m.sent_time");
//		//$stmt = $this->conn->prepare("SELECT * FROM messages WHERE event = 0 AND sender_id = ?");
//		$stmt->bind_param("iii", $event, $app_user_id, $app_user_id);
//        $stmt->execute();
//        $tasks = $stmt->get_result();
//        $stmt->close();
//        return $tasks;
//    }
    
//    public function searchBroadcastForAppUser($app_user_id, $event, $query) {
//    	//$sent_time = date("Y-m-d H:i:s", $timestamp);
//    	//$event = ($event='event') ? 1 : 0;
//    	$searchQuery = "%".$query."%";
////        $stmt = $this->conn->prepare("SELECT u.*,m.* FROM users u INNER JOIN  messages m ON u.user_id = m.sender_id WHERE m.receiver_id = 0 AND m.event = ? AND (m.message_title LIKE ? OR m.description LIKE ?) AND (m.sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = ?) OR m.sender_id IN(SELECT residence_id FROM residencesindividuals WHERE individual_id = ?)) ORDER BY m.sent_time");
////		$stmt->bind_param("issii", $event, $searchQuery, $searchQuery, $app_user_id, $app_user_id);
//		
//		$stmt = $this->conn->prepare("SELECT u.*,m.* FROM users u INNER JOIN  messages m ON u.user_id = m.sender_id WHERE m.receiver_id = 0 AND m.event = ? AND (u.organisation_name LIKE ? OR m.message_title LIKE ?) AND (m.sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = ?) OR m.sender_id IN(SELECT residence_id FROM residencesindividuals WHERE individual_id = ?)) ORDER BY m.sent_time");
//		$stmt->bind_param("issii", $event, $searchQuery, $searchQuery, $app_user_id, $app_user_id);
//        $stmt->execute();
//        $tasks = $stmt->get_result();
//        $stmt->close();
//        return $tasks;
//    }
    
    /**
     * Fetching particular category
     * @param String $user_id id of the user
     */
//    public function getSpsMessage($sender_id) {
//        //$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = ?)");
//		$stmt = $this->conn->prepare("SELECT * FROM messages WHERE event = 0 AND sender_id = ?");
//		$stmt->bind_param("i", $sender_id);
//        $stmt->execute();
//        $tasks = $stmt->get_result();
//        $stmt->close();
//        return $tasks;
//    }
    
    public function getSpsMessage($sender_id, $receiver_id) {
        //$stmt = $this->conn->prepare("SELECT * FROM messages WHERE sender_id IN(SELECT sp_id FROM appuserssps WHERE app_user_id = ?)");
        $user_info = $this->getUserInfo($sender_id);
        $num_rows_user_info = $user_info->num_rows;
        $address = "";
        if ($num_rows_user_info > 0) //if data exist
		{
			while ($user = $user_info->fetch_assoc()){
				$address = $user["address"];
			}
		}
        
		$stmt = $this->conn->prepare("SELECT * FROM messages WHERE event = 0 AND sender_id = ?");
		$stmt->bind_param("i", $sender_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $num_rows = $result->num_rows;
		$response = array();
		$response["error"] = false;
		
		$number_of_likes = $this->getNumberOfLikeOfUser($sender_id);
		$response["number_of_likes"] = $number_of_likes;
		$already_liked = 0;
		if($this->isAppAlreadyLikeTheSp($sender_id, $receiver_id))
		{
			$already_liked = 1;
		}
		$response["already_liked"] = $already_liked;

		if ($num_rows > 0) //if data exist
		{
			$response["address"] = $address;
			$response["messages"] = array();
			while ($message = $result->fetch_assoc()) {
				$tmp = array();
				if(!$this->checkMessageDeleted($message["message_id"], $receiver_id)){
					$tmp["message_id"] = $message["message_id"];
					$tmp["sender_role"] = $message["sender_role"];
					$tmp["receiver_id"] = $message["receiver_id"];
					$tmp["message_title"] = $message["message_title"];
					$tmp["description"] = $message["description"];
					$tmp["send_date"] = $message["sent_time"];
					array_push($response["messages"], $tmp);
				}
							
			}
		}
		else {
			$response["error"] = true;
			$response["message"] = "No message available";
		}
        $stmt->close();
        return $response;
    }
    
    /**
     * Fetching all broadcast messages of specific sp or residence
     * @param String $sender_id id of the user who sent 
     */
    public function getSentBroadcast($sender_id) {
		$stmt = $this->conn->prepare("SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE receiver_id = 0 AND sender_id = ?");
		$stmt->bind_param("i", $sender_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
    
    /**
     * Fetching all notice of yourlink
     * @param Int $receiver_role id of the user who sent 
     */
    public function getYourlinkNotice($receiver_role) {
		$stmt = $this->conn->prepare("SELECT *,UNIX_TIMESTAMP(sent_time) AS timestamp FROM messages WHERE sender_role = 0 AND (receiver_role = 123 OR receiver_role = ?)");
		$stmt->bind_param("i", $receiver_role);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

	function getwords($str, $limit){

		$strexp = explode(" ", $str);
		$retsrt = "";
		for($i=0; $i<$limit; $i++){
			if(isset($strexp[$i])){
				$retsrt = $retsrt.$strexp[$i]." ";
			}
			else{
				break;
			}
		}
		$retsrt = $retsrt."... ";
		return $retsrt;
		
	}

   
}

?>
