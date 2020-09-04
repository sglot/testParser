<?php


namespace app\controllers;
use app\common\Registry;

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