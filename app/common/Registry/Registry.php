<?php

namespace app\common;


use app\common\DB\CinemaManager;
use app\common\DB\RatingManager;
use Doctrine\Common\Cache as DCache;

/**
 * Class Registry
 * @package app\common
 */
class Registry
{
    private static $instance = null;
    private static $conf = null;

    private function __construct()
    {
    }

    /**
     * @return Registry
     */
    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *
     */
    public function setConf()
    {
        if (self::$conf === null) {
            self::$conf = require_once __DIR__ . '/../../../conf/conf.php';
        }
    }

    /**
     * @return array
     */
    public function getConf(): array
    {
        $this->setConf();
        return self::$conf;
    }

    /**
     * @return CinemaManager
     */
    public function getCinemaManager(): CinemaManager
    {
        return new CinemaManager();
    }

    /**
     * @return RatingManager
     */
    public function getRatingManager(): RatingManager
    {
        return new RatingManager();
    }


    /**
     * @return Cache
     */
    public function getCache(): Cache
    {
        return new Cache(__DIR__ . '/../../../storage/cache');
    }




}