<?php
/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 29/12/15
 * Time: 23:55
 */

namespace Got\Core;


class Db
{
    /**
     * @var \PDO
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
        $dsn = sprintf("%s:host=%s;dbname=%s", Config::get('db')->dbtype, Config::get('db')->host, Config::get('db')->dbname);
        Debug::info("Establishing DB connection for $dsn");

        try {
            $this->pdo = new \PDO($dsn, Config::get('db')->user, Config::get('db')->password);
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
}