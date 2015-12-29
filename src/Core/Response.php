<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 12:01
 */

namespace Got\Core;

use Got\Core\TwigExtensions\Functions;

class Response
{

    const STATUS_OK = "200 OK";
    const STATUS_FOUND = "302 Found";
    const STATUS_NOT_FOUND = "404 Not Found";

    const TYPE_HTML = "text/html";
    const TYPE_JSON = "text/json";

    /**
     * @var \Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * The template to render
     * @var string
     */
    private $template;

    /**
     * The variables to be rendered on the template.
     *
     * @var array-of-mixed
     */
    private $template_vars = array();

    private $status = self::STATUS_OK;

    /**
     * Inits the Twig environment
     *
     * Response constructor.
     */
    public function __construct()
    {
        $this->loader = new \Twig_Loader_Filesystem(ROOT.'/templates');
        $this->environment = new \Twig_Environment($this->loader, array(
            'cache' => ROOT.'/cache/twig/',
            'debug' => Config::get('debug')
        ));

        // register new functions
        $function_names = get_class_methods("\\Got\\Core\\TwigExtensions\\Functions");
        foreach ($function_names as $func_name) {
            $func = new \Twig_SimpleFunction($func_name, array("\\Got\\Core\\TwigExtensions\\Functions", $func_name));
            $this->environment->addFunction($func);
        }
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template . '.twig';
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function assign($key, $value)
    {
        $this->template_vars[$key] = html_entity_decode($value);
    }

    /**
     * Renders output
     */
    public function render()
    {
        if (Config::get('debug')) {
            $this->assign('DEBUGBAR_HEADER',Debug::getInstance()->getRenderer()->renderHead());
            $this->assign('DEBUGBAR', Debug::getInstance()->getRenderer()->render());
        }
        $content = $this->environment->render($this->template, $this->template_vars);

        ob_clean();

        ob_start();
        header("HTTP/1.1 " . $this->status);
        header("Content-Type: " . self::TYPE_HTML);
        echo $content;
        ob_end_flush();
    }

    /**
     * Renders output as JSON
     */
    public function renderJson()
    {
        $content = $this->environment->render($this->template, $this->template_vars);

        ob_clean();

        ob_start();
        header("HTTP/1.1 " . $this->status);
        header("Content-Type: " . self::TYPE_JSON);
        echo $content;
        ob_end_flush();
    }
}