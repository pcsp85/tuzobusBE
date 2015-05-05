<?php
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("classes/password_compatibility_library.php");
}
require_once('classes/db_config.php');
require_once('classes/Registration.php');

$_POST = array(
	'register'=>true,
	'user_name'=> 'Admin',
	'user_password_new' => 'tuz08u5',
	'user_password_repeat' => 'tuz08u5',
	'user_email' => 'pcsp85@gmail.com',
	'name' => 'PAblo César Sánchez Porta'
	);



$admin = new Registration();
