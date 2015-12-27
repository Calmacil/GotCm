<?php
namespace Got\Core;
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 11:17
 */
class Config
{
    /**
     * @var string $_file
     */
    private $_file;

    /**
     * @var array
     */
    private static $_settings;

    public function __construct($file)
    {
        $this->_file = $file;
        $this->load();
    }

    /**
     * @throws \ErrorException
     */
    private function load()
    {
        $file = file_get_contents($this->_file);
        if (!$file) {
            throw new \ErrorException("Impossible to read config file", 000, E_ERROR);
        }
        self::$_settings = json_decode($file, false);

        if (!self::$_settings) {
            throw new \ErrorException("Impossible to load config file", 001, E_ERROR);
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key=null)
    {
        if ($key) {
            return self::$_settings->{$key};
        }
        return self::$_settings;
    }


}