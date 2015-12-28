<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 21:25
 */

namespace Got\Core\TwigExtensions;


use Got\Core\Router;

class Functions
{
    /**
     * @param $route_name
     * @param $params
     * @return mixed|string
     */
    public static function url($route_name, $params)
    {
        return Router::getInstance()->generateRoute($route_name, $params);
    }
}