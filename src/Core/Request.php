<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 12:01
 */

namespace Got\Core;


use Psr\Log\InvalidArgumentException;

class Request
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var \Got\Core\Route
     */
    private $route;

    /**
     * @var array-of-mixed
     */
    private $post_params = array();

    /**
     * Request constructor.
     * @param string $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;

        foreach($_POST as $key => $value) {
            $this->post_params[$key] = addslashes(htmlspecialchars(trim($value)));
        }
    }

    /**
     * Sets the correct route corresponding to request URI
     */
    public function proceed()
    {
        $this->route = Router::getInstance()->search($this->uri);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function post($key)
    {
        if (!array_key_exists($key, $this->post_params)) {
            throw new InvalidArgumentException("Parameter $key does not exist in the request POST parameters");
        }
        return $this->post_params[$key];
    }
}