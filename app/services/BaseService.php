<?php


namespace app\services;
use app\common\Registry\Registry;

class BaseService
{
    protected $reg;
    protected $cache;

    public function __construct()
    {
        $this->reg = Registry::instance();
        $this->cache = $this->reg->getCache();
    }
}