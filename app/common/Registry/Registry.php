<?php

namespace app\common;


use app\common\DB\CinemaManager;

class Registry
{
    private static $instance = null;
    private static $conf = null;

    private function __construct()
    {
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setConf()
    {
        if (self::$conf === null) {
            self::$conf = require_once __DIR__ . '\..\..\..\conf\conf.php';
        }
    }

    public function getConf()
    {
        $this->setConf();
        return self::$conf;
    }

    public function getCinemaManager()
    {
        return new CinemaManager();
    }




}