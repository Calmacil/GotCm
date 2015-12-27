<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 12:01
 */

namespace Got\Core;


class Route
{
    /**
     * @var string $_controller
     */
    private $_controller;

    /**
     * @var string $_name
     */
    private $_name;

    /**
     * @var array $_params
     */
    private $_params;

    /**
     * @var string $_action
     */
    private $_action = "exec";

    /**
     * @var string $_regex
     */
    private $_regex;

    /**
     * Route constructor.
     * @param $name         The name of the route
     * @param $settings     The settings taken from routes.json
     */
    public function __construct($name, $settings)
    {
        if (!array_key_exists('regex', $settings) || !array_key_exists('controller', $settings)) {
            throw new \ErrorException("Route $name needs at least 'controller' and 'regex' keys", 002, E_ERROR);
        }

        $this->_name = $name;
        $this->_controller = $settings['controller'];
        $this->_regex = $settings['regex'];
        if (array_key_exists('params', $settings)) $this->_params = $settings['params'];
        if (array_key_exists('action', $settings)) $this->_action = $settings['action'];

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Generates a URL for the Route's name with the given params
     * @todo implement
     *
     * @param $params
     */
    public function generate($params)
    {

    }

}