<?php

error_reporting(E_ALL | E_STRICT);

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));


require_once 'Zend/Application.php';
require_once 'Zend/Loader/Autoloader.php';

require_once 'ControllerTestCase.php';


//Zend_Loader_Autoloader::getInstance();

//require_once APPLICATION_PATH . '/../library/Zend/Test/PHPUnit/ControllerTestCase.php';
?> 