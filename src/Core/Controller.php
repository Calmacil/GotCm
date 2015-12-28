<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 18:58
 */

namespace Got\Core;


use Psr\Log\InvalidArgumentException;

class Controller
{
    /**
     * @var string|array
     */
    protected $template;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Controller constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getTemplate($action_name=null)
    {
        if (is_array($this->template)) {
            if(!$action_name) {
                throw new InvalidArgumentException("\$action_name needs to be specified");
            }

            if (!array_key_exists($action_name, $this->template)) {
                throw new InvalidArgumentException("Key $action_name not found the templates list");
            }

            return $this->template[$action_name];
        }
        return $this->template;
    }

    /**
     * @param string $param
     * @return mixed
     */
    protected function get($param)
    {
        return $this->request->get($param);
    }

    /**
     * @param string $param
     * @return mixed
     */
    protected function post($param)
    {
        return $this->request->post($param);
    }

    /**
     * @todo implement
     */
    protected function display404()
    {
        return;
    }

}