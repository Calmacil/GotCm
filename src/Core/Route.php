<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 12:01
 */

namespace Got\Core;


use Psr\Log\InvalidArgumentException;

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
     * @var string $_pattern
     */
    private $_pattern;

    /**
     * @var array
     */
    private $_httpParams = array();

    /**
     * Route constructor.
     * @param string $name          The name of the route
     * @param array $settings       The settings taken from routes.json
     * @throws \ErrorException      If given $settings does not contains `pattern` or `controller` keys. Other keys are
     *                              fully optional.
     */
    public function __construct(string $name, array $settings)
    {
        if (!array_key_exists('pattern', $settings) || !array_key_exists('controller', $settings)) {
            throw new \ErrorException("Route $name needs at least 'controller' and 'regex' keys", 002, E_ERROR);
        }

        $this->_name = $name;
        $this->_controller = $settings['controller'];
        $this->_pattern = $settings['regex'];
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
     * @param $key
     * @return array
     */
    public function getHttpParams($key)
    {
        if (!array_key_exists($key, $this->_httpParams)) {
            throw new InvalidArgumentException("Parameter $key not found in route {$this->_name}.");
        }
        return $this->_httpParams;
    }

    /**
     * Generates a URL for the Route's name with the given params
     * @todo add security check for missing params
     *
     * @param $params
     */
    public function generate(array $params)
    {
        $uri = "/" . $this->_pattern;

        foreach (array_keys($this->_params) as $key) {
            $uri = str_replace(":$key:", $params[$key], $uri);
        }
        return $uri;
    }

    /**
     * Checks $url against the Route's pattern and extracts it's params values
     * @param $url string
     * @return bool
     */
    public function check(string $url)
    {
        $formatted_regex = $this->_pattern;
        foreach ($this->_params as $param => $format) {
            $formatted_regex = str_replace(":$param:", $format, $formatted_regex);
        }

        if (!preg_match("#$formatted_regex#", $url, $matches)) {
            return false;
        }

        // Need to extract params position: never trust user input
        $par_pos = $this->computeParamsPosition();

        foreach (array_keys($this->_params) as $param) {
            $this->_httpParams[$param] = $matches[array_search($param, $par_pos)];
        }

        return true;
    }

    /**
     * Computes params position in the pattern
     * @return array
     */
    private function computeParamsPosition()
    {
        preg_match("#:" . implode(':|:', $this->_params) . ":#", $this->_pattern, $matches);
        //array_shift($matches);
        return $matches;
    }

}