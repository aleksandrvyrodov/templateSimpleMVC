<?php
    // ini_set('error_reporting', E_ALL);
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);

    define('ROOT', $_SERVER['DOCUMENT_ROOT']);     

    include(ROOT.'/vendor/autoload.php');

    use Rout\Router;   
	
	$router = new Router();   
    $router->run();
?>