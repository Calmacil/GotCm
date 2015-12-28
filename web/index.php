<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 11:04
 */

define("ROOT", __DIR__.'/..');
require_once ROOT.'/vendor/autoload.php';

use \Got\Core\Config;
use \Got\Core\Debug;
use \Got\Core\Router;
use \Got\Core\Response;
use \Got\Core\Request;

$conf = new Config(ROOT."/config/config.json");
if (Config::get('debug')) {
    $debug = Debug::getInstance();
}

$router = Router::getInstance(ROOT."/config/routes.json");
$request = new Request($_SERVER['REQUEST_URI']);
$response = new Response();

try {
    $request->proceed();

    $controller_name = ucfirst($request->getController());
    $action_name = $request->getAction() . 'Action';

    $class = '\\Got\\Action\\' . $controller_name;
    $controller = new $class($request, $response);

    if (!method_exists($controller, $action_name) || !$controller->{$action_name}()) {
        header('HTTP/1.1 404 Not Found');
        echo "BOUH";
        die;
    }

    $response->setTemplate($controller->getTemplate($action_name));
    $response->render();
} catch(Exception $e) {
    echo "<pre>$e</pre>";
}