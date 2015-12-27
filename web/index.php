<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 27/12/15
 * Time: 11:04
 */

define("ROOT", __DIR__.'/..');
require_once ROOT.'/vendor/autoload.php';

use \Got\Core\Config;

$conf = new Config(ROOT."/config/config.json");

var_dump($conf::get("Db")->host);