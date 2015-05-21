<?php
/**
 * Database configuration
 */
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '123');
//define('DB_PASSWORD', '123456');
define('DB_HOST', 'localhost');
define('DB_NAME', 'yourlink');

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);
define('USER_EMAIL_NOT_MATCH', 3);

define('REPLY_TO_EMAIL','webmaster@paraexist.inof');
define('YOURLINK_EMAIL','webmaster@yourlink.com');

define('ROW_PER_PAGE', 20);

define('NUMBER_OF_NOTIFICATION', 5);
define('NOTIFICATION_DURATION_DAYS', 5);

define('ROOT_PATH', "http://localhost:8080/yourlink/");
//define('ROOT_PATH', "http://yourlink.paraexist.info/latest/");
?>
