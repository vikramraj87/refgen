<?php
use \Kivi\Log as Log;

defined("ROOT_DIR")
|| define("ROOT_DIR", realpath(dirname(__FILE__) . "/../"));

defined("APPLICATION_DIR")
|| define("APPLICATION_DIR", ROOT_DIR . "/application");

defined("APPLICATION_ENV")
|| define("APPLICATION_ENV", getenv("APPLICATION_ENV") ? getenv("APPLICATION_ENV") : "PRODUCTION");

set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), ROOT_DIR . "/library")));

spl_autoload_register(function($class){
	$parts = explode("\\", $class);
	
	//Autoloading Kivi classes
	if($parts[0] == "Kivi") {
		$parts[count($parts) - 1] .= ".php";
		$file = implode("/", $parts);
		require_once $file; 
	}
	
	//Models
	if($parts[0] == "Model") {
		$parts[0] = APPLICATION_DIR . "/models";
        $parts[count($parts) - 1] .= ".php";
		$file = implode("/", $parts);
		require_once $file;
	}
	
});
$registry = \Kivi\Registry::getInstance();


$registry->config = new \Kivi\Config\Xml(APPLICATION_DIR . "/configs/site.xml", "development");
/*
try {
    $dbh = null;
    $dbh = new PDO("mysql:host=localhost;dbname=log", "root", "K1rth1k@s1n1");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $registry->log = new Log;
    $registry->log->registerErrorHandler();
    $dbWriter = new Log\Writer\Db($dbh, "event_log");
    $registry->log->addWriter($dbWriter);
} catch (PDOException $e) {

}
*/

/*try {*/
    $front = \Kivi\Controller\Front::getInstance();
    $front->run();
/*
} catch (\Kivi\Controller\ControllerNotFoundException $ce) {
    echo $ce->getMessage();
    //header("Location: /404.html");
} catch (\Kivi\Controller\ActionNotFoundException $ae) {
    echo $ae->getMessage();
    //header("Location: /404.html");
} catch(\Exception $e) {
    $reflection  = new \ReflectionClass($e);
    $eClass      = get_class($e);
    $eProperties = $reflection->getProperties();
    $message     = $e->getMessage();
    $extra       = array();

    foreach($eProperties as $p) {
        $property = trim($p->getName(), "_");
        if($property !== "message") {
            $getter = "get" . ucfirst($property);
            if($reflection->hasMethod($getter)) {
                $extra[$property] = call_user_func(array($e, $getter));
            }
        }
    }
    //$registry->log->fatal($message, $extra);
    echo $e->getMessage();
    if(APPLICATION_ENV == "PRODUCTION") {
        //header("Location: /500.html");
    }
}

*/