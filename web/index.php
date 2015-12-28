<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 11:04
 */

define("ROOT", __DIR__.'/..');
require_once ROOT.'/vendor/autoload.php';

use DebugBar\StandardDebugBar;

use \Got\Core\Config;

$conf = new Config(ROOT."/config/config.json");
$router = \Got\Core\Router::getInstance(ROOT."/config/routes.json");

$debug = null;

if (Config::get('debug')) {
    $debug = new StandardDebugBar();
}

$request = new \Got\Core\Request($_SERVER['REQUEST_URI']);
$response = new \Got\Core\Response();
if (Config::get('debug')) {
    $response->setDebugBar($debug);
}
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