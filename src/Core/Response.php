<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 12:01
 */

namespace Got\Core;

use DebugBar\DebugBar;
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
     * @var DebugBar
     */
    private $debug_bar;

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
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template . '.twig';
    }

    public function setDebugBar($debug_bar)
    {
        $this->debug_bar= $debug_bar;
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
        if ($this->debug_bar) {
            $renderer = $this->debug_bar->getJavascriptRenderer('/debugbar');

            $this->assign('DEBUGBAR_HEADER', $renderer->renderHead());
            $this->assign('DEBUGBAR', $renderer->render());
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