<?php

namespace app\common\DB;


use app\common\Registry\Registry;
use PDO;

/**
 * Class Base
 * @package app\common\DB
 */
abstract class Base
{
    private $pdo;
    private $conf = null;
    private $reg = null;

    public function __construct()
    {
        $this->reg = Registry::instance();
        $this->conf = $this->reg->getConf();

        if (!isset($this->conf['dsn'])) {
            throw new \PDOException("DSN не определен!");
        }

        if (!isset($this->conf['db_user'])) {
            throw new \PDOException("db_user не определен!");
        }

        if (!isset($this->conf['db_password'])) {
            throw new \PDOException("db_password не определен!");
        }

        $this->pdo = new PDO($this->conf['dsn'], $this->conf['db_user'], $this->conf['db_password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}