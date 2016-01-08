<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 12:02
 */

namespace Got\Core;


use Psr\Log\InvalidArgumentException;

class Router
{
    /**
     * Unique instance.
     * @var \Got\Core\Router
     */
    private static $_instance;

    /**
     * Array of Routes
     * @var array-of-Route<string>
     */
    private $_routes = array();

    private function __construct()
    {

    }

    /**
     * Loads the router from given file
     * @param $routes_file string     Json routes file
     */
    public function load($routes_file)
    {
        if (!is_file($routes_file)) {
            throw new InvalidArgumentException("The given routes file does not exist", 004, E_USER_ERROR);
        }

        $json = file_get_contents($routes_file);
        $routes = json_decode($json, true);

        if(!$routes) {
            print_r(json_last_error_msg());
        }

        foreach ($routes as $route_name => $route_settings) {
            $this->_routes[$route_name] = new Route($route_name, $route_settings);
        }
    }

    /**
     * Instanciator for the singleton.
     *
     * @param string $routes_file
     * @return Router
     */
    public static function getInstance($routes_file = null)
    {
        if(!self::$_instance) {
            self::$_instance = new Router();
            if ($routes_file) {
                self::$_instance->load($routes_file);
            }
        }

        return self::$_instance;
    }

    /**
     * @param string $name
     * @return Route
     * @throws \ErrorException
     */
    public function getRoute($name)
    {
        if (!array_key_exists($name, $this->_routes)) {
            throw new \ErrorException("The route $name does not exist.", 005, E_USER_WARNING);
        }
        return $this->_routes[$name];
    }

    /**
     * Generates the given route with given params
     *
     * @param $name string          The route's name
     * @param $params array|null         The params to insert
     * @return mixed|string
     * @throws \ErrorException
     */
    public function generateRoute($name, $params=null)
    {
        return $this->getRoute($name)->generate($params);
    }

    /**
     * Searches a matching route for the given $uri
     *
     * @param string $uri
     * @return bool|\Got\Core\Route
     */
    public function search($uri)
    {
        foreach($this->_routes as $name => $route) {
            if ($route->check($uri)) {
                return $route;
            }
        }
        return false;
    }

}