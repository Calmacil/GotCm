<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 28/12/15
 * Time: 09:19
 */

namespace Got\Core;

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
class Debug
{
    /**
     * @var Debug
     */
    private static $instance;

    /**
     * @var StandardDebugBar
     */
    private $debugBar;

    /**
     * @var JavascriptRenderer
     */
    private $renderer;

    /**
     * Debug constructor.
     * Inits the DebugBar
     */
    private function __construct()
    {
        $this->debugBar = new StandardDebugBar();
        $this->debugBar->addCollector(new PDOCollector());
        $this->renderer = $this->debugBar->getJavascriptRenderer("/debugbar");
    }

    /**
     * Instanciator.
     * @return Debug
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Debug();
        }
        return self::$instance;
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    public static function info($message)
    {
        self::$instance->debugBar["messages"]->log('info', $message);
    }

    public static function warning($message)
    {
        self::$instance->debugBar["messages"]->log('warning', $message);
    }

    public static function error($message)
    {
        self::$instance->debugBar["messages"]->log('error', $message);
    }
}