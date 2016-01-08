<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 29/12/15
 * Time: 23:55
 */

namespace Got\Core;


use DebugBar\DataCollector\PDO\TraceablePDO;

class Db
{
    /**
     * @var \PDO | TraceablePDO
     */
    private $pdo;

    /**
     * @var Db
     */
    private static $instance;

    /**
     * Db constructor.
     *
     * Sets up the PDO dsn and establishes connection
     */
    private function __construct()
    {
        $conf = Config::get('db');
        $dsn = sprintf("%s:host=%s;dbname=%s", $conf->dbtype, $conf->host, $conf->dbname);
        Debug::info("Establishing DB connection for $dsn");

        try {
            //$pdo = new \PDO($dsn, $conf->user, $conf->password);;
            if (Config::get('debug')) {
                $this->pdo = new TraceablePDO(new \PDO($dsn, $conf->user, $conf->password));
                Debug::info("Adding PDO collector to the dbug");
            } else {
                $this->pdo = new \PDO($dsn, $conf->user, $conf->password);
            }
            $this->pdo->query('SET NAMES utf8');
        }
        catch(\PDOException $e) {
            Debug::error("Cannot establish database connection:\n{$e->getMessage()}\n{$e->getTraceAsString()}");
        }
    }

    /**
     * Db instanciator.
     *
     * @return Db
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    /**
     * Executes a SQL query with PDO.
     * @param string $query
     * @param mixed [$arg1]
     * @param mixed [$arg2]
     *
     * Use as many params as needed
     *
     * @return bool|\PDOStatement
     */
    public function exec($query)
    {
        $params = "";
        if (func_num_args()) {
            $params = implode(', ', func_get_args());
        }

        $q = $params ?
            sprintf($query, eval($params)) :
            $query;

        try {
            $data = $this->pdo->query($q);
            return $data;
        } catch(\PDOException $e) {
            Debug::error("SQL Query failed:\n{$e->getMessage()}\n{$e->getTraceAsString()}");
        }

        return false;
    }

    /**
     * Use it only for debugbar
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->pdo;
    }
}